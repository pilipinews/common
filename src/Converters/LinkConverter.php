<?php

namespace Pilipinews\Common\Converters;

use League\HTMLToMarkdown\Converter\ConverterInterface;
use League\HTMLToMarkdown\ElementInterface;

/**
 * Link Converter
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class LinkConverter implements ConverterInterface
{
    /**
     * Converts the specified element into a parsed string.
     *
     * @param  \League\HTMLToMarkdown\ElementInterface $element
     * @return string
     */
    public function convert(ElementInterface $element)
    {
        $text = trim($element->getValue(), "\t\n\r\0\x0B");

        $href = $element->getAttribute('href');

        $markdown = $text . ' (' . $href . ')';

        $autolink = $this->isValidAutolink((string) $href);

        $href === $text && $autolink && $markdown = $href;

        return $markdown;
    }

    /**
     * Returns the supported HTML tags.
     *
     * @return string[]
     */
    public function getSupportedTags()
    {
        return array('a');
    }

    /**
     * @param string $href
     *
     * @return bool
     */
    private function isValidAutolink($href)
    {
        return preg_match('/^[A-Za-z][A-Za-z0-9.+-]{1,31}:[^<>\x00-\x20]*/i', $href) === 1;
    }
}
