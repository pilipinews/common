<?php

namespace Pilipinews\Website\Rappler;

use Pilipinews\Common\Client;
use Pilipinews\Common\Interfaces\CrawlerInterface;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

/**
 * Rappler News Crawler
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Crawler implements CrawlerInterface
{
    /**
     * @var string[]
     */
    protected $excluded = array('IN PHOTOS', 'LIVE', 'WATCH', 'LOOK', 'Rappler Talk', 'PANOORIN');

    /**
     * @var string
     */
    protected $link = 'https://www.rappler.com/previous-articles/';

    /**
     * @var string
     */
    protected $pattern = '#article-finder-result > .rappler-light-gray h4 > a';

    /**
     * Returns an array of articles to scrape.
     *
     * @return string[]
     */
    public function crawl()
    {
        $base = 'https://www.rappler.com';

        $excluded = function ($text) {
            preg_match('/(.*):(.*)/i', $text, $matches);

            $keyword = isset($matches[1]) ? $matches[1] : null;

            return in_array($keyword, $this->excluded);
        };

        $callback = function (DomCrawler $node) use ($base, $excluded) {
            $items = explode('/', $link = $node->attr('href'));

            $allowed = $items[1] === 'nation' && ! $excluded($node->text());

            return $allowed ? $base . $node->attr('href') : null;
        };

        $crawler = new DomCrawler(Client::request($this->link));

        $news = $crawler->filter($this->pattern);

        return array_reverse(array_filter($news->each($callback)));
    }
}
