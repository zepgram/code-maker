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
use Zepgram\CodeMaker\Generator\ClassGenerator;

class CreateHelper extends BaseCommand
{
    protected static $defaultName = 'create:helper';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Creates helper');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'class_name' => ['Data', 'ucwords']
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $classGenerator = new ClassGenerator(
            $this->parameters['class_name'],
            $this->maker->getModuleFullNamespace(). '\\Helper'
        );

        $this->parameters['class_name'] = $classGenerator->getClassName();
        $this->parameters['name_space'] = $classGenerator->getClassNamespace();
        $filePath = [
            'helper.tpl.php' => $classGenerator->getClassFile(),
        ];

        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}