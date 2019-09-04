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
use Zepgram\CodeMaker\Generator\Templates;

class BaseCommand extends Command
{
    const MAGENTO_DEVELOPMENT_DIRECTORY = '/app/code';

    /**
     * @var Maker
     */
    public $maker;

    /**
     * @var string
     */
    public $module;

    /**
     * @var array
     */
    public $parameters;

    /**
     * @return bool
     */
    protected function isModuleInitialized()
    {
        return file_exists($this->maker->getAbsolutePath().'/registration.php');
    }

    /**
     * @return array
     */
    protected function getParameters()
    {
        return [];
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $output->write("\n");
        $helper = $this->getHelper('question');
        $question = $this->formattedQuestion('Enter the name of the module', 'Zepgram_Test', true);
        $question->setValidator(static function ($answer) {
            if (!is_string($answer) || strpos($answer, '_') === false) {
                throw new \RuntimeException(
                    'Namespace and module name must be separated by "_"'
                );
            }

            return $answer;
        });
        $question->setMaxAttempts(2);

        $this->module = $helper->ask($input, $output, $question);
        $this->setMaker();

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
        // Is module initialized
        $this->maker->setIsInitialized($this->isModuleInitialized());

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
        $output->write("\n");
        $output->write("<comment>--- Module $this->module ---</comment>\r\n");
        if (!empty($append) && is_array($append)) {
            $this->printFiles('modified', $append, $output);
        }
        if (!empty($created) && is_array($created)) {
            $this->printFiles('created', $created, $output);
        }
        $output->write("\n");
    }

    /**
     * @return mixed
     */
    private function getCommandSkeleton()
    {
        return explode(':', $this->getName())[1];
    }

    /**
     * @param string $statement
     * @param array $files
     * @param OutputInterface $output
     */
    private function printFiles(string $statement, array $files, OutputInterface $output)
    {
        foreach ($files as $fileName => $content) {
            $output->writeln("<info>$statement</info>: $fileName");
        }
    }

    /**
     * Set maker instance
     */
    private function setMaker()
    {
        list($vendor, $moduleName) = explode('_', $this->module);
        $vendor = Format::ucwords($vendor);
        $moduleName = Format::ucwords($moduleName);
        $appDirectory = getcwd() . self::MAGENTO_DEVELOPMENT_DIRECTORY;

        $this->maker = new Maker();
        $this->maker->setModuleNamespace($vendor . "\\" . $moduleName)
            ->setAbsolutePath("$appDirectory/$vendor/$moduleName")
            ->setTemplateSkeleton([$this->getCommandSkeleton()])
            ->setTemplateParameters([
                'module_name'      => $moduleName,
                'module_namespace' => $vendor,
                'lower_namespace'  => Format::lowercase($vendor),
                'lower_module'     => Format::lowercase($moduleName)
            ]);
    }

    /**
     * @param      $question
     * @param bool $comment
     * @param null $default
     *
     * @return Question
     */
    private function formattedQuestion($question, $comment = false, $default = null)
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
     * @param            $input
     * @param            $output
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
            if (method_exists(Format::class, $function)) {
                $value = Format::$function($value);
            }
            $answers[$parameter] = $value;
        }

        return $answers;
    }
}
