<?php
/**
 * This file is part of Zepgram\CodeMaker\Command
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateHelper.php
 * @date       02 09 2019 14:59
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateHelper extends BaseCommand
{
    protected static $defaultName = 'create:helper';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create helper');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'class_name' => [
                'default' => 'Data',
                'formatter' => 'ucwords'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->entities->addEntity('Helper/'.$this->parameters['class_name'], 'helper.tpl.php');

        parent::execute($input, $output);
    }
}
