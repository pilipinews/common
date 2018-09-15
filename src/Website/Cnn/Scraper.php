<?php

namespace Pilipinews\Website\Cnn;

use Pilipinews\Common\Article;
use Pilipinews\Common\Client;
use Pilipinews\Common\Interfaces\ScraperInterface;
use Pilipinews\Common\Scraper as AbstractScraper;
use Symfony\Component\DomCrawler\Crawler;

/**
 * CNN Philippines Scraper
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Scraper extends AbstractScraper implements ScraperInterface
{
    /**
     * @var string[]
     */
    protected $removables = array('p > script');

    /**
     * @var string[]
     */
    protected $reload = array(
        'Please click the source link below for more updates.',
        'Please refresh for updates.',
        'Please refresh this page for updates.',
        'Refresh this page for more updates.',
    );

    /**
     * Initializes the scraper instance.
     *
     * @param string $link
     */
    public function __construct($link)
    {
        $pattern = '/content-body-[0-9]+(-[0-9]+)+/i';

        $html = Client::request($link);

        preg_match($pattern, $html, $matches);

        $html = str_replace($matches[0], 'content-body', $html);

        $this->crawler = new Crawler($html);
    }

    /**
     * Returns the contents of an article.
     *
     * @return \Pilipinews\Common\Article
     */
    public function scrape()
    {
        $this->remove((array) $this->removables);

        $title = $this->title('title', ' - CNN Philippines');

        $body = $this->body('#content-body');

        $body = $this->video($this->tweet($body));

        $html = $this->html($body, $this->reload);

        $search = '/pic.twitter.com\/(.*)- CNN/i';

        $replace = (string) 'pic.twitter.com/$1 - CNN';

        $html = preg_replace($search, $replace, $html);

        return new Article($title, (string) $html);
    }

    /**
     * Converts video elements to readable string.
     *
     * @param  \Symfony\Component\DomCrawler\Crawler $crawler
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function video(Crawler $crawler)
    {
        $callback = function (Crawler $crawler) {
            $link = (string) $crawler->attr('src');

            return '<p>VIDEO: ' . $link . '</p>';
        };

        return $this->replace($crawler, 'p > iframe', $callback);
    }
}
