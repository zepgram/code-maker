<?php
/**
 * This file is part of Zepgram\CodeMaker\Command
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateBlock.php
 * @date       02 09 2019 14:59
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;
use Zepgram\CodeMaker\ClassTemplate;

class CreateBlock extends BaseCommand
{
    protected static $defaultName = 'create:block';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create block');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'block_name' => ['Data', 'ucwords']
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $classTemplate = new ClassTemplate(
            $this->parameters['block_name'],
            $this->maker->getModuleNamespace() . '\\Block'
        );

        $this->parameters['class_block'] = $classTemplate->getClassName();
        $this->parameters['name_space_block'] = $classTemplate->getClassNamespace();
        $filePath = [
            'block.tpl.php' => $classTemplate->getClassFile(),
        ];
        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}