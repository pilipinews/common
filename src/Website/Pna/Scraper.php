<?php

namespace Pilipinews\Website\Pna;

use Pilipinews\Common\Scraper as AbstractScraper;
use Pilipinews\Common\Article;
use Pilipinews\Common\Interfaces\ScraperInterface;

/**
 * Philippine News Agency Scraper
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Scraper extends AbstractScraper implements ScraperInterface
{
    /**
     * Returns the contents of an article.
     *
     * @return \Pilipinews\Common\Article
     */
    public function scrape()
    {
        $title = (string) $this->title('h1');

        $body = $this->body('.page-content');

        return new Article($title, $this->html($body));
    }
}
