<?php
/**
 * This file is part of Zepgram\CodeMaker\Command
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateViewModel.php
 * @date       30 09 2019 16:33
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;

class CreateViewModel extends BaseCommand
{
    protected static $defaultName = 'create:view-model';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create view model');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'action' => ['Index', 'asCamelCase']
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->entities->addEntity('ViewModel/'.$this->parameters['action'], 'view_model.tpl.php');

        parent::execute($input, $output);
    }
}
