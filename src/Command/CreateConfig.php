<?php

declare(strict_types=1);

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;
use Zepgram\CodeMaker\FormatClass;
use Zepgram\CodeMaker\FormatString;

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
            'is_new_tab' => ['choice_question', ['yes','no']],
            'config_path' => ['sales/general', '']
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
     * @todo: resolve xml merge
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $configPath = $this->parameters['config_path'];
        if (!preg_match('/^([A-z0-9-_+]+\/)+([A-z0-9]+)$/i', $configPath) || substr_count($configPath, '/') !== 1) {
            throw new InvalidArgumentException('Config path should be a valid path.');
        }

        $sectionGroup = explode('/', $configPath);
        $configEntity = new FormatClass(
            $this->maker->getModuleNamespace(),
            'Model/Config'
        );
        $configFields = $this->sequencedQuestion($input, $output);

        $this->parameters['is_new_tab'] = $this->parameters['is_new_tab'] === 'yes' ? true : false;
        $this->parameters['class_entity'] = $configEntity->getName();
        $this->parameters['name_space_entity'] = $configEntity->getNamespace();
        $this->parameters['config_fields'] = $configFields;
        $this->parameters['section'] = $sectionGroup[0];
        $this->parameters['group'] = $sectionGroup[1];
        $this->parameters['resource_id'] = $this->maker->getModuleName() . '::config_' . $sectionGroup[0];
        foreach ($this->parameters['config_fields'] as $config => $configOptions) {
            $xmlPath = $configPath . '/' . $config;
            $constPath = FormatString::uppercase(str_replace('/', '_', $xmlPath));
            $this->parameters['config_fields'][$config]['const'] = $constPath;
            $this->parameters['config_fields'][$config]['xml'] = $xmlPath;
        }

        $filePath = [
            'config.tpl.php' => $configEntity->getFileName(),
            'system.tpl.php' => 'etc/adminhtml/system.xml',
            'config_xml.tpl.php' => 'etc/config.xml',
            'acl.tpl.php' => 'etc/acl.xml',
        ];
        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}
