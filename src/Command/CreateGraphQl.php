<?php
/**
 * This file is part of Zepgram\CodeMaker\Command
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateGraphQl.php
 * @date       18 11 2019 14:21
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateGraphQl extends BaseCommand
{
    protected static $defaultName = 'create:graph-ql';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create resolver graphQL');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'resolver_name' => [
                'default' => 'AddItem',
                'formatter' => 'ucwords'
            ],
            'type' => [
                'choice_question' => [
                    'query', 'mutation'
                ]
            ],
            'description' => [
                'default' => 'Add item', 'getPhrase'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->entities->addEntity('Model/Resolver/'.$this->parameters['resolver_name'], 'resolver.tpl.php');
        $this->entities->addFile('schema.tpl.php', 'etc/schema.graphqls');

        parent::execute($input, $output);
    }
}
