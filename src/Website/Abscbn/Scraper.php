<?php

namespace Pilipinews\Website\Abscbn;

use Pilipinews\Common\Article;
use Pilipinews\Common\Interfaces\ScraperInterface;
use Pilipinews\Common\Scraper as AbstractScraper;
use Symfony\Component\DomCrawler\Crawler;

/**
 * ABS-CBN News Scraper
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Scraper extends AbstractScraper implements ScraperInterface
{
    /**
     * @var string[]
     */
    protected $removables = array('.patrolbox', '.op-related-articles', 'script', '.iwantbar');

    /**
     * @var string[]
     */
    protected $texts = array('I-refresh ang pahinang ito para sa updates.', 'Refresh this link for more details.');

    /**
     * Returns the contents of an article.
     *
     * @return \Pilipinews\Common\Article
     */
    public function scrape()
    {
        $title = $this->title('h1.news-title');

        $this->remove((array) $this->removables);

        $body = $this->body('.article-content');

        $body = $this->image($body);

        $body = $this->tweet($body);

        $body = $this->video($body);

        $html = $this->html($body, $this->texts);

        return new Article($title, (string) $html);
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
            $image = 'PHOTO: ' . $crawler->filter('img')->attr('src');

            $image = str_replace('?ext=.jpg', '', (string) $image);

            $text = '<p>' . $image . ' - ' . $crawler->text() . '</p>';

            if (strpos($html, '<em>') !== false) {
                $em = $crawler->filter('em')->first()->text();

                $text = str_replace($em, '(' . $em . ')', $text);
            }

            return str_replace(' -   </', '</', (string) $text);
        };

        return $this->replace($crawler, '.embed-wrap', $callback);
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
            $element = $crawler->filter('iframe');

            $link = $element->attr('src');

            return '<p>VIDEO: ' . $link . '</p>';
        };

        return $this->replace($crawler, '.op-interactive', $callback);
    }
}
