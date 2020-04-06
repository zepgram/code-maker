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
use Zepgram\CodeMaker\BaseCommand;
use Zepgram\CodeMaker\FormatClass;
use Zepgram\CodeMaker\FormatString;

class GenerateServiceContract extends BaseCommand
{
    protected static $defaultName = 'generate:service-contract';

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
            'class_name' => ['Apple', 'ucwords']
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
        $modelEntity = new FormatClass(
            $this->maker->getModuleNamespace(),
            'Model/'.$this->parameters['class_name']
        );
        $interfaceEntity = new FormatClass(
            $this->maker->getModuleNamespace(),
            'Api/Data/'.$this->parameters['class_name'].'Interface'
        );

        $this->parameters['entity_fields'] = $this->sequencedQuestion($input, $output);

        $this->parameters['class_entity'] = $modelEntity->getName();
        $this->parameters['class_entity_param'] = FormatString::asCamelCase($modelEntity->getName());
        $this->parameters['name_space_entity'] = $modelEntity->getNamespace();
        $this->parameters['use_class_entity'] = $modelEntity->getUse();

        $this->parameters['class_entity_interface'] = $interfaceEntity->getName();
        $this->parameters['name_space_api'] = str_replace('\Data', '', $interfaceEntity->getNamespace());
        $this->parameters['name_space_api_data'] = $interfaceEntity->getNamespace();
        $this->parameters['use_class_entity_interface'] = $interfaceEntity->getUse();


        $filePath = [
            'entity.tpl.php' => $modelEntity->getFileName(),
            'entity-interface.tpl.php' => $interfaceEntity->getFileName(),
            'entity-repository.tpl.php' => 'Model/'.$modelEntity->getName().'Repository.php',
            'entity-repository-interface.tpl.php' => 'Api/'.$modelEntity->getName().'RepositoryInterface.php',
            'entity-management-interface.tpl.php' => 'Api/'.$modelEntity->getName().'ManagementInterface.php',
            'entity-management.tpl.php' => 'Model/'.$modelEntity->getName().'Management.php',
            'search-results-interface.tpl.php' => 'Api/Data/'.$modelEntity->getName().'SearchResultsInterface.php',
            'di.tpl.php' => 'etc/di.xml'
        ];
        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}
