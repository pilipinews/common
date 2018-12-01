<?php

namespace Pilipinews\Common\Converters;

use League\HTMLToMarkdown\Converter\ConverterInterface;
use League\HTMLToMarkdown\ElementInterface;

class TableRowConverter implements ConverterInterface
{
    /**
     * Converts the specified element into a parsed string.
     *
     * @param  \League\HTMLToMarkdown\ElementInterface $element
     * @return string
     */
    public function convert(ElementInterface $element)
    {
        $children = array();

        foreach ($element->getChildren() as $item)
        {
            $value = str_replace("\n", ' ', $item->getValue());

            $null = $value === ' ' || empty($value);

            $null === false && array_push($children, $value);
        }

        return implode(' - ', $children) . "\n";
    }

    /**
     * Returns the supported HTML tags.
     *
     * @return string[]
     */
    public function getSupportedTags()
    {
        return array('tr');
    }
}
