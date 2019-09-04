<?php
/**
 * This file is part of Zepgram\CodeMaker\Command for Caudalie
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateCron.php
 * @date       03 09 2019 14:01
 * @author     bcalef <benjamin.calef@caudalie.com>
 * @copyright  2019 Caudalie Copyright (c) (https://caudalie.com)
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;
use Zepgram\CodeMaker\ClassTemplate;
use Zepgram\CodeMaker\Format;

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
            'scope' => ['choice_question', ['global','frontend','adminhtml']],
            'observer_name' => ['CustomerRegister', 'ucwords'],
            'event' => ['customer_register_success', null]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $scope = $this->parameters['scope'] === 'global' ? '' : $this->parameters['scope'];
        $classScope = $scope ? "\\Observer\\$scope" : '\\Observer';
        $classTemplate = new ClassTemplate(
            $this->parameters['observer_name'],
            $this->maker->getModuleNamespace() . $classScope
        );

        $this->parameters['class_observer'] = $classTemplate->getClassName();
        $this->parameters['name_space_observer'] = $classTemplate->getClassNamespace();
        $this->parameters['use_observer'] = $classTemplate->getClassNamespace().'\\'.$classTemplate->getClassName();
        $this->parameters['snake_case_observer'] = Format::asSnakeCase($this->parameters['use_observer']);
        $eventPath = $scope ? "etc/$scope/events.xml" : 'etc/events.xml';
        $filePath = [
            'observer.tpl.php' => $classTemplate->getClassFile(),
            'events.tpl.php' => $eventPath
        ];
        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}