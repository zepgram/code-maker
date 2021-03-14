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
use Zepgram\CodeMaker\Entity\Controller;

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
                'formatter' => 'asKebabCase'
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
        $controller = new Controller();
        $this->entities = $controller->create($this->parameters, $this->entities);
        $this->parameters['dependencies'] = $this->parameters['area'] === 'adminhtml' ?
            ['Magento\Backend\App\Action', 'Magento\Backend\App\Action\Context'] :
            ['Magento\Framework\App\Action\Action', 'Magento\Framework\App\Action\Context'];

        parent::execute($input, $output);
    }
}
