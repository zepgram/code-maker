<?php

/*
 * This file is part of Zepgram Code Maker.
 * (c) Benjamin Calef <bcalef.pro@gmail.com>
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Zepgram\CodeMaker\SimpleXml;

use SimpleXMLElement;

class SimpleXmlExtend extends SimpleXMLElement
{
    const XML_NAMESPACE_XSI = 'http://www.w3.org/2001/XMLSchema-instance';

    /**
     * Add SimpleXMLElement code into a SimpleXMLElement
     *
     * @param SimpleXMLElement $append
     *
     * @return bool
     */
    public function appendXML(SimpleXMLElement $append)
    {
        // do not add a node already in file
        foreach ($this->children() as $base) {
            if ($append->asXML() === $base->asXML()) {
                return false;
            }
        }
        // add child
        if (trim((string)$append) === '') {
            $xml = $this->addChild($append->getName());
        } else {
            $xml = $this->addChild($append->getName(), (string)$append);
        }
        // append child and add attributes
        foreach ($append->children() as $child) {
            $xml->appendXML($child);
        }
        foreach ($append->attributes() as $n => $v) {
            $xml->addAttribute($n, $v);
        }
        foreach ($append->attributes('xsi', true) as $xsi => $value) {
            $xml->addAttribute('xsi:'.$xsi, $value, self::XML_NAMESPACE_XSI);
        }

        return true;
    }
}
