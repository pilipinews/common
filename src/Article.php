<?php

namespace Pilipinews\Common;

/**
 * Article
 *
 * @package Pilipinews
 * @author  Rougin Gutib <rougingutib@gmail.com>
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
     * @var string
     */
    protected $link = '';

    /**
     * Initializes the article instance.
     *
     * @param string $title
     * @param string $body
     * @param string $link
     */
    public function __construct($title, $body, $link = null)
    {
        $this->body = $body;

        $this->title = $title;

        $this->link = $link;
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
     * Returns the source link.
     *
     * @return string
     */
    public function link()
    {
        return $this->link;
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
