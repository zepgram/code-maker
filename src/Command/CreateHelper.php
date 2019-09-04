<?php
/**
 * This file is part of Zepgram\CodeMaker\Command
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateHelper.php
 * @date       02 09 2019 14:59
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;
use Zepgram\CodeMaker\ClassTemplate;

class CreateHelper extends BaseCommand
{
    protected static $defaultName = 'create:helper';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create helper');
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
        $classTemplate = new ClassTemplate(
            $this->parameters['class_name'],
            $this->maker->getModuleNamespace(). '\\Helper'
        );

        $this->parameters['class_helper'] = $classTemplate->getClassName();
        $this->parameters['name_space_helper'] = $classTemplate->getClassNamespace();
        $filePath = [
            'helper.tpl.php' => $classTemplate->getClassFile(),
        ];

        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}