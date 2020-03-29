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
use Zepgram\CodeMaker\FormatClass;

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
        $area = $this->parameters['area'];
        $isBackend = $area === 'adminhtml';
        $classArea = $isBackend ? 'Block/Adminhtml' : 'Block';

        $classTemplate = new FormatClass(
            $this->maker->getModuleNamespace(),
            $classArea . "/" . $this->parameters['block_name']
        );

        $this->parameters['dependencies'] = $isBackend ?
            ['Magento\Backend\Block\Template', 'Magento\Backend\Block\Template\Context'] :
            ['Magento\Framework\View\Element\Template', 'Magento\Framework\View\Element\Template\Context'];
        $this->parameters['class_block'] = $classTemplate->getName();
        $this->parameters['name_space_block'] = $classTemplate->getNamespace();
        $filePath = [
            'block.tpl.php' => $classTemplate->getFileName(),
        ];
        $this->maker->setTemplateParameters($this->parameters)
            ->setFilesPath($filePath);

        parent::execute($input, $output);
    }
}