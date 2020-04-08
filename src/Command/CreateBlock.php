<?php
/**
 * This file is part of Zepgram\CodeMaker\Command
 *
 * @package    Zepgram\CodeMaker\Command
 * @file       CreateBlock.php
 * @date       02 09 2019 14:59
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */

namespace Zepgram\CodeMaker\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zepgram\CodeMaker\BaseCommand;

class CreateBlock extends BaseCommand
{
    protected static $defaultName = 'create:block';

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName(self::$defaultName)
            ->setDescription('Create block');
    }

    /**
     * {@inheritdoc}
     */
    protected function getParameters()
    {
        return [
            'area' => ['choice_question', ['frontend','adminhtml']],
            'block_name' => ['Data', 'ucwords']
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->parameters['dependencies'] = $this->parameters['area'] === 'adminhtml' ?
            ['Magento\Backend\Block\Template', 'Magento\Backend\Block\Template\Context'] :
            ['Magento\Framework\View\Element\Template', 'Magento\Framework\View\Element\Template\Context'];

        $this->entities->addEntity('Block/'.$this->parameters['block_name'], 'block.tpl.php');

        parent::execute($input, $output);
    }
}
