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

class CreateObserver extends BaseCommand
{
    protected static $defaultName = 'create:observer';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create observer');
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
            'observer_name' => [
                'default' => 'CustomerRegister',
                'formatter' => 'ucwords'
            ],
            'event' => [
                'default' => 'customer_register_success'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $area = $this->parameters['area'] === 'base' ? false : $this->parameters['area'];
        $eventPath = $area ? "etc/$area/events.xml" : 'etc/events.xml';
        $this->entities->addEntity('Observer/'.$this->parameters['observer_name'], 'observer.tpl.php');
        $this->entities->addFile('events.tpl.php', $eventPath);

        parent::execute($input, $output);
    }
}
