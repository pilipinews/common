<?php

namespace Pilipinews\Common;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Abstract Scraper
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class Scraper
{
    /**
     * @var \Symfony\Component\DomCrawler\Crawler
     */
    protected $crawler;

    /**
     * Initializes the scraper instance.
     *
     * @param string $link
     */
    public function __construct($link)
    {
        $response = Client::request((string) $link);

        $this->crawler = new Crawler($response);
    }

    /**
     * Removes specified HTML tags from body.
     *
     * @param  string[] $elements
     * @return void
     */
    public function remove($elements)
    {
        $callback = function ($crawler) {
            $node = $crawler->getNode((integer) 0);

            $node->parentNode->removeChild($node);
        };

        foreach ((array) $elements as $removable) {
            $this->crawler->filter($removable)->each($callback);
        }
    }

    /**
     * Returns the title text based from given HTML tag.
     *
     * @param  string $element
     * @param  string $removable
     * @return string
     */
    public function title($element, $removable = '')
    {
        $converter = new Converter;

        $crawler = $this->crawler->filter($element);

        $html = $crawler->first()->html();

        $html = str_replace($removable, '', $html);

        return $converter->convert((string) $html);
    }

    /**
     * Returns the HTML format of the body from the crawler.
     *
     * @param  \Symfony\Component\DomCrawler\Crawler $crawler
     * @param  string[]                              $removables
     * @return string
     */
    public function html(Crawler $crawler, $removables = array())
    {
        $converter = new Converter;

        $html = $converter->convert($crawler->html());

        foreach ((array) $removables as $keyword) {
            $html = str_replace($keyword, '', $html);

            $html = str_replace("\n\n\n", '', $html);
        }

        return trim(preg_replace('/\s\s+/', "\n\n", $html));
    }

    /**
     * Returns the article content based on a given element.
     *
     * @param  string $element
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function body($element)
    {
        $body = $this->crawler->filter($element)->first()->html();

        $body = trim(preg_replace('/\s+/', ' ', $body));

        return new Crawler(str_replace('  ', ' ', trim($body)));
    }

    /**
     * Replaces a specified HTML tag based from the given callback.
     *
     * @param  \Symfony\Component\DomCrawler\Crawler $crawler
     * @param  string                                $element
     * @param  callable                              $callback
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function replace(Crawler $crawler, $element, $callback)
    {
        $function = function (Crawler $crawler) use ($callback) {
            $node = $crawler->getNode(0);

            $html = $node->ownerDocument->saveHtml($node);

            $text = $callback($crawler, (string) $html);

            return array((string) $html, (string) $text);
        };

        $items = $crawler->filter($element)->each($function);

        $html = (string) $crawler->html();

        foreach ((array) $items as $item) {
            $html = str_replace($item[0], $item[1], $html);
        }

        return new Crawler((string) $html);
    }

    /**
     * Parses embedded Twitter tweet in the HTML.
     *
     * @param  \Symfony\Component\DomCrawler\Crawler $crawler
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    public function tweet(Crawler $crawler)
    {
        $callback = function (Crawler $crawler) {
            $text = str_replace('📸: ', '', $crawler->text());

            return (string) '<p>TWEET: ' . $text . '</p>';
        };

        return $this->replace($crawler, '.twitter-tweet', $callback);
    }
}
