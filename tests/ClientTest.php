<?php

namespace Pilipinews\Common;

/**
 * Client Test
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ClientTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Client::request.
     *
     * @return void
     */
    public function testRequestMethod()
    {
        $html = Client::request('https://news.abs-cbn.com/');

        $this->assertTrue(strpos($html, 'ABS-CBN') !== false);
    }
}
