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
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Zepgram\CodeMaker\Generator\Templates;

class BaseCommand extends Command
{
    const MAGENTO_DEVELOPMENT_DIRECTORY = '/app/code/';

    /**
     * @var Maker
     */
    public $generator;

    /** @var string */
    public $module;

    /** @var bool */
    public $force = false;

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

        list($namespace, $moduleName) = explode('_', $this->module);

        $templatesParameters = [
            'name_space' => ucfirst($namespace . "\\" . $moduleName),
            'module_name' => ucfirst($moduleName),
            'module_namespace' => ucfirst($namespace),
            'lower_namespace' => strtolower($namespace),
            'lower_module' => strtolower($moduleName)
        ];
        $this->generator = new Maker();
        $this->generator
            ->setAppDirectory($this->getAppDirectory())
            ->setNameSpace($namespace)
            ->setModuleName($moduleName)
            ->setTemplateSkeleton([$this->getCommandSkeleton()])
            ->setTemplateParameters($templatesParameters);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->moduleExist() && $this->getName() === 'create:module') {
            $output->write("\n");
            $output->writeln("<info>Module</info> $this->module <info>already exist</info>");
            $question = new ConfirmationQuestion('<info>Do you want to override existing files ?</info>');
            if (!$this->getHelper('question')->ask($input, $output, $question)) {
                return;
            }
            $this->force = true;
        }
        $this->initializeModule();

        $template = new Templates($this->generator);
        $createdFiles = $template->writeTemplates();

        $output->write("\n");
        foreach ($createdFiles as $file) {
            $output->writeln("<info>created</info>: $file");
        }
        $output->write("\n");
    }

    protected function initializeModule()
    {
        if ($this->force === false && $this->moduleExist()) {
            return;
        }
        $this->generator
        ->setTemplateSkeleton(array_merge($this->generator->getTemplateSkeleton(), ['module']))
        ->setFilesPath(array_merge([
            'module.tpl.php'       => 'etc/module.xml',
            'registration.tpl.php' => 'registration.php',
            'composer.tpl.php'     => 'composer.json'
        ], $this->generator->getFilesPath()));
    }

    protected function formattedQuestion($question, $comment = false, $default = null)
    {
        if ($comment) {
            $default = $default ? $comment : null;
            return new Question("<info>$question (e.g. <comment>$comment</comment>)</info>:\r\n > ", $default);
        }

        return new Question("<info>$question</info>:\r\n > ");
    }

    protected function askParameters($parameters, $input, $output)
    {
        $answers = [];
        foreach ($parameters as $parameter => $value) {
            list($comment, $function) = $value;
            $helper   = $this->getHelper('question');
            $question = $this->formattedQuestion("Which value do you want for your $parameter", $comment, true);
            $question->setValidator(static function ($answer) {
                if (empty($answer)) {
                    throw new \RuntimeException(
                        'Please enter a value'
                    );
                }

                return $answer;
            });
            $answers[$parameter] = $function($helper->ask($input, $output, $question));
        }

        return $answers;
    }

    private function moduleExist()
    {
        return file_exists($this->getAppDirectory().$this->generator->getNamespace().
            DIRECTORY_SEPARATOR.$this->generator->getModuleName().'/registration.php');
    }

    /**
     * @return string
     */
    private function getAppDirectory()
    {
        return getcwd() . self::MAGENTO_DEVELOPMENT_DIRECTORY;
    }

    /**
     * @return mixed
     */
    private function getCommandSkeleton()
    {
        return explode(':', $this->getName())[1];
    }
}
