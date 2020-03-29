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
use Zepgram\CodeMaker\FormatClass;
use Zepgram\CodeMaker\FormatString;

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
        $classTemplate = new FormatClass(
            $this->maker->getModuleNamespace(),
            'Plugin/'.$this->parameters['plugin_name']
        );

        $targetClassName = explode('\\', $this->parameters['target_class']);
        $this->parameters['class_plugin'] = $classTemplate->getName();
        $this->parameters['name_space_plugin'] = $classTemplate->getNamespace();
        $this->parameters['use_plugin'] = $classTemplate->getUse();
        $this->parameters['snake_case_plugin'] = FormatString::asSnakeCase($this->parameters['use_plugin']);
        $this->parameters['target_class_name'] = array_pop($targetClassName);
        $eventPath = $area ? "etc/$area/di.xml" : 'etc/di.xml';
        $filePath = [
            'plugin.tpl.php' => $classTemplate->getFileName(),
            'di.tpl.php' => $eventPath
        ];
        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}
