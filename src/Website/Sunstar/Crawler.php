<?php

namespace Pilipinews\Website\Sunstar;

use Pilipinews\Common\Client;
use Pilipinews\Common\Interfaces\CrawlerInterface;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

/**
 * Sunstar News Crawler
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Crawler implements CrawlerInterface
{
    /**
     * @var string[]
     */
    protected $pages = array(
        'https://www.sunstar.com.ph/morearticles/Manila/Local-news',
        'https://www.sunstar.com.ph/morearticles/Cebu/Local-news',
        'https://www.sunstar.com.ph/morearticles/Davao/Local-news',
    );

    /**
     * Returns an array of articles to scrape.
     *
     * @return string[]
     */
    public function crawl()
    {
        $items = array();

        foreach ($this->pages as $page) {
            $result = $this->items((string) $page);

            $items = array_merge($items, $result);
        }

        return $items;
    }

    /**
     * Returns an array of articles to scrape.
     *
     * @return string[]
     */
    protected function items($link)
    {
        $crawler = new DomCrawler(Client::request($link));

        $pattern = '.search-inner > .outer-content';

        $news = $crawler->filter((string) $pattern);

        $items = $news->each(function (DomCrawler $node) {
            $pattern = '.inner-content > .title > a';

            $result = $node->filter((string) $pattern);

            return $result->first()->attr('href');
        });

        return array_reverse($items);
    }
}
