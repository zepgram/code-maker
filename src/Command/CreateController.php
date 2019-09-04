<?php
/**
 * This file is part of Zepgram\CodeMaker\Command
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateController.php
 * @date       02 09 2019 14:59
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;
use Zepgram\CodeMaker\ClassTemplate;

class CreateController extends BaseCommand
{
    protected static $defaultName = 'create:controller';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create controller');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'scope' => ['choice_question', ['frontend','adminhtml']],
            'router' => ['subscriber', 'asSnakeCase'],
            'controller' => ['Update', 'asCamelCase'],
            'action' => ['Index', 'asCamelCase'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $scope = $this->parameters['scope'];
        $controller = $this->parameters['controller'];
        $isBackend = $scope === 'adminhtml';
        $classScope = $isBackend ? '\\Controller\\Adminhtml' : '\\Controller';
        $classTemplate = new ClassTemplate(
            $this->parameters['action'],
            $this->maker->getModuleNamespace() . $classScope . "\\$controller"
        );

        $this->parameters['router_id'] = $isBackend ? 'admin' : 'standard';
        $this->parameters['dependencies'] = $isBackend ?
            ['Magento\Backend\App\Action', 'Magento\Backend\App\Action\Context'] :
            ['Magento\Framework\App\Action\Action', 'Magento\Framework\App\Action\Context'];
        $this->parameters['action'] = $classTemplate->getClassName();
        $this->parameters['name_space_controller'] = $classTemplate->getClassNamespace();
        $filePath = [
            'controller.tpl.php' => $classTemplate->getClassFile(),
            'routes.tpl.php'     => "etc/$scope/routes.xml"
        ];

        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}