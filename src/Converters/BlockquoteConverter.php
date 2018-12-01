<?php

namespace Pilipinews\Common\Converters;

use League\HTMLToMarkdown\Converter\ConverterInterface;
use League\HTMLToMarkdown\ElementInterface;

/**
 * Blockquote Converter
 *
 * @package Pilipinews
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class BlockquoteConverter implements ConverterInterface
{
    /**
     * Converts the specified element into a parsed string.
     *
     * @param  \League\HTMLToMarkdown\ElementInterface $element
     * @return string
     */
    public function convert(ElementInterface $element)
    {
        // Contents should have already been converted to Markdown by this point,
        // so we just need to add '>' symbols to each line.

        $markdown = '';

        $quote = trim($element->getValue());

        $lines = preg_split('/\r\n|\r|\n/', $quote);

        $total = count((array) $lines);

        foreach ($lines as $i => $line) {
            $markdown .= '> ' . $line . "\n";

            $newline = $i + 1 === $total;

            $newline && $markdown .= "\n";
        }

        return "\n\n" . $markdown;
    }

    /**
     * Returns the supported HTML tags.
     *
     * @return string[]
     */
    public function getSupportedTags()
    {
        return array('blockquote');
    }
}
