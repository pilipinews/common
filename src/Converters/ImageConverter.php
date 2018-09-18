<?php

namespace Pilipinews\Common\Converters;

use League\HTMLToMarkdown\Converter\ConverterInterface;
use League\HTMLToMarkdown\ElementInterface;

/**
 * Image Converter
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ImageConverter implements ConverterInterface
{
    /**
     * Converts the specified element into a parsed string.
     *
     * @param  \League\HTMLToMarkdown\ElementInterface $element
     * @return string
     */
    public function convert(ElementInterface $element)
    {
        return "\n\nPHOTO: " . $element->getAttribute('src') . "\n\n";
    }

    /**
     * Returns the supported HTML tags.
     *
     * @return string[]
     */
    public function getSupportedTags()
    {
        return array('img');
    }
}
