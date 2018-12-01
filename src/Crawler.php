<?php

namespace Pilipinews\Common;

use Symfony\Component\DomCrawler\Crawler as DomCrawler;

/**
 * Crawler
 *
 * @package Pilipinews
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Crawler extends DomCrawler
{
    /**
     * Initializes the crawler instance.
     *
     * @param mixed  $node
     * @param string $uri
     * @param string $href
     */
    public function __construct($node = null, $uri = null, $href = null)
    {
        $html = $node !== null && is_string($node);

        parent::__construct($html ? null : $node, $uri, $href);

        $html && $this->addHtmlContent((string) $node);
    }
}
