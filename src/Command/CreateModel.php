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
use Zepgram\CodeMaker\Editor\ClassMaker;
use Zepgram\CodeMaker\Entity\Controller;
use Zepgram\CodeMaker\Str;

class CreateModel extends BaseCommand
{
    protected static $defaultName = 'create:model';

    protected $isServiceContract = false;

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
            'model_name' => [
                'default' => 'Fruit',
                'formatter' => 'ucwords'
            ],
            'primary_key' => [
                'default' => 'entity_id',
                'formatter' => 'asSnakeCase'
            ],
            'generate_grid' => [
                'yes_no_question'
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

        if ($this->isServiceContract) {
            $template[] = 'service-contract';
        }

        $template[] = 'model';
        $this->entities->addEntity('Model/'.$this->parameters['model_name'], 'model.tpl.php');
        $this->entities->addEntity('Model/ResourceModel/'.$this->parameters['model_name'], 'resource.tpl.php');
        $this->entities->addEntity('Model/ResourceModel/'.$this->parameters['model_name'].'/Collection', 'collection.tpl.php');
        $this->entities->addFile('db_schema.tpl.php', 'etc/db_schema.xml');

        if ($this->isServiceContract || $this->parameters['generate_grid']) {
            $this->entities->addFile('di.tpl.php', 'etc/di.xml');
        }

        if ($this->parameters['generate_grid']) {
            $template[] = 'controller';
            $template[] = 'grid';
            $this->parameters['area'] = 'adminhtml';
            $this->parameters['action'] = 'Index';
            $this->parameters['dependencies'] = ['Magento\Backend\App\Action', 'Magento\Backend\App\Action\Context'];
            $this->parameters['router'] = Str::asSnakeCase($this->maker->getModuleName());
            $this->parameters['controller'] = Str::asCamelCaseNoSlash($this->parameters['model_name']);
            $controller = new Controller();
            $this->entities = $controller->create($this->parameters, $this->entities);

            $gridName = $this->parameters['table_name'].'_'.Str::asSnakeCase($this->parameters['controller']);
            $this->parameters['grid_name'] = $gridName;
            $controllerEntity = 'Controller/'. $this->parameters['controller'].'/' . $this->parameters['action'];
            $class = new ClassMaker($this->maker->getModuleNamespace(), $controllerEntity, $this->parameters);
            $route_action = $class->getLayoutRoute();
            $this->entities->addFile('acl.tpl.php', 'etc/acl.xml');
            $this->entities->addFile('layout.tpl.php', "view/adminhtml/layout/$route_action.xml");
            $this->entities->addFile('component_list.tpl.php', "view/adminhtml/ui_component/".$gridName."_list.xml");
            $this->entities->addFile('menu.tpl.php', "etc/adminhtml/menu.xml");
        }

        $this->maker->setTemplateSkeleton($template);

        return parent::execute($input, $output);
    }
}
