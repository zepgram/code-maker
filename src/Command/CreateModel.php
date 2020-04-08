<?php

declare(strict_types=1);

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;

class CreateModel extends BaseCommand
{
    protected static $defaultName = 'create:model';

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
            'table_name' => ['zepgram_fruit', 'asSnakeCase'],
            'entity_name' => ['Apple', 'ucwords'],
            'primary_key' => ['entity_id', 'asSnakeCase']
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getOptions()
    {
        return [
            'type' => [
                'varchar',
                'int',
                'smallint',
                'decimal',
                'timestamp',
                'text',
                'boolean'
            ],
            'is_nullable' => [
                'true',
                'false'
            ]
        ];
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->entities->addEntity('Model/'.$this->parameters['entity_name'], 'model.tpl.php');
        $this->entities->addEntity('Model/ResourceModel/'.$this->parameters['entity_name'], 'resource.tpl.php');
        $this->entities->addEntity('Model/ResourceModel/'.$this->parameters['entity_name'].'/Collection', 'collection.tpl.php');
        $this->entities->addFile('db_schema.tpl.php', 'etc/db_schema.xml');

        return parent::execute($input, $output);
    }
}
