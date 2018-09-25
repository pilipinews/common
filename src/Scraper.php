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
     * Returns the article content based on a given element.
     *
     * @param  string $element
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function body($element)
    {
        $body = $this->crawler->filter($element)->first()->html();

        $charset = (string) 'ASCII//TRANSLIT//IGNORE';

        $body = iconv(mb_detect_encoding($body), $charset, $body);

        $body = str_replace(' -- ', ' - ', $body);

        $body = str_replace('-- ', '- ', $body);

        $body = trim(preg_replace('/\s+/', ' ', $body));

        return new Crawler(str_replace('  ', ' ', $body));
    }

    /**
     * Returns the HTML format of the body from the crawler.
     *
     * @param  \Symfony\Component\DomCrawler\Crawler $crawler
     * @param  string[]                              $removables
     * @return string
     */
    protected function html(Crawler $crawler, $removables = array())
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
     * Initializes the crawler instance.
     *
     * @param  string $link
     * @return void
     */
    protected function prepare($link)
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
    protected function remove($elements)
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
     * Replaces a specified HTML tag based from the given callback.
     *
     * @param  \Symfony\Component\DomCrawler\Crawler $crawler
     * @param  string                                $element
     * @param  callable                              $callback
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function replace(Crawler $crawler, $element, $callback)
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
     * Returns the title text based from given HTML tag.
     *
     * @param  string $element
     * @param  string $removable
     * @return string
     */
    protected function title($element, $removable = '')
    {
        $converter = new Converter;

        $crawler = $this->crawler->filter($element);

        $html = $crawler->first()->html();

        $html = str_replace($removable, '', $html);

        return $converter->convert((string) $html);
    }

    /**
     * Parses embedded Twitter tweet in the HTML.
     *
     * @param  \Symfony\Component\DomCrawler\Crawler $crawler
     * @return \Symfony\Component\DomCrawler\Crawler
     */
    protected function tweet(Crawler $crawler)
    {
        $callback = function (Crawler $crawler) {
            $parsed = (string) $crawler->text();

            $text = str_replace('📸: ', '', $parsed);

            return '<p>TWEET: ' . $text . '</p>';
        };

        $class = '.twitter-tweet';

        return $this->replace($crawler, $class, $callback);
    }
}
