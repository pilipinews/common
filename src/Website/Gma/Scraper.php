<?php

namespace Pilipinews\Website\Gma;

use Pilipinews\Common\Article;
use Pilipinews\Common\Client;
use Pilipinews\Common\Interfaces\ScraperInterface;
use Pilipinews\Common\Scraper as AbstractScraper;
use Symfony\Component\DomCrawler\Crawler;

/**
 * GMA News Scraper
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Scraper extends AbstractScraper implements ScraperInterface
{
    /**
     * Initializes the scraper instance.
     *
     * @param string $link
     */
    public function __construct($link)
    {
        $response = (string) Client::request((string) $link);

        $html = trim(preg_replace('/\s+/', ' ', $response));

        $html = str_replace('&nbsp;', ' ', $html);

        $html = str_replace('&mdash;', '-', $html);

        $html = str_replace('<p> <strong>', '<p><strong>', $html);

        $html = str_replace('<br /> ', '<br />', $html);

        preg_match('/var initialData = {(.*?)};/i', $html, $match);

        $this->json = json_decode('{' . $match[1] . '}', true);

        $this->crawler = new Crawler($this->json['story']['main']);
    }

    /**
     * Returns the contents of an article.
     *
     * @return \Pilipinews\Common\Article
     */
    public function scrape()
    {
        $title = (string) $this->json['story']['title'];

        $body = $this->tweet($this->crawler);

        return new Article($title, $this->html($body));
    }
}
