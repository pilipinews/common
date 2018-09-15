<?php

namespace Pilipinews\Website\Inquirer;

use Pilipinews\Common\Client;
use Pilipinews\Common\Interfaces\CrawlerInterface;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

/**
 * Inquirer News Crawler
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Crawler implements CrawlerInterface
{
    /**
     * @var string[]
     */
    protected $allowed = array('Headlines', 'Regions', 'Nation');

    /**
     * Returns an array of articles to scrape.
     *
     * @return string[]
     */
    public function crawl()
    {
        $link = 'https://newsinfo.inquirer.net/category/latest-stories';

        $response = Client::request((string) $link);

        $callback = function (DomCrawler $node) {
            $category = $node->filter('#ch-cat')->first();

            $allowed = in_array($category->text(), $this->allowed);

            $link = $node->filter('a')->first();

            return $allowed ? $link->attr('href') : null;
        };

        $crawler = new DomCrawler((string) $response);

        $news = $crawler->filter('#inq-channel-left > #ch-ls-box');

        return array_values(array_filter($news->each($callback)));
    }
}
