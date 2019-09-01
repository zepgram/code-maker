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
use Zepgram\CodeMaker\BaseCommand;

class CreateHelper extends BaseCommand
{
    protected static $defaultName = 'create:helper';

    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Creates helper');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $parameters = [
            'class_name' => ['Data', 'ucfirst']
        ];
        $templatesParameters = $this->askParameters($parameters, $input, $output);
        $className = $templatesParameters['class_name'];
        $filePath =[
            'helper.tpl.php' => "Helper/$className.php",
        ];

        $this->generator
            ->setTemplateParameters($templatesParameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}