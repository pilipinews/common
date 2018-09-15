<?php

namespace Pilipinews\Common;

/**
 * Converter Test
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ConverterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $expected = "PHOTO: https://pilipinews.github.io/img/logo.jpg\n\nHELLO WORLD!\n\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam odit beatae rem, sed cupiditate laboriosam officia adipisci soluta ASSUMENDA vitae magni odio ea ducimus voluptates aspernatur, nostrum nulla excepturi voluptatem.\n\n> This is a blockquote\n\n* ABS-CBN News\n* CNN Philippines\n* GMA News\n* Inquirer News\n* Philippine National Agency\n* Rappler News\n* Sunstar News\n\n1. Collect data from news outlets\n2. Post it as a post in Facebook\n\nPilipinews (https://pilipinews.github.io/)\n\nhttps://zapheus.github.io/";

    /**
     * Tests Converter::convert.
     *
     * @return void
     */
    public function testConvertMethod()
    {
        $file = __DIR__ . '/Fixture/HelloWorld.html';

        $converter = new Converter;

        $contents = file_get_contents((string) $file);

        $result = $converter->convert($contents);

        file_put_contents('test.html', $result);

        $this->assertEquals($this->expected, $result);
    }
}
