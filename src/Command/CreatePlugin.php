<?php
/**
 * This file is part of Zepgram\CodeMaker\Command
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateCron.php
 * @date       03 09 2019 14:01
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;

class CreatePlugin extends BaseCommand
{
    protected static $defaultName = 'create:plugin';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create plugin');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'area' => ['choice_question', self::MAGENTO_AREA],
            'plugin_name' => ['QueryText', 'ucwords'],
            'target_class' => ['Magento\CatalogSearch\Block\Result', 'ucwords']
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $area = $this->parameters['area'] === 'base' ? '' : $this->parameters['area'];
        $eventPath = $area ? "etc/$area/di.xml" : 'etc/di.xml';
        $targetClassName = explode('\\', $this->parameters['target_class']);

        $this->parameters['target_class_name'] = array_pop($targetClassName);
        $this->entities->addEntity('Plugin/'.$this->parameters['plugin_name'], 'plugin.tpl.php');
        $this->entities->addFile('di.tpl.php', $eventPath);

        parent::execute($input, $output);
    }
}
