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

class CreateWebApi extends BaseCommand
{
    protected static $defaultName = 'create:webapi';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create webapi REST or SOAP');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'url' => [
                'default' => '/V1/customerGroups/:id',
            ],
            'http_method' => [
                'choice_question' => [
                    'GET',
                    'POST',
                    'PUT',
                    'DELETE',
                ]
            ],
            'service_class' => [
                'default' => 'Magento\Customer\Api\GroupRepositoryInterface'
            ],
            'service_method' => [
                'default' => 'getById',
                'formatter' => 'camelCase'
            ],
            'resource' => [
                'default' => 'Magento_Customer::group',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->entities->addFile('webapi.tpl.php', 'etc/webapi.xml');

        parent::execute($input, $output);
    }
}
