<?php

namespace Pilipinews\Common\Converters;

use League\HTMLToMarkdown\Converter\ConverterInterface;
use League\HTMLToMarkdown\ElementInterface;

class TableBlockConverter implements ConverterInterface
{
    /**
     * Converts the specified element into a parsed string.
     *
     * @param  \League\HTMLToMarkdown\ElementInterface $element
     * @return string
     */
    public function convert(ElementInterface $element)
    {
        $lines = explode("\n", $element->getValue());

        foreach ($lines as $key => $line)
        {
            $lines[$key] = trim($lines[$key]);
        }

        $lines = array_filter($lines);

        return "\n" . implode("\n", (array) $lines);
    }

    /**
     * Returns the supported HTML tags.
     *
     * @return string[]
     */
    public function getSupportedTags()
    {
        return array('table');
    }
}
