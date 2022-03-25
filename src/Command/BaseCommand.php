<?php

/*
 * This file is part of Zepgram Code Maker.
 * (c) Benjamin Calef <bcalef.pro@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Zepgram\CodeMaker\Editor\Entities;
use Zepgram\CodeMaker\Maker;
use Zepgram\CodeMaker\Str;

abstract class BaseCommand extends Command
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
     * @var Entities
     */
    public $entities;

    /**
     * @var array
     */
    public $parameters = [];

    /**
     * @return array
     */
    abstract protected function getParameters();

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    /**
     * @return mixed
     */
    protected function getCommandSkeleton()
    {
        return explode(':', $this->getName())[1];
    }

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
        $this->entities = new Entities($this->maker);

        if (!empty($this->getParameters())) {
            $this->parameters = $this->askParameters($input, $output);
        }
        if (!empty($this->getOptions())) {
            $this->parameters['option_fields'] = $this->askOptions($input, $output);
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
        // Populate entities
        $this->entities->populate($this->parameters);
        $templates = $this->entities->initTemplates();

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
        $question = Str::getPhrase($question);
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
        $parameter = Str::getPhrase($parameter);
        return new ChoiceQuestion(
            "Please select parameter '$parameter'",
            $values,
            $values[0]
        );
    }

    /**
     * @param string $parameter
     * @return ChoiceQuestion
     */
    private function formattedYesNoQuestion(string $parameter)
    {
        $parameter = Str::getPhrase($parameter);
        return new ChoiceQuestion(
            "Please select parameter '$parameter'",
            ['no','yes'],
            'no'
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
        foreach ($this->getParameters() as $parameter => $actions) {
            if ($this->mustSkip($answers)) {
                continue;
            }
            /** @var QuestionHelper $helper */
            $helper = $this->getHelper('question');

            $choiceQuestion = $actions['choice_question'] ?? null;
            if ($choiceQuestion) {
                $question = $this->formattedChoiceQuestion($parameter, $choiceQuestion);
                $answers[$parameter] = $helper->ask($input, $output, $question);
                continue;
            }
            $yesNoQuestion = $actions[0] ?? null;
            if ($yesNoQuestion === 'yes_no_question') {
                $question = $this->formattedYesNoQuestion($parameter);
                $answers[$parameter] = $helper->ask($input, $output, $question) === 'yes';
                continue;
            }

            $default = $actions['default'] ?? null;
            $question = $this->formattedQuestion("Which value do you want for your $parameter", $default, true);
            $question->setValidator(static function ($answer) {
                if (empty($answer)) {
                    throw new \RuntimeException(
                        'Please enter a value.'
                    );
                }

                return $answer;
            });
            $answer = $helper->ask($input, $output, $question);

            $formatter = $actions['formatter'] ?? null;
            if (method_exists(Str::class, $formatter)) {
                $answer = Str::$formatter($answer);
            }
            $answers[$parameter] = $answer;
        }

        return $answers;
    }

    /**
     * @param $input
     * @param $output
     *
     * @return array
     */
    private function askOptions($input, $output)
    {
        $fields = [];
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
    private function askForNextField($input, $output, array $fields, string $questionText)
    {
        $question = $this->formattedQuestion($questionText);
        /** @var QuestionHelper $helper */
        $helper = $this->getHelper('question');
        $fieldName = $helper->ask($input, $output, $question);

        if (!$fieldName) {
            return null;
        }

        foreach ($fields as $fieldKey => $values) {
            if ($fieldKey && Str::asSnakeCase($fieldName) === Str::asSnakeCase($fieldKey)) {
                $output->writeln(sprintf('<error>The "%s" property already exists.</error>', $fieldName));

                return false;
            }
        }

        foreach ($this->getOptions() as $parameter => $option) {
            if (is_array($option)) {
                $question = $this->formattedChoiceQuestion($parameter, $option);
            } else {
                $parameter = $option;
                $question = $this->formattedQuestion("Add '$option' for field '$fieldName' (optional)");
            }

            $fields[Str::asSnakeCase($fieldName)][$parameter] = $helper->ask($input, $output, $question);
        }

        return $fields;
    }

    /**
     * @param array $answer
     * @return bool
     */
    private function mustSkip(array $answer)
    {
        if (isset($answer['cron_group']) && $answer['cron_group'] === 'default') {
            return true;
        }

        return false;
    }
}
