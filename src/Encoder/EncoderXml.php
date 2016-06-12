<?php

namespace HansOtt\SpotifyBackupper\Encoder;

use DOMDocument;
use SimpleXMLElement;

final class EncoderXml implements Encoder
{
    public function encode(array $data)
    {
        $element = new SimpleXMLElement('<root/>');
        $this->traverse($data, $element);
        $document = new DOMDocument();
        $document->preserveWhiteSpace = false;
        $document->formatOutput = true;
        $document->loadXML($element->asXML());

        return $document->saveXML();
    }

    private function traverse(array $data, SimpleXMLElement $element)
    {
        if (is_array($data) === false) {
            return;
        }

        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                $key = 'item' . $key;
            }

            if (is_array($value)) {
                $item = $element->addChild($key);
                $this->traverse($value, $item);
            } elseif (is_bool($value)) {
                $element->addChild($key, $value ? '1' : '0');
            } else {
                $element->addChild($key, htmlentities($value));
            }
        }
    }

    public function getFileExtension()
    {
        return 'xml';
    }
}
