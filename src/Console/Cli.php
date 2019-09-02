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
use Zepgram\CodeMaker\FileManager;

class Cli extends Application
{
    const COMMAND_NAME_SPACE = 'Zepgram\CodeMaker\Command';

    const COMPOSER_FILE = 'composer.json';

    const MAGENTO_REPOSITORY = 'https://repo.magento.com';

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
        if (!file_exists(self::COMPOSER_FILE)) {
            throw new \RuntimeException('You must be in magento2 root directory.');
        }
        if (strpos(file_get_contents(self::COMPOSER_FILE), self::MAGENTO_REPOSITORY) === false) {
            throw new \RuntimeException('You are not in a magento2 application.');
        }
    }

    /**
     * @return array
     */
    private function getApplicationCommands()
    {
        $instanceCommand = [];
        $commandDirectory = dirname(__DIR__) . '/' . explode('\\', self::COMMAND_NAME_SPACE)[2];
        $scanDir = FileManager::scanDir($commandDirectory);

        foreach ($scanDir as $commandFile) {
            $command = self::COMMAND_NAME_SPACE . '\\' . str_replace('.php', '', $commandFile);
            if (class_exists($command)) {
                $instanceCommand[] = new $command;
            }
        }

        return $instanceCommand;
    }
}