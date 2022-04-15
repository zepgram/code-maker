<?php

/*
 * This file is part of Zepgram Code Maker.
 * (c) Benjamin Calef <bcalef.pro@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
            'area' => [
                'choice_question' => self::MAGENTO_AREA
            ],
            'plugin_name' => [
                'default' => 'QueryText',
                'formatter' => 'ucwords'
            ],
            'plugin_method' => [
                'choice_question' => [
                    'before',
                    'around',
                    'after'
                ]
            ],
            'target_class' => [
                'default' => 'Magento\CatalogSearch\Block\Result',
                'formatter' => 'ucwords'
            ],
            'target_method' => [
                'formatter' => 'ucwords'
            ]
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
