<?php
/**
 * This file is part of Zepgram\CodeMaker\Console
 *
 * @package    Zepgram\CodeMaker\Console
 * @file       CreateModule.php
 * @date       30 08 2019 17:55
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;

class CreateModule extends BaseCommand
{
    protected static $defaultName = 'create:module';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create new module');
    }

    /**
     * {@inheritdoc}
     */
    protected function isModuleInitialized()
    {
        return false;
    }
}
