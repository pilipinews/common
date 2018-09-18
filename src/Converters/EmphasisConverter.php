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
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
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

        if (!trim($value)) {
            return '';
        }

        $regex = '(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9]\.[^\s]{2,})';

        preg_match($regex, $value, $matches);

        if ($tag === 'i' || $tag === 'em') {
            $style = $this->config->getOption('italic_style');
        } else {
            $style = $this->config->getOption('bold_style');

            if (! isset($matches[0])) {
                $value = mb_convert_case($value, MB_CASE_UPPER, 'UTF-8');
            }
        }

        $prefix = ltrim($value) !== $value ? ' ' : '';
        $suffix = rtrim($value) !== $value ? ' ' : '';

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
}
