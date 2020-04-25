<?php
/**
 * This file is part of Zepgram\CodeMaker\Command
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateServiceContract.php
 * @date       16 09 2019 10:55
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateServiceContract extends BaseCommand
{
    protected static $defaultName = 'create:service-contract';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create service contract');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'entity_name' => [
                'default' => 'Apple',
                'formatter' => 'ucwords'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getOptions()
    {
        return [
            'type' => [
                'string',
                'int',
                'float',
                'bool',
                'array'
            ]
        ];
    }

    /**
     * @todo: resolve xml merge
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->entities->addEntity('Model/'.$this->parameters['entity_name'], 'entity.tpl.php');
        $this->entities->addEntity('Model/'.$this->parameters['entity_name'].'Repository', 'entity_repository.tpl.php');
        $this->entities->addEntity('Model/'.$this->parameters['entity_name'].'Management', 'entity_management.tpl.php');
        $this->entities->addEntity('Api/Data/'.$this->parameters['entity_name'].'Interface', 'entity_interface.tpl.php');
        $this->entities->addEntity('Api/Data/'.$this->parameters['entity_name'].'SearchResultsInterface', 'search_results_interface.tpl.php');
        $this->entities->addEntity('Api/'.$this->parameters['entity_name'].'RepositoryInterface', 'entity_repository_interface.tpl.php');
        $this->entities->addEntity('Api/'.$this->parameters['entity_name'].'ManagementInterface', 'entity_management_interface.tpl.php');
        $this->entities->addFile('di.tpl.php', 'etc/di.xml');

        parent::execute($input, $output);
    }
}
