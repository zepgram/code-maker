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
        'mediumtext' => 'string',
        'text' => 'string',
        'date' => 'string',
        'timestamp' => 'string',
        'timestamp_on_update' => 'string',
        'int' => 'int',
        'smallint' => 'int',
        'boolean' => 'bool',
        'decimal' => 'float',
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
                'mediumtext',
                'text',
                'int',
                'smallint',
                'boolean',
                'decimal',
                'date',
                'timestamp',
                'timestamp_on_update'
            ],
            'is_nullable' => [
                'true',
                'false'
            ],
        ];
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        foreach ($this->parameters['option_fields'] as $parameter => $type) {
            $this->parameters['option_fields'][$parameter]['type'] = $this->dbSchemaMapping[$type['db_type']];
        }

        $this->entities->addEntity('Model/'.$this->parameters['entity_name'], 'entity.tpl.php');
        $this->entities->addEntity('Model/ResourceModel/'.$this->parameters['entity_name'], 'resource.tpl.php');
        $this->entities->addEntity('Model/ResourceModel/'.$this->parameters['entity_name'].'/Collection', 'collection.tpl.php');
        $this->entities->addFile('db_schema.tpl.php', 'etc/db_schema.xml');

        return parent::execute($input, $output);
    }
}
