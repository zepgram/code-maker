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

class CreateController extends BaseCommand
{
    protected static $defaultName = 'create:controller';

    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Creates controller');
    }

    protected function getParameters()
    {
        return [
            'scope' => ['choice_question', ['frontend','adminhtml']],
            'router' => ['subscribe', 'strtolower'],
            'action' => ['Index', 'ucfirst'],
            'class_name' => ['Subscribe', 'ucfirst'],
        ];
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $scope = $this->parameters['scope'];
        $action = $this->parameters['action'];
        $isBackend = $scope === 'adminhtml';

        $classScope = $isBackend ? '\\Controller\\Adminhtml' : '\\Controller';
        $classGenerator = new ClassGenerator(
            $this->parameters['class_name'],
            $this->maker->getModuleFullNamespace() . $classScope . "\\$action"
        );

        $this->parameters['before_backend'] = $isBackend ? ' before="Magento_Backend"' : '';
        $this->parameters['router_id'] = $isBackend ? 'admin' : 'standard';
        $this->parameters['dependencies'] = $isBackend ?
            ['Magento\Backend\App\Action', 'Magento\Backend\App\Action\Context'] :
            ['Magento\Framework\App\Action\Action', 'Magento\Framework\App\Action\Context'];
        $this->parameters['class_name'] = $classGenerator->getClassName();
        $this->parameters['name_space'] = $classGenerator->getClassNamespace();
        $filePath = [
            'controller.tpl.php' => $classGenerator->getClassFile(),
            'routes.tpl.php'     => "etc/$scope/routes.xml"
        ];

        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}