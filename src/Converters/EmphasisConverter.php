<?php

namespace Pilipinews\Common\Converters;

use League\HTMLToMarkdown\Configuration;
use League\HTMLToMarkdown\ConfigurationAwareInterface;
use League\HTMLToMarkdown\Converter\ConverterInterface;
use League\HTMLToMarkdown\ElementInterface;

/**
 * Emphasis Converter
 *
 * @package Pilipinews
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class EmphasisConverter implements ConverterInterface, ConfigurationAwareInterface
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
        $tag = $element->getTagName();

        $value = $element->getValue();

        if ($tag === 'i' || $tag === 'em') {
            $style = $this->config->getOption('italic_style');
        } else {
            $style = $this->config->getOption('bold_style');

            if (! $this->hasLinks($value)) {
                $value = mb_convert_case($value, MB_CASE_UPPER, 'UTF-8');
            }
        }

        list($prefix, $suffix) = $this->prefixSuffix($value);

        return $prefix . $style . trim($value) . $style . $suffix;
    }

    /**
     * Returns the supported HTML tags.
     *
     * @return string[]
     */
    public function getSupportedTags()
    {
        return array('em', 'i', 'strong', 'b');
    }

    /**
     * Checks if the specified string contains a URL.
     *
     * @param  string  $string
     * @return boolean
     */
    protected function hasLinks($string)
    {
        $regex = '(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})';

        preg_match($regex, $string, $matches);

        return isset($matches[0]) === true;
    }

    /**
     * Returns prefix and suffix of a specified string.
     *
     * @param  string $string
     * @return string
     */
    protected function prefixSuffix($string)
    {
        $prefix = ltrim($string) !== $string ? ' ' : '';

        $suffix = rtrim($string) !== $string ? ' ' : '';

        return (array) array($prefix, $suffix);
    }
}
