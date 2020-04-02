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
use Zepgram\CodeMaker\Constraint;
use Zepgram\CodeMaker\FormatClass;

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
            'area' => ['choice_question', ['frontend','adminhtml']],
            'router' => ['subscriber', 'asSnakeCase'],
            'controller' => ['Update', 'asCamelCaseNoSlash'],
            'action' => ['Index', 'asCamelCaseNoSlash'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $area = $this->parameters['area'];
        $controller = $this->parameters['controller'];
        $classTemplate = new FormatClass(
            $this->maker->getModuleNamespace(),
            "Controller/$controller/" . $this->parameters['action'],
            $area
        );

        $this->parameters['router_id'] = $classTemplate->isBackend() ? 'admin' : 'standard';
        $this->parameters['dependencies'] = $classTemplate->isBackend() ?
            ['Magento\Backend\App\Action', 'Magento\Backend\App\Action\Context'] :
            ['Magento\Framework\App\Action\Action', 'Magento\Framework\App\Action\Context'];
        $this->parameters['action'] = $classTemplate->getName();
        $this->parameters['name_space_controller'] = $classTemplate->getNamespace();
        $this->parameters['route_id'] = $classTemplate->getRouteId($this->parameters['router']);
        $filePath = [
            'controller.tpl.php' => $classTemplate->getFileName(),
            'routes.tpl.php'     => "etc/$area/routes.xml"
        ];

        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}
