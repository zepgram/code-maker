<?php
/**
 * This file is part of Zepgram\CodeMaker\Command for Caudalie
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateView.php
 * @date       02 09 2019 14:14
 * @author     bcalef <benjamin.calef@caudalie.com>
 * @copyright  2019 Caudalie Copyright (c) (https://caudalie.com)
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;
use Zepgram\CodeMaker\Format;
use Zepgram\CodeMaker\Generator\ClassGenerator;

class CreateView extends BaseCommand
{
    protected static $defaultName = 'create:view';

    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Creates full view');
    }

    protected function getParameters()
    {
        return [
            'router' => ['hello', 'strtolower'],
            'action' => ['Index', 'ucfirst'],
            'view' => ['Index', 'ucfirst'],
            'template' => ['index', 'strtolower']
        ];
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $viewModelClass = new ClassGenerator(
            $this->parameters['view'],
            $this->maker->getModuleFullNamespace() . '\\ViewModel'
        );

        $action = $this->parameters['action'];
        $controllerClass = new ClassGenerator(
            $this->parameters['view'],
            $this->maker->getModuleFullNamespace() . '\\Controller' . "\\$action"
        );

        $this->parameters['view_model'] = $viewModelClass->getClassName();
        $this->parameters['name_space_view_model'] = $viewModelClass->getClassNamespace();
        $this->parameters['view_model_class'] = $viewModelClass->getClassNamespace().'\\'.$viewModelClass->getClassName();

        $this->parameters['controller'] = $controllerClass->getClassName();
        $this->parameters['name_space_controller'] = $controllerClass->getClassNamespace();
        $this->parameters['route_id'] = $controllerClass->getControllerRouteId($this->parameters['router']);
        $route_action = $controllerClass->getControllerRoute($this->parameters['router']);
        $template = $this->parameters['template'];

        $filePath = [
            'routes.tpl.php' => 'etc/frontend/routes.xml',
            'controller.tpl.php' => $controllerClass->getClassFile(),
            'view-model.tpl.php' => $viewModelClass->getClassFile(),
            'layout.tpl.php' => "view/frontend/layout/$route_action.xml",
            'template.tpl.php' => "view/frontend/templates/$template.phtml"
        ];

        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}