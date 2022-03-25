<?php

declare(strict_types=1);

/*
 * This file is part of Zepgram Code Maker.
 * (c) Benjamin Calef <bcalef.pro@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zepgram\CodeMaker\Entity;

use Zepgram\CodeMaker\Editor\Entities;

class Controller
{
    public function create(array $parameters, Entities $entities)
    {
        $area = $parameters['area'];
        $controller = $parameters['controller'];
        if ($area === 'adminhtml') {
            $controller = 'Adminhtml/'.$controller;
        }
        $entities->addEntity("Controller/$controller/" . $parameters['action'], 'controller.tpl.php');
        $entities->addFile('routes.tpl.php', "etc/$area/routes.xml");

        return $entities;
    }
}
