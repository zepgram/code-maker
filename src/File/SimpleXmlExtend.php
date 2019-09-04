<?php
/**
 * This file is part of Zepgram\CodeMaker\File
 *
 * @package    Zepgram\CodeMaker
 * @file       AppendXml.php
 * @date       31 08 2019 17:27
 * @author     bcalef <zepgram@gmail.com>
 * @license    proprietary
 */
namespace Zepgram\CodeMaker\File;

use SimpleXMLElement;

class SimpleXmlExtend extends SimpleXMLElement
{
    private $childrens;

    /**
     * Add SimpleXMLElement code into a SimpleXMLElement
     * @param SimpleXMLElement $append
     */
    public function appendXML($append)
    {
        foreach ($this->children() as $base) {
            if ($append->asXML() === $base->asXML()) {
                return;
            }
        }
        if (trim((string)$append) === '') {
            $xml = $this->addChild($append->getName());
            foreach ($append->children() as $child) {
                $xml->appendXML($child);
            }
        } else {
            $xml = $this->addChild($append->getName(), (string)$append);
        }
        foreach ($append->attributes() as $n => $v) {
            $xml->addAttribute($n, $v);
        }
    }
}
