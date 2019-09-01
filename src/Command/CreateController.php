<?php
/**
 * This file is part of Zepgram\CodeMaker\Command for Caudalie
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateController.php
 * @date       01 09 2019 00:02
 * @author     bcalef <benjamin.calef@caudalie.com>
 * @copyright  2019 Caudalie Copyright (c) (https://caudalie.com)
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;
use Symfony\Component\Console\Question\ChoiceQuestion;

class CreateController extends BaseCommand
{
    protected static $defaultName = 'create:controller';

    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Creates controller');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Please select your controller scope',
            ['frontend', 'adminhtml'],
            'frontend'
        );
        $scope = $helper->ask($input, $output, $question);
        $output->writeln("<info>You have selected</info>: $scope");
        $isBackend = $scope === 'adminhtml';

        $parameters = [
            'controller' => ['Subscriber', 'ucfirst'],
            'action' => ['Index', 'ucfirst'],
            'router' => ['subscribe', 'strtolower']
        ];
        $templatesParameters = $this->askParameters($parameters, $input, $output);

        $templatesParameters['base_name_space'] = $this->maker->getModuleFullNamespace();
        $templatesParameters['before_backend'] = $isBackend ? ' before="Magento_Backend"' : '';
        $templatesParameters['router_id'] = $isBackend ? 'admin' : 'standard';
        $templatesParameters['dependencies'] = [
            'Magento\Framework\App\Action\Action',
            'Magento\Framework\App\Action\Context'
        ];
        $templatesParameters['admin_html_namespace'] = '';
        if ($isBackend) {
            $templatesParameters['dependencies'] = [
                'Magento\Backend\App\Action',
                'Magento\Backend\App\Action\Context'
            ];
            $templatesParameters['admin_html_namespace'] = 'Adminhtml\\';
        }
        $controllerPath = $templatesParameters['controller'] . DIRECTORY_SEPARATOR . $templatesParameters['action'];
        $controllerPath = $isBackend ? 'Adminhtml/' . $controllerPath : $controllerPath;
        $filePath = [
            'controller.tpl.php' => "Controller/$controllerPath.php",
            'routes.tpl.php'     => "etc/$scope/routes.xml"
        ];

        $this->maker->setTemplateParameters($templatesParameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}