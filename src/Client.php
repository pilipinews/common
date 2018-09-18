<?php

namespace Pilipinews\Common;

/**
 * Client
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Client
{
    const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36';

    /**
     * Performs the HTTP request based on the given URL.
     *
     * @param  string $link
     * @return string
     */
    public static function request($link)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, (string) $link);

        curl_setopt($curl, CURLOPT_ENCODING, '');

        curl_setopt($curl, CURLOPT_USERAGENT, self::USER_AGENT);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        ($response = curl_exec($curl)) && curl_close($curl);

        return (string) $response;
    }
}
