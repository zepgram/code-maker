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

namespace Zepgram\CodeMaker\Console;

use Symfony\Component\Console\Application;
use Zepgram\CodeMaker\BaseCommand;
use Zepgram\CodeMaker\File\Management;

class Cli extends Application
{
    const COMMAND_NAME_SPACE = 'Zepgram\CodeMaker\Command';

    const CONFIG_FILE = 'app/etc/config.php';

    const MODULE_ARRAY_KEY = 'modules';

    /**
     * {@inheritdoc}
     */
    protected function getDefaultCommands()
    {
        $this->validateMagentoPath();
        return array_merge(parent::getDefaultCommands(), $this->getApplicationCommands());
    }

    /**
     * @throws \RuntimeException
     */
    private function validateMagentoPath()
    {
        if (!file_exists(self::CONFIG_FILE)) {
            throw new \RuntimeException('You must run this command in magento root directory.');
        }
        if (strpos(file_get_contents(self::CONFIG_FILE), self::MODULE_ARRAY_KEY) === false) {
            throw new \RuntimeException('You are not in magento2 application.');
        }
    }

    /**
     * @return array
     */
    private function getApplicationCommands()
    {
        $instanceCommand = [];
        $commandDirectory = dirname(__DIR__) . '/' . explode('\\', self::COMMAND_NAME_SPACE)[2];
        $scanDir = Management::scanDir($commandDirectory);

        foreach ($scanDir as $commandFile) {
            $command = self::COMMAND_NAME_SPACE . '\\' . str_replace('.php', '', $commandFile);
            if (class_exists($command)) {
                $command = new $command;
                if (is_subclass_of($command, BaseCommand::class)) {
                    $instanceCommand[] = $command;
                }
            }
        }

        return $instanceCommand;
    }
}