<?php
/**
 * This file is part of Zepgram\CodeMaker\Console
 *
 * @package    Zepgram\CodeMaker\Console
 * @file       Cli.php
 * @date       30 08 2019 17:55
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;

use Zepgram\CodeMaker\BaseCommand;

class CreateModule extends BaseCommand
{
    protected static $defaultName = 'create:module';

    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Creates new module');
    }
}
