<?php

namespace Pilipinews\Common\Fixture;

use Pilipinews\Common\Interfaces\CrawlerInterface;

/**
 * CNN Philippines Crawler
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CnnCrawler implements CrawlerInterface
{
    /**
     * Returns an array of articles to scrape.
     *
     * @return string[]
     */
    public function crawl()
    {
        $items = array();

        $items[] = 'http://cnnphilippines.com/news/2018/09/11/AFP-tank-sightings-EDSA.html';

        return $items;
    }
}
