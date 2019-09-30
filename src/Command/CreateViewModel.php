<?php
/**
 * This file is part of Zepgram\CodeMaker\Command for Caudalie
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateViewModel.php
 * @date       30 09 2019 16:33
 * @author     bcalef <benjamin.calef@caudalie.com>
 * @copyright  2019 Caudalie Copyright (c) (https://caudalie.com)
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;
use Zepgram\CodeMaker\FormatClass;
use Zepgram\CodeMaker\FormatString;

class CreateViewModel extends BaseCommand
{
    protected static $defaultName = 'create:view-model';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create view model');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'action' => ['Index', 'asCamelCase']
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $viewModelClass = new FormatClass(
            $this->maker->getModuleNamespace(),
            'ViewModel/'.$this->parameters['action']
        );

        // view model variables
        $this->parameters['class_view_model'] = $viewModelClass->getName();
        $this->parameters['name_space_view_model'] = $viewModelClass->getNamespace();
        $this->parameters['use_view_model'] = $viewModelClass->getUse();
        $this->parameters['template'] = FormatString::asSnakeCase($this->parameters['action']);

        $filePath = [
            'view-model.tpl.php' => $viewModelClass->getFileName(),
        ];

        $this->maker->setTemplateParameters($this->parameters)
            ->setTemplateSkeleton(['view'])
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}