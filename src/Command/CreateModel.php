<?php
/**
 * This file is part of Zepgram\CodeMaker\Command
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateModel.php
 * @date       16 09 2019 17:59
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

declare(strict_types=1);

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateModel extends BaseCommand
{
    protected static $defaultName = 'create:model';

    protected $dbSchemaMapping = [
        'varchar' => 'string',
        'int' => 'int',
        'boolean' => 'bool',
        'decimal' => 'float',
        'timestamp' => 'string',
        'text' => 'string',
    ];

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create model');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'table_name' => [
                'default' => 'zepgram_fruit',
                'formatter' => 'asSnakeCase'
            ],
            'entity_name' => [
                'default' => 'Apple',
                'formatter' => 'ucwords'
            ],
            'primary_key' => [
                'default' => 'entity_id',
                'formatter' => 'asSnakeCase'
            ],
            'is_service_contract' => [
                'yes_no_question'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getOptions()
    {
        return [
            'db_type' => [
                'varchar',
                'int',
                'boolean',
                'decimal',
                'timestamp',
                'text'
            ]
        ];
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->parameters['option_fields'] as $parameter => $type) {
            $this->parameters['options_fields_db'][$this->dbSchemaMapping[$parameter]] = $type;
        }
        $this->entities->addEntity('Model/'.$this->parameters['entity_name'], 'model.tpl.php');
        $this->entities->addEntity('Model/ResourceModel/'.$this->parameters['entity_name'], 'resource.tpl.php');
        $this->entities->addEntity('Model/ResourceModel/'.$this->parameters['entity_name'].'/Collection', 'collection.tpl.php');
        $this->entities->addFile('db_schema.tpl.php', 'etc/db_schema.xml');

        if ($this->parameters['is_service_contract'] === true) {
            $this->entities->addEntity('Model/'.$this->parameters['entity_name'].'Repository', 'entity_repository.tpl.php');
            $this->entities->addEntity('Model/'.$this->parameters['entity_name'].'Management', 'entity_management.tpl.php');
            $this->entities->addEntity('Api/Data/'.$this->parameters['entity_name'].'Interface', 'entity_interface.tpl.php');
            $this->entities->addEntity('Api/Data/'.$this->parameters['entity_name'].'SearchResultsInterface', 'search_results_interface.tpl.php');
            $this->entities->addEntity('Api/'.$this->parameters['entity_name'].'RepositoryInterface', 'entity_repository_interface.tpl.php');
            $this->entities->addEntity('Api/'.$this->parameters['entity_name'].'ManagementInterface', 'entity_management_interface.tpl.php');
            $this->entities->addFile('di.tpl.php', 'etc/di.xml');
        }

        return parent::execute($input, $output);
    }
}
