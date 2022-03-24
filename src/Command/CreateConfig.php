<?php

declare(strict_types=1);

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\Str;

class CreateConfig extends BaseCommand
{
    protected static $defaultName = 'create:config';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create system config');
    }

    protected function getParameters()
    {
        return [
            'is_new_section' => [
                'yes_no_question'
            ],
            'config_path' => [
                'default' => 'sales/general'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getOptions()
    {
        return [
            'type' => [
                'button',
                'checkbox',
                'checkboxes',
                'column',
                'date',
                'editablemultiselect',
                'editor',
                'fieldset',
                'file',
                'gallery',
                'hidden',
                'image',
                'imagefile',
                'label',
                'link',
                'multiline',
                'multiselect',
                'note',
                'obscure',
                'password',
                'radio',
                'radios',
                'reset',
                'select',
                'submit',
                'text',
                'textarea',
                'time',
            ],
            'default_value',
            'comment'
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configPath = $this->parameters['config_path'];
        if (!preg_match('/^([A-z0-9-_+]+\/)+([A-z0-9]+)$/i', $configPath) || substr_count($configPath, '/') !== 1) {
            throw new InvalidArgumentException('Config path should be a valid path.');
        }

        $sectionGroup = explode('/', $configPath);
        $this->parameters['section'] = $sectionGroup[0];
        $this->parameters['group'] = $sectionGroup[1];
        $this->parameters['resource_id'] = $this->maker->getModuleName() . '::config_' . $sectionGroup[0];

        foreach ($this->parameters['option_fields'] as $config => $configOptions) {
            $xmlPath = $configPath . '/' . $config;
            $constPath = Str::uppercase(str_replace('/', '_', $xmlPath));
            $this->parameters['option_fields'][$config]['const'] = $constPath;
            $this->parameters['option_fields'][$config]['xml'] = $xmlPath;
        }

        $this->entities->addEntity('Model/Config', 'config.tpl.php');
        $this->entities->addFile('system.tpl.php', 'etc/adminhtml/system.xml');
        $this->entities->addFile('config_xml.tpl.php', 'etc/config.xml');
        if ($this->parameters['is_new_section']) {
            $this->entities->addFile('acl.tpl.php', 'etc/acl.xml');
        }

        parent::execute($input, $output);
    }
}
