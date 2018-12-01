<?php

namespace Pilipinews\Common;

use Pilipinews\Common\Interfaces\CrawlerInterface;
use Pilipinews\Common\Interfaces\ScraperInterface;

/**
 * Collector
 *
 * @package Pilipinews
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Collector
{
    /**
     * @var \Pilipinews\Common\Interfaces\CrawlerInterface
     */
    protected $crawler;

    /**
     * @var \Pilipinews\Common\Interfaces\ScraperInterface
     */
    protected $scraper;

    /**
     * Initializes the collector instance.
     *
     * @param \Pilipinews\Common\Interfaces\CrawlerInterface $crawler
     * @param \Pilipinews\Common\Interfaces\ScraperInterface $scraper
     */
    public function __construct(CrawlerInterface $crawler, ScraperInterface $scraper)
    {
        $this->crawler = $crawler;

        $this->scraper = $scraper;
    }

    /**
     * Returns an array of article instances.
     *
     * @param  callable $callback
     * @return \Pilipinews\Common\Article[]
     */
    public function collect($callback)
    {
        $items = $this->crawler->crawl();

        $articles = array();

        foreach ((array) $items as $item) {
            $article = $this->scraper->scrape($item);

            $articles[] = $callback($article, $item);
        }

        return $articles;
    }
}
