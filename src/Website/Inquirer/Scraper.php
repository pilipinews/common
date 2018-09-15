<?php

namespace Pilipinews\Website\Inquirer;

use Pilipinews\Common\Article;
use Pilipinews\Common\Interfaces\ScraperInterface;
use Pilipinews\Common\Scraper as AbstractScraper;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Inquirer News Scraper
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Scraper extends AbstractScraper implements ScraperInterface
{
    const TEXT_FOOTER = 'Subscribe to INQUIRER PLUS (http://www.inquirer.net/plus) to get access to The Philippine Daily Inquirer & other 70+ titles, share up to 5 gadgets, listen to the news, download as early as 4am & share articles on social media. Call 896 6000.';

    /**
     * @var string[]
     */
    protected $removables = array(
        'script',
        '#billboard_article',
        '.ventuno-vid',
        '#article_disclaimer',
        '.OUTBRAIN',
        '#ch-follow-us',
        '.view-comments',
        '#article_tags',
        '.adsbygoogle',
        '#article-new-featured',
        '#read-next-2018',
        '#rn-lbl',
    );

    /**
     * Returns the contents of an article.
     *
     * @return \Pilipinews\Common\Article
     */
    public function scrape()
    {
        $title = (string) $this->title('.entry-title');

        $this->remove((array) $this->removables);

        $body = $this->body('#article_content');

        $body = $this->video($body)->html();

        $body = preg_replace('/-(\d+)x(\d+).jpg/i', '.jpg', $body);

        $body = $this->html(new Crawler((string) $body));

        $body = str_replace(self::TEXT_FOOTER, '', $body);

        return new Article($title, (string) trim($body));
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

        $crawler = $this->replace($crawler, 'p > iframe', $callback);

        $callback = function (Crawler $crawler) {
            $text = '<p>VIDEO: ' . $crawler->attr('cite') . '</p>';

            $message = $crawler->filter('p > a')->first();

            return $text . '<p>' . $message->text() . '</p>';
        };

        return $this->replace($crawler, '.fb-xfbml-parse-ignore', $callback);
    }
}
