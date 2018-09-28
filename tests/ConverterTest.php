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
     * Tests Converter::convert.
     *
     * @return void
     */
    public function testConvertMethod()
    {
        $expected = "PHOTO: https://pilipinews.github.io/img/logo.jpg\n\nHELLO WORLD!\n\nLorem ipsum dolor sit amet, consectetur (http://www.google.com) adipisicing elit. Ñumquam odit beatae rem, sed cupiditate laboriosam officia adipisci soluta ASSUMENDA vitae magñi odio ea ducimus voluptates aspernatur, nostrum nulla excepturi voluptatem.\n\n1. Illo, suscipit, iste. Magni molestiae incidunt amet fugiat, harum voluptatum.\n\n\>Molestias explicabo quos esse dolorem provident ipsam? Quo, \<!--quisquam-->!\n\n> This is a blockquote\n\n* ABS-CBN News\n* CNN Philippines\n* GMA News\n* Inquirer News\n* Philippine National Agency\n* Rappler News\n* Sunstar News\n\n1. Collect data from news outlets\n2. Post it as a post in Facebook\n\nPilipinews (https://pilipinews.github.io/)\n\nhttps://zapheus.github.io/\n\nName - Site\nZapheus - https://zapheus.github.io/\nZapheus - https://zapheus.github.io/";

        $file = __DIR__ . '/Fixture/HelloWorld.html';

        $converter = new Converter;

        $contents = file_get_contents((string) $file);

        $result = $converter->convert($contents);

        $this->assertEquals($expected, $result);
    }
}
