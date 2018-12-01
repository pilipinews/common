<?php

namespace Pilipinews\Common;

/**
 * Client
 *
 * @package Pilipinews
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Client
{
    const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36';

    /**
     * @var resource
     */
    protected $curl;

    /**
     * Initializes the cURL session.
     */
    public function __construct()
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_ENCODING, '');

        curl_setopt($curl, CURLOPT_USERAGENT, self::USER_AGENT);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $this->curl = $curl;
    }

    /**
     * Performs the cURL session.
     *
     * @param  boolean $close
     * @return mixed
     */
    public function execute($close = true)
    {
        $result = curl_exec($this->curl);

        $close && curl_close($this->curl);

        return $result;
    }

    /**
     * Sets an option to the cURL session.
     *
     * @param  integer $key
     * @param  mixed   $value
     * @return self
     */
    public function set($key, $value)
    {
        curl_setopt($this->curl, $key, $value);

        return $this;
    }

    /**
     * Sets the URL to be used in the cURL session.
     *
     * @param  string $link
     * @return self
     */
    public function url($link)
    {
        return $this->set(CURLOPT_URL, $link);
    }

    /**
     * Performs a new cURL session with an URL.
     *
     * @param  string $url
     * @return string
     */
    public static function request($url)
    {
        $curl = new static;

        $curl->url((string) $url);

        return $curl->execute();
    }
}
