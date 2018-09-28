<?php

namespace Pilipinews\Common;

/**
 * Article
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Article
{
    /**
     * @var string
     */
    protected $body = '';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * Initializes the article instance.
     *
     * @param string $title
     * @param string $body
     */
    public function __construct($title, $body)
    {
        $this->body = $body;

        $this->title = $title;
    }

    /**
     * Returns the body content.
     *
     * @return string
     */
    public function body()
    {
        return $this->body;
    }

    /**
     * Returns both title and body content.
     *
     * @return string
     */
    public function post()
    {
        return mb_strtoupper($this->title, 'UTF-8') . "\n\n" . $this->body;
    }

    /**
     * Returns the title text.
     *
     * @return string
     */
    public function title()
    {
        return $this->title;
    }
}
