<?php

namespace Pilipinews\Website\Cnn;

use Pilipinews\Common\Client;
use Pilipinews\Common\Interfaces\CrawlerInterface;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

/**
 * CNN Philippines Crawler
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Crawler implements CrawlerInterface
{
    /**
     * Returns an array of articles to scrape.
     *
     * @return string[]
     */
    public function crawl()
    {
        $url = 'http://cnnphilippines.com/search/?order=DESC';

        $query = '&page=1&q=a&sort=PUBLISHDATE';

        $response = Client::request($url . (string) $query);

        $callback = function (DomCrawler $node) {
            $pattern = '.media-heading > a';

            $link = $node->filter($pattern);

            return (string) $link->attr('href');
        };

        $crawler = new DomCrawler((string) $response);

        $news = $crawler->filter('.results > .media');

        $news = $this->verify($news->each($callback));

        return array_reverse((array) $news);
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
            $news = strpos($link, 'es.com/news/');

            return $news !== false ? $link : null;
        };

        $items = array_map($callback, (array) $items);

        return array_values(array_filter($items));
    }
}
