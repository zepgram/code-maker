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
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Zepgram\CodeMaker\File\Management;
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
        $injected = $templates->getInjectionOperation();

        // Print
        if (empty($append) && empty($created) && empty($injected)) {
            $output->writeln("\nNo change detected");
            return;
        }
        $this->printFiles(['created' => $created, 'modified' => $append, 'injected' => $injected], $output);
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
        return new ChoiceQuestion(
            "Please select your $parameter",
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
     * @param array $fields
     * @param bool  $isFirstField
     *
     * @return string|string[]|null
     */
    protected function askForNextField($input, $output, array $fields, bool $isFirstField)
    {
        if ($isFirstField) {
            $questionText = 'New property name (press <return> to stop adding fields)';
        } else {
            $questionText = 'Add another property? Enter the property name (or press <return> to stop adding fields)';
        }
        $question = $this->formattedQuestion($questionText);
        $helper    = $this->getHelper('question');
        $fieldName = $helper->ask($input, $output, $question);

        foreach ($fields as $field) {
            if ($field) {
                if (in_array(strtolower($fieldName), array_map(FormatString::class . '::lowercase', $field), false)) {
                    $output->writeln(sprintf('<error>The "%s" property already exists.</error>', $fieldName));

                    return false;
                }
            }
        }

        if (!$fieldName) {
            return null;
        }

        $question = $this->formattedChoiceQuestion('type', ['string','int','bool','array']);
        $fieldType = $helper->ask($input,$output, $question);

        return ['value' => FormatString::asSnakeCase($fieldName), 'type' => $fieldType];
    }
}
