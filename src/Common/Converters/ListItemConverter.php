<?php

namespace Pilipinews\Common\Converters;

use League\HTMLToMarkdown\Converter\ConverterInterface;
use League\HTMLToMarkdown\ElementInterface;

/**
 * List Item Converter
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ListItemConverter implements ConverterInterface
{
    /**
     * Converts the specified element into a parsed string.
     *
     * @param  \League\HTMLToMarkdown\ElementInterface $element
     * @return string
     */
    public function convert(ElementInterface $element)
    {
        // If parent is an ol, use numbers, otherwise, use dashes
        $list_type = $element->getParent()->getTagName();

        // Add spaces to start for nested list items
        $level = $element->getListItemLevel($element);

        $prefixForParagraph = str_repeat('  ', $level + 1);
        $value = trim(implode("\n" . $prefixForParagraph, explode("\n", trim($element->getValue()))));

        // If list item is the first in a nested list, add a newline before it
        $prefix = '';

        if ($level > 0 && $element->getSiblingPosition() === 1) $prefix = "\n";

        if ($list_type === 'ol') {
            $number = $element->getSiblingPosition();

            return $prefix . $number . '. ' . $value . "\n";
        }

        return $prefix . '* ' . $value . "\n";
    }

    /**
     * Returns the supported HTML tags.
     *
     * @return string[]
     */
    public function getSupportedTags()
    {
        return array('li');
    }
}
