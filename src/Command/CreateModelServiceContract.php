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

class CreateModelServiceContract extends CreateModel
{
    protected static $defaultName = 'create:model:service-contract';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create model with service contract');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->isServiceContract = true;
        $this->parameters['entity_name'] = $this->parameters['model_name'];
        $this->entities->addEntity('Model/'.$this->parameters['model_name'], 'entity.tpl.php');
        $this->entities->addEntity('Model/'.$this->parameters['model_name'].'Repository', 'entity_repository.tpl.php');
        $this->entities->addEntity('Model/'.$this->parameters['model_name'].'Management', 'entity_management.tpl.php');
        $this->entities->addEntity('Api/Data/'.$this->parameters['model_name'].'Interface', 'entity_interface.tpl.php');
        $this->entities->addEntity('Api/Data/'.$this->parameters['model_name'].'SearchResultsInterface', 'search_results_interface.tpl.php');
        $this->entities->addEntity('Api/'.$this->parameters['model_name'].'RepositoryInterface', 'entity_repository_interface.tpl.php');
        $this->entities->addEntity('Api/'.$this->parameters['model_name'].'ManagementInterface', 'entity_management_interface.tpl.php');
        $this->entities->addFile('di.tpl.php', 'etc/di.xml');

        return parent::execute($input, $output);
    }
}
