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
use Zepgram\CodeMaker\Format;
use Zepgram\CodeMaker\ClassTemplate;

class CreateView extends BaseCommand
{
    protected static $defaultName = 'create:view';

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
        $viewModelClass = new ClassTemplate(
            $this->parameters['action'],
            $this->maker->getModuleFullNamespace() . '\\ViewModel'
        );

        $controller = $this->parameters['controller'];
        $controllerClass = new ClassTemplate(
            $this->parameters['action'],
            $this->maker->getModuleFullNamespace() . '\\Controller' . "\\$controller"
        );

        // controller variables
        $this->parameters['controller'] = $controllerClass->getClassName();
        $this->parameters['name_space_controller'] = $controllerClass->getClassNamespace();
        $this->parameters['router_id'] = 'standard';
        $this->parameters['dependencies'] = [
            'Magento\Framework\App\Action\Action', 'Magento\Framework\App\Action\Context'
        ];

        // view model variables
        $this->parameters['class_view_model'] = $viewModelClass->getClassName();
        $this->parameters['name_space_view_model'] = $viewModelClass->getClassNamespace();
        $this->parameters['use_view_model'] = $viewModelClass->getClassNamespace().'\\'.$viewModelClass->getClassName();
        $this->parameters['template'] = Format::asSnakeCase($this->parameters['action']);
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
            ->setTemplateSkeleton(['controller','view'])
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}