<?php

namespace Pilipinews\Common\Interfaces;

/**
 * Website Interface
 *
 * @package Pilipinews
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface WebsiteInterface
{
    /**
     * Returns the ID from a specified service.
     *
     * @param  string $service
     * @return string
     */
    public function id($service);

    /**
     * Returns the name of the website.
     *
     * @return string
     */
    public function name();
}
