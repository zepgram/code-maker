<?php
/**
 * This file is part of Zepgram\CodeMaker\Command for Caudalie
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateController.php
 * @date       01 09 2019 00:02
 * @author     bcalef <benjamin.calef@caudalie.com>
 * @copyright  2019 Caudalie Copyright (c) (https://caudalie.com)
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Zepgram\CodeMaker\BaseCommand;

class CreateClass extends BaseCommand
{
    protected static $defaultName = 'create:class';

    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Creates helper, block, view-model');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $parameters = [
            'class_name' => ['Data', 'ucfirst']
        ];
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Please select your class',
            ['Helper', 'Block', 'ViewModel'],
            'Helper'
        );
        $scope = $helper->ask($input, $output, $question);
        $output->writeln("<info>You have selected</info>: $scope");
        $templatesParameters = $this->askParameters($parameters, $input, $output);

        $templatesParameters['scope'] = $scope;
        $scopePath = strtolower($scope);
        $className = $templatesParameters['class_name'];
        $className = explode('/', $className);
        $namespaces = [];
        foreach ($className as $namespace) {
            $namespaces[] = ucwords($namespace);
        }
        $className = implode('/', $namespaces);

        $filePath =[
            "$scopePath.tpl.php" => $scope . "/$className.php",
        ];

        $this->maker->setTemplateSkeleton([$scopePath])
            ->setTemplateParameters($templatesParameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}