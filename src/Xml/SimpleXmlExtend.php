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
namespace Zepgram\CodeMaker\Xml;

use SimpleXMLElement;

class SimpleXmlExtend extends SimpleXMLElement
{
    // @todo:
    /* handle cron - node group_id (node)
    /* handle observer - node event (node)
    /* handle commandline - node event (node)

    /**
     * Add SimpleXMLElement code into a SimpleXMLElement
     *
     * @param SimpleXMLElement $append
     *
     * @return bool
     */
    public function appendXML($append)
    {
        // do not add a node already in file
        foreach ($this->children() as $base) {
            if ($append->asXML() === $base->asXML()) {
                return false;
            }
        }
        // write changes
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

        return true;
    }
}
