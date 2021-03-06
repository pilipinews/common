<?php

namespace Pilipinews\Common;

/**
 * Article Test
 *
 * @package Pilipinews
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ArticleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Pilipinews\Common\Article
     */
    protected $article;

    /**
     * @var string
     */
    protected $body = '';

    /**
     * @var string
     */
    protected $link = '';

    /**
     * @var string
     */
    protected $title = '';

    /**
     * Initializes the article instance.
     */
    public function setUp()
    {
        $this->body = 'Lorem ipsum dolor sit amet ñunez';

        $this->title = 'Hello World Juañito';

        $this->link = 'https://www.sunstar.com.ph/article/1763669';

        $this->article = new Article($this->title, $this->body, $this->link);
    }

    /**
     * Tests Article::body.
     *
     * @return void
     */
    public function testBodyMethod()
    {
        $result = $this->article->body();

        $expected = $this->body;

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests Article::link.
     *
     * @return void
     */
    public function testLinkMethod()
    {
        $result = $this->article->link();

        $expected = $this->link;

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests Article::title.
     *
     * @return void
     */
    public function testTitleMethod()
    {
        $result = $this->article->title();

        $expected = $this->title;

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests Article::post.
     *
     * @return void
     */
    public function testPostMethod()
    {
        $result = $this->article->post();

        $expected = mb_strtoupper($this->title, 'UTF-8');

        $expected .= "\n\n" . $this->body;

        $this->assertEquals($expected, $result);
    }
}
