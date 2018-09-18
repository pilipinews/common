<?php

namespace Pilipinews\Common\Fixture;

use Pilipinews\Common\Article;
use Pilipinews\Common\Scraper;
use Pilipinews\Common\Interfaces\ScraperInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Sunstar News Scraper
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SunstarScraper extends Scraper implements ScraperInterface
{
    /**
     * @var string[]
     */
    protected $removables = array('.pagingWrap', 'script', '#fb-root');

    /**
     * @var string[]
     */
    protected $refresh = array('Please refresh page for updates.');

    /**
     * Returns the contents of an article.
     *
     * @param  string $link
     * @return \Pilipinews\Common\Article
     */
    public function scrape($link)
    {
        $this->prepare((string) $link);

        $title = $this->title('title', ' - SUNSTAR');

        $this->remove($this->removables);

        $body = $this->video($this->body('.articleBody'));

        $html = $this->html($body, $this->refresh);

        return new Article($title, (string) $html);
    }

    /**
     * Returns the article content based on a given element.
     *
     * @param  string $element
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function body($element)
    {
        return $this->crawler->filter($element)->last();
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
            $link = trim($crawler->attr('data-href'));

            return '<br><br>VIDEO: ' . (string) $link;
        };

        return $this->replace($crawler, '.fb-video', $callback);
    }
}
