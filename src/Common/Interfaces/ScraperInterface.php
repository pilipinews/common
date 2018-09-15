<?php

namespace Pilipinews\Common\Interfaces;

/**
 * Scraper Interface
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface ScraperInterface
{
    /**
     * Returns the contents of an article.
     *
     * @return \Pilipinews\Common\Article
     */
    public function scrape();
}
