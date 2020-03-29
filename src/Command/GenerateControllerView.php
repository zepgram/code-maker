<?php
/**
 * This file is part of Zepgram\CodeMaker\Command
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateView.php
 * @date       02 09 2019 14:59
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;
use Zepgram\CodeMaker\FormatString;
use Zepgram\CodeMaker\FormatClass;

class GenerateControllerView extends BaseCommand
{
    protected static $defaultName = 'generate:controller-view';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create basic view');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'router' => ['hello', 'asSnakeCase'],
            'controller' => ['Index', 'asCamelCase'],
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

        // todo: handle controller and action parameters (no separator allowed)
        $controller = $this->parameters['controller'];
        $controllerClass = new FormatClass(
            $this->maker->getModuleNamespace(),
            "Controller/$controller/".$this->parameters['action']
        );

        // controller variables
        $this->parameters['controller'] = $controllerClass->getName();
        $this->parameters['name_space_controller'] = $controllerClass->getNamespace();
        $this->parameters['router_id'] = 'standard';
        $this->parameters['route_id'] = $controllerClass->getRouterId($this->parameters['router']);
        $this->parameters['dependencies'] = [
            'Magento\Framework\App\Action\Action', 'Magento\Framework\App\Action\Context'
        ];

        // view model variables
        $this->parameters['class_view_model'] = $viewModelClass->getName();
        $this->parameters['name_space_view_model'] = $viewModelClass->getNamespace();
        $this->parameters['use_view_model'] = $viewModelClass->getUse();
        $this->parameters['template'] = FormatString::asSnakeCase($this->parameters['action']);
        $route_action = $controllerClass->getLayoutRoute($this->parameters['router']);
        $template = $this->parameters['template'];

        $filePath = [
            'routes.tpl.php' => 'etc/frontend/routes.xml',
            'controller.tpl.php' => $controllerClass->getFileName(),
            'view-model.tpl.php' => $viewModelClass->getFileName(),
            'layout.tpl.php' => "view/frontend/layout/$route_action.xml",
            'template.tpl.php' => "view/frontend/templates/$template.phtml"
        ];

        $this->maker->setTemplateParameters($this->parameters)
            ->setTemplateSkeleton(['controller','view'])
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}
