<?php

namespace Pilipinews\Common\Converters;

use League\HTMLToMarkdown\Configuration;
use League\HTMLToMarkdown\ConfigurationAwareInterface;
use League\HTMLToMarkdown\Converter\ConverterInterface;
use League\HTMLToMarkdown\ElementInterface;

/**
 * Header Converter
 *
 * @package Pilipinews
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class HeaderConverter implements ConverterInterface, ConfigurationAwareInterface
{
    /**
     * @var \League\HTMLToMarkdown\Configuration
     */
    protected $config;

    /**
     * Sets the configuration instance.
     *
     * @param \League\HTMLToMarkdown\Configuration $config
     */
    public function setConfig(Configuration $config)
    {
        $this->config = $config;
    }

    /**
     * Converts the specified element into a parsed string.
     *
     * @param  \League\HTMLToMarkdown\ElementInterface $element
     * @return string
     */
    public function convert(ElementInterface $element)
    {
        $regex = '(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})';

        preg_match($regex, $value = $element->getValue(), $matches);

        if (! isset($matches[0]))
        {
            $value = mb_convert_case($value, MB_CASE_UPPER, 'UTF-8');
        }

        return "\n" . $value . "\n";
    }

    /**
     * Returns the supported HTML tags.
     *
     * @return string[]
     */
    public function getSupportedTags()
    {
        return array('h1', 'h2', 'h3', 'h4', 'h5', 'h6');
    }
}
