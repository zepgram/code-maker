<?php
/**
 * This file is part of Zepgram\CodeMaker
 *
 * @package    Zepgram\CodeMaker
 * @file       AbstractCommand.php
 * @date       31 08 2019 15:43
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Zepgram\CodeMaker\Generator\Templates;

class BaseCommand extends Command
{
    /**
     * @var array
     */
    const MAGENTO_AREA = [
        'base',
        'frontend',
        'adminhtml',
        'crontab',
        'webapi_rest',
        'webapi_soap',
        'graphql'
    ];

    /**
     * @var Maker
     */
    public $maker;

    /**
     * @var array
     */
    public $parameters;

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $output->write("\n");
        $helper = $this->getHelper('question');

        $question = $this->formattedQuestion('Enter the name of the module', 'Zepgram_Dev', true);
        $question->setValidator(static function ($answer) {
            if (!is_string($answer) || strpos($answer, '_') === false) {
                throw new \RuntimeException(
                    'Namespace and module name must be separated by "_"'
                );
            }

            return $answer;
        });
        $question->setMaxAttempts(2);

        $module = $helper->ask($input, $output, $question);
        $this->maker = new Maker($module, $this->getCommandSkeleton());

        if (!empty($this->getParameters())) {
            $this->parameters = $this->askParameters($input, $output);
        }
    }

    /**
     * Main entry point
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Templates
        $templates = new Templates($this->maker);

        // Handle confirmation
        $confirmed = $templates->getConfirmOperation();
        if (!empty($confirmed && is_array($confirmed))) {
            foreach ($confirmed as $filePath => $content) {
                $output->write("\n");
                $output->writeln("<info>File</info> $filePath <info>already exist</info>");
                $question = new ConfirmationQuestion('<info>Do you want to override existing files ?</info>');
                if (!$this->getHelper('question')->ask($input, $output, $question)) {
                    continue;
                }
                $templates->addWriteOperation($filePath, $content);
            }
        }

        // Write
        $templates->generate();
        $append = $templates->getAppendOperation();
        $created = $templates->getWriteOperation();

        // Print
        if (empty($append) && empty($created)) {
            $output->writeln("\nNo change detected");
            return;
        }
        $this->printFiles(['created' => $created, 'modified' => $append], $output);
    }

    /**
     * @return mixed
     */
    protected function getCommandSkeleton()
    {
        return explode(':', $this->getName())[1];
    }

    /**
     * @return array
     */
    protected function getParameters()
    {
        return [];
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    /**
     * @param array $statements
     * @param OutputInterface $output
     */
    private function printFiles(array $statements, OutputInterface $output)
    {
        $moduleName = $this->maker->getModuleDirectory();
        $output->write("\n");
        $output->writeln("--- $moduleName ---");
        foreach ($statements as $state => $statement) {
            if (!empty($statement)) {
                foreach ($statement as $fileName => $content) {
                    $output->writeln("<info>$state</info>: $fileName");
                }
            }
        }
        $output->write("\n");
    }

    /**
     * @param string $question
     * @param string $comment
     * @param null $default
     *
     * @return Question
     */
    private function formattedQuestion(string $question, string $comment = null, $default = null)
    {
        $question = FormatString::getPhrase($question);
        if ($comment) {
            $default = $default ? $comment : null;
            return new Question("<info>$question (e.g. <comment>$comment</comment>)</info>:\r\n > ", $default);
        }

        return new Question("<info>$question</info>:\r\n > ");
    }


    /**
     * @param string $parameter
     * @param array  $values
     *
     * @return ChoiceQuestion
     */
    private function formattedChoiceQuestion(string $parameter, array $values)
    {
        $parameter = FormatString::getPhrase($parameter);
        return new ChoiceQuestion(
            "Please select parameter '$parameter'",
            $values,
            $values[0]
        );
    }

    /**
     * @param $input
     * @param $output
     *
     * @return array
     */
    private function askParameters($input, $output)
    {
        $answers = [];
        foreach ($this->getParameters() as $parameter => list($comment, $function)) {
            $helper = $this->getHelper('question');
            if ($comment === 'choice_question') {
                $question = $this->formattedChoiceQuestion($parameter, $function);
                $answers[$parameter] = $helper->ask($input, $output, $question);
                continue;
            }
            $question = $this->formattedQuestion("Which value do you want for your $parameter", $comment, true);
            $question->setValidator(static function ($answer) {
                if (empty($answer)) {
                    throw new \RuntimeException(
                        'Please enter a value'
                    );
                }

                return $answer;
            });
            $value = $helper->ask($input, $output, $question);
            if (method_exists(FormatString::class, $function)) {
                $value = FormatString::$function($value);
            }
            $answers[$parameter] = $value;
        }

        return $answers;
    }

    /**
     * @param $input
     * @param $output
     * @param $fields
     *
     * @return array
     */
    protected function sequencedQuestion($input, $output, array $fields = [])
    {
        $isFirstField = true;
        while (true) {
            if ($isFirstField) {
                $questionText = 'New property name (press <return> to stop adding fields)';
            } else {
                $questionText = 'Add another property? Enter the property name (or press <return> to stop adding fields)';
            }
            $isFirstField = false;
            $newField = $this->askForNextField($input, $output, $fields, $questionText);

            if (null === $newField) {
                break;
            }
            if ($newField) {
                $fields = $newField;
            }
        }

        if (empty($fields)) {
            throw new InvalidArgumentException('Please enter at least one field.');
        }

        return $fields;
    }

    /**
     * @param        $input
     * @param        $output
     * @param array  $fields
     * @param string $questionText
     *
     * @return string|string[]|null
     */
    protected function askForNextField($input, $output, array $fields, string $questionText)
    {
        $question = $this->formattedQuestion($questionText);
        $helper = $this->getHelper('question');
        $fieldName = $helper->ask($input, $output, $question);

        if (!$fieldName) {
            return null;
        }

        foreach ($fields as $fieldKey => $values) {
            if ($fieldKey) {
                if (FormatString::asSnakeCase($fieldName) === FormatString::asSnakeCase($fieldKey)) {
                    $output->writeln(sprintf('<error>The "%s" property already exists.</error>', $fieldName));

                    return false;
                }
            }
        }

        foreach ($this->getOptions() as $parameter => $option) {
            if (is_array($option)) {
                $question = $this->formattedChoiceQuestion($parameter, $option);
            } else {
                $parameter = $option;
                $question = $this->formattedQuestion("Add '$option' for field '$fieldName' (optional)");
            }

            $fields[FormatString::asSnakeCase($fieldName)][$parameter] = $helper->ask($input, $output, $question);
        }

        return $fields;
    }
}
