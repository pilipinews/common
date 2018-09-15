<?php

namespace Pilipinews\Website\Bulletin;

use Pilipinews\Common\Article;
use Pilipinews\Common\Interfaces\ScraperInterface;
use Pilipinews\Common\Scraper as AbstractScraper;

/**
 * Manila Bulletin Scraper
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Scraper extends AbstractScraper implements ScraperInterface
{
    /**
     * @var string[]
     */
    protected $removables = array(
        '.uk-article-title',
        '.share-container',
        '.uk-grid.uk-grid-large.uk-margin-bottom',
        '.uk-visible-small.uk-margin-top.uk-margin-bottom',
        '#related_post',
        '#disqus_thread',
        'script',
    );

    /**
     * Returns the contents of an article.
     *
     * @return \Pilipinews\Common\Article
     */
    public function scrape()
    {
        $title = $this->title('.uk-article-title');

        $this->remove($this->removables);

        $html = $this->html($this->body('article'));

        return new Article($title, (string) $html);
    }
}
