<?php

declare(strict_types=1);

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\Editor\ClassMaker;

class CreateControllerView extends CreateController
{
    protected static $defaultName = 'create:controller-view';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create controller with view');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $controllerEntity = 'Controller/'. $this->parameters['controller'].'/' . $this->parameters['action'];
        $class = new ClassMaker($this->maker->getModuleNamespace(), $controllerEntity, $this->parameters);
        $area = $class->getArea();
        $route_action = $class->getLayoutRoute();
        $template = $class->getNameSnakeCase();

        $this->entities->addEntity('ViewModel/'.$this->parameters['action'], 'view_model.tpl.php');
        $this->entities->addFile('layout.tpl.php', "view/$area/layout/$route_action.xml");
        $this->entities->addFile('template.tpl.php', "view/$area/templates/$template.phtml");
        $this->entities->addFile('routes.tpl.php', "etc/$area/routes.xml");

        $this->maker->setTemplateSkeleton(['controller', 'view', 'view-model']);

        parent::execute($input, $output);
    }
}
