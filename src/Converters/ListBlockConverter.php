<?php

namespace Pilipinews\Common\Converters;

use League\HTMLToMarkdown\Converter\ConverterInterface;
use League\HTMLToMarkdown\ElementInterface;

/**
 * List Block Converter
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ListBlockConverter implements ConverterInterface
{
    /**
     * Converts the specified element into a parsed string.
     *
     * @param  \League\HTMLToMarkdown\ElementInterface $element
     * @return string
     */
    public function convert(ElementInterface $element)
    {
        return rtrim("\n" . $element->getValue()) . "\n";
    }

    /**
     * Returns the supported HTML tags.
     *
     * @return string[]
     */
    public function getSupportedTags()
    {
        return array('ol', 'ul');
    }
}
