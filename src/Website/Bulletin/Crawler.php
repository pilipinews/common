<?php

namespace Pilipinews\Website\Bulletin;

use Pilipinews\Common\Client;
use Pilipinews\Common\Interfaces\CrawlerInterface;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

/**
 * Manila Bulletin Crawler
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Crawler implements CrawlerInterface
{
    /**
     * @var string[]
     */
    protected $categories = array(
        'http://news.mb.com.ph/category/national/',
        'http://news.mb.com.ph/category/metro/',
        'http://news.mb.com.ph/category/provincial/',
    );

    /**
     * Returns an array of articles to scrape.
     *
     * @return string[]
     */
    public function crawl()
    {
        $articles = array();

        foreach ((array) $this->categories as $link) {
            $crawler = new DomCrawler(Client::request($link));

            $news = $crawler->filter('.uk-grid .uk-article');

            $items = $news->each(function (DomCrawler $node) {
                return $node->attr('data-permalink');
            });

            $articles = array_merge($articles, $items);
        }

        return array_reverse((array) $articles);
    }
}
