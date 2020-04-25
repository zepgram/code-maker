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
            'area' => [
                'choice_question' => [
                    'frontend', 'adminhtml'
                ]
            ],
            'router' => [
                'default' => 'subscriber',
                'formatter' => 'asSnakeCase'
            ],
            'controller' => [
                'default' => 'Update',
                'formatter' => 'asCamelCaseNoSlash'
            ],
            'action' => [
                'default' => 'Index',
                'formatter' => 'asCamelCaseNoSlash'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $area = $this->parameters['area'];
        $controller = $this->parameters['controller'];
        $this->parameters['dependencies'] = $this->parameters['area'] === 'adminhtml' ?
            ['Magento\Backend\App\Action', 'Magento\Backend\App\Action\Context'] :
            ['Magento\Framework\App\Action\Action', 'Magento\Framework\App\Action\Context'];

        $this->entities->addEntity("Controller/$controller/" . $this->parameters['action'], 'controller.tpl.php');
        $this->entities->addFile('routes.tpl.php', "etc/$area/routes.xml");

        parent::execute($input, $output);
    }
}
