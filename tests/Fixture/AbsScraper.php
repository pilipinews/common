<?php

namespace Pilipinews\Common\Fixture;

use Pilipinews\Common\Article;
use Pilipinews\Common\Scraper;
use Pilipinews\Common\Interfaces\ScraperInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Abs Scraper
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class AbsScraper extends Scraper implements ScraperInterface
{
    /**
     * @var string
     */
    protected $html = '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><title>Hello World</title></head><body><h1>Hello World</h1><div class="content"><small>This should not be displayed.</small><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat optio, incidunt inventore enim ullam earum, libero commodi et soluta facilis veniam quae ut nihil officia accusantium totam, ab possimus quos.</p><p>Magnam ratione reiciendis, hic amet consectetur voluptates repellat mollitia, odio quas ipsum excepturi quasi rem recusandae delectus suscipit molestiae quaerat porro, eos.</p></div></body></html>';

    /**
     * @var string[]
     */
    protected $removables = array('small');

    /**
     * Returns the contents of an article.
     *
     * @param  string $link
     * @return \Pilipinews\Common\Article
     */
    public function scrape($link)
    {
        $this->prepare((string) $link);

        $this->crawler = new Crawler($this->html);

        $title = (string) $this->title('h1');

        $this->remove((array) $this->removables);

        $body = $this->body('.content');

        $html = $this->html($body);

        return new Article($title, $html);
    }
}
