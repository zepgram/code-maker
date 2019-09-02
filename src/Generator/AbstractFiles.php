<?php
/**
 * This file is part of Zepgram\CodeMaker\Generator
 *
 * @package    Zepgram\CodeMaker\Generator
 * @file       Files.php
 * @date       31 08 2019 18:09
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Generator;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Zepgram\CodeMaker\FileManager;
use Zepgram\CodeMaker\Maker;

abstract class AbstractFiles
{
    /** @var Maker */
    protected $maker;

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @param Command         $console
     *
     * @return array
     */
    public function writeTemplates(InputInterface $input, OutputInterface $output, Command $console)
    {
        $createdFiles = [];
        $appDirectory = $this->maker->getAppDirectory();
        $namespaceDirectory = $appDirectory.$this->maker->getModuleNamespace().DIRECTORY_SEPARATOR;
        $moduleDirectory = $namespaceDirectory.$this->maker->getModuleName().DIRECTORY_SEPARATOR;

        FileManager::mkdir($appDirectory);
        FileManager::mkdir($namespaceDirectory);
        FileManager::mkdir($moduleDirectory);

        foreach ($this->getTemplates() as $path => $content) {
            $filePath = $moduleDirectory . $path;
            if (FileManager::fileExist($filePath)) {
                $output->write("\n");
                $output->writeln("<info>File</info> $path <info>already exist</info>");
                $question = new ConfirmationQuestion('<info>Do you want to override existing files ?</info>');
                if (!$console->getHelper('question')->ask($input, $output, $question)) {
                    continue;
                }
            }
            FileManager::writeFiles($moduleDirectory . $path, $content);
            $createdFiles[] = $path;
        }

        return $createdFiles;
    }

    abstract protected function getTemplates();
}