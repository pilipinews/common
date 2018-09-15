<?php

namespace Pilipinews\Common\Interfaces;

/**
 * Crawler Interface
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface CrawlerInterface
{
    /**
     * Returns an array of articles to scrape.
     *
     * @return string[]
     */
    public function crawl();
}
