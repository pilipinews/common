<?php

namespace Pilipinews\Common\Fixture;

use Pilipinews\Common\Article;
use Pilipinews\Common\Client;
use Pilipinews\Common\Interfaces\ScraperInterface;
use Pilipinews\Common\Scraper;
use Symfony\Component\DomCrawler\Crawler;

/**
 * CNN Philippines Scraper
 *
 * @package Pilipinews
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class CnnScraper extends Scraper implements ScraperInterface
{
    /**
     * @var string[]
     */
    protected $removables = array('p > script', '.flourish-credit');

    /**
     * @var string[]
     */
    protected $reload = array(
        'Please click the source link below for more updates.',
        'Please refresh for updates.',
        'Please refresh the page for updates.',
        'Please refresh this page for updates.',
        'Refresh this page for more updates.',
    );

    /**
     * Returns the contents of an article.
     *
     * @param  string $link
     * @return \Pilipinews\Common\Article
     */
    public function scrape($link)
    {
        $this->prepare((string) $link);

        $title = $this->title('.title');

        $body = $this->body('.article-maincontent-p');

        $body = $this->image($body);

        $body = $this->video($this->tweet($body));

        $html = $this->html($body, $this->reload);

        $search = '/pic.twitter.com\/(.*)- CNN/i';

        $replace = (string) 'pic.twitter.com/$1 - CNN';

        $html = preg_replace($search, $replace, $html);

        return new Article($title, $html, $link);
    }

    /**
     * Converts image elements into a readable string.
     *
     * @param  \Symfony\Component\DomCrawler\Crawler $crawler
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function image(Crawler $crawler)
    {
        $callback = function (Crawler $crawler, $html)
        {
            $base = 'https://cnnphilippines.com';

            $link = $crawler->filter('img')->attr('src');

            $caption = $crawler->filter('.picture-caption');

            if ($text = $caption->first()->text())
            {
                $text = ' - ' . $text;
            }

            return '<p>PHOTO: ' . $base . $link . $text . '</p>';
        };

        return $this->replace($crawler, '.img-container.picture', $callback);
    }

    /**
     * Converts video elements to readable string.
     *
     * @param  \Pilipinews\Common\Crawler $crawler
     * @return \Pilipinews\Common\Crawler
     */
    protected function video(Crawler $crawler)
    {
        $callback = function (Crawler $crawler)
        {
            $embed = strpos($link = $crawler->attr('src'), 'embed');

            $type = $embed !== false ? 'EMBED' : 'VIDEO';

            return '<p>' . $type . ': ' . $link . '</p><br><br><br>';
        };

        return $this->replace($crawler, 'p > iframe', $callback);
    }
}
