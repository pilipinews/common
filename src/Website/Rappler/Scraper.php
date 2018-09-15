<?php

namespace Pilipinews\Website\Rappler;

use Pilipinews\Common\Article;
use Pilipinews\Common\Interfaces\ScraperInterface;
use Pilipinews\Common\Scraper as AbstractScraper;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Rappler News Scraper
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Scraper extends AbstractScraper implements ScraperInterface
{
    /**
     * @var string[]
     */
    protected $removables = array('.author-box');

    /**
     * @var string[]
     */
    protected $texts = array('Please refresh this page for updates.');

    /**
     * Returns the contents of an article.
     *
     * @return \Pilipinews\Common\Article
     */
    public function scrape()
    {
        $title = $this->title('.select-headline');

        $this->remove((array) $this->removables);

        $body = $this->body('.storypage-divider');

        $body = $this->image($body);

        $body = $this->scribd($body);

        $body = $this->video($body);

        $html = $this->html($body, $this->texts);

        return new Article($title, $html);
    }

    /**
     * Converts image elements to readable string.
     *
     * @param  \Symfony\Component\DomCrawler\Crawler $crawler
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function image(Crawler $crawler)
    {
        $callback = function (Crawler $crawler, $html) {
            $image = $crawler->attr('data-original');

            return 'IMAGE: ' . (string) $image . "\n\n\n";
        };

        return $this->replace($crawler, 'img', $callback);
    }

    /**
     * Converts embedded Scribd elements to readable string.
     *
     * @param  \Symfony\Component\DomCrawler\Crawler $crawler
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function scribd(Crawler $crawler)
    {
        $callback = function (Crawler $crawler, $html) {
            $title = (string) $crawler->attr('title');

            $link = (string) $crawler->attr('src');

            return '<p>' . $title . ' (' . $link . ')</p>';
        };

        $class = (string) '.scribd_iframe_embed';

        return $this->replace($crawler, $class, $callback);
    }

    /**
     * Converts embedded iframe elements to readable string.
     *
     * @param  \Symfony\Component\DomCrawler\Crawler $crawler
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function video(Crawler $crawler)
    {
        $callback = function (Crawler $crawler, $html) {
            return '<p>VIDEO: ' . $crawler->attr('src') . '</p>';
        };

        return $this->replace($crawler, 'iframe', $callback);
    }
}
