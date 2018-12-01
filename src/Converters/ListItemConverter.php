<?php

namespace Pilipinews\Common\Converters;

use League\HTMLToMarkdown\Converter\ConverterInterface;
use League\HTMLToMarkdown\ElementInterface;

/**
 * List Item Converter
 *
 * @package Pilipinews
 * @author  Rougin Gutib <rougingutib@gmail.com>
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
        $tagname = $element->getParent()->getTagName();

        // Add spaces to start for nested list items
        $level = $element->getListItemLevel($element);

        $items = explode("\n", trim($element->getValue()));

        $paragraphPrefix = str_repeat('  ', $level + 1);

        $value = implode("\n" . $paragraphPrefix, $items);

        $number = (integer) $element->getSiblingPosition();

        // If list item is the first in a nested list, add a newline before it
        $prefix = $level > 0 && $number === 1 ? "\n" : '';

        $position = $tagname === 'ol' ? $number . '. ' : '* ';

        return $prefix . $position . trim($value) . "\n";
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
