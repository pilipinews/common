<?php

namespace Pilipinews\Website\Abscbn;

use Pilipinews\Common\Client;
use Pilipinews\Common\Interfaces\CrawlerInterface;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

/**
 * ABS-CBN News Crawler
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Crawler implements CrawlerInterface
{
    /**
     * @var string
     */
    protected $link = 'https://news.abs-cbn.com/news';

    /**
     * Returns an array of articles to scrape.
     *
     * @return string[]
     */
    public function crawl()
    {
        $response = Client::request($this->link);

        $callback = function (DomCrawler $node) {
            $url = 'https://news.abs-cbn.com';

            return $url . $node->attr('href');
        };

        $crawler = new DomCrawler((string) $response);

        $news = $crawler->filter('#latest-news li > p > a');

        $news = $this->verify($news->each($callback));

        return array_reverse(array_filter((array) $news));
    }

    /**
     * Returns the allowed article URLs to scrape.
     *
     * @param  string[] $items
     * @return string[]
     */
    protected function verify($items)
    {
        $callback = function ($link) {
            $news = strpos($link, '.com/news/') !== false;

            $media = strpos($link, 'news/multimedia') === false;

            return $news && $media === true ? $link : null;
        };

        $items = array_map($callback, (array) $items);

        return array_values(array_filter($items));
    }
}
