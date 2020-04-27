<?php

declare(strict_types=1);

namespace Zepgram\CodeMaker\Entity;

use Zepgram\CodeMaker\Editor\Entities;

class Controller
{
    public function create(array $parameters, Entities $entities)
    {
        $area = $parameters['area'];
        $controller = $parameters['controller'];
        $entities->addEntity("Controller/$controller/" . $parameters['action'], 'controller.tpl.php');
        $entities->addFile('routes.tpl.php', "etc/$area/routes.xml");

        return $entities;
    }
}