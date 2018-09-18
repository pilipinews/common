<?php

namespace Pilipinews\Common;

use Pilipinews\Common\Fixture\CnnCrawler;
use Pilipinews\Common\Fixture\CnnScraper;

/**
 * Collector Test
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CollectorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Collector::collect.
     *
     * @return void
     */
    public function testCollectMethod()
    {
        $expected = array(new Article('AFP allays fears spurred by military tank sightings along EDSA', "METRO MANILA (CNN PHILIPPINES, SEPTEMBER 11) - The Armed Forces of the Philippines (AFP) allayed the public's fears of stronger military presence in Metro Manila.\n\n\"We wish to categorically state that there were no such sizeable movements of military aircraft or armoured vehicles,\" AFP Spokesman Col. Edgard Arevalo said in a statement.\n\nThis after a video of a military tank plying EDSA surfaced on social media.\n\nTWEET: so i spotted 2 army tanks along edsa earlier going to school. Nation Adress??? Jk. pic.twitter.com/svQTBZIWak- josh (@johnjoshcarillo) September 10, 2018\n\nArevalo said if these were true, they are considered \"routine movements that are properly coordinated.\"\n\n\"These transportations may happen any time of the day or night especially in localities where there are military camps. Some are even announced to the public in so far as they will not compromise operational security,\" he said.\n\nThe AFP urged the public to stay calm as there is no cause for alarm, and called for a stop to misinformation.\n\nTalks of military tank sightings came amid President Rodrigo Duterte's plan that he will speak to the nation on Tuesday afternoon. Presidential Spokesperson Harry Roque on Monday said Duterte \"wants to speak to the nation,\" without giving any possible topics, prompting speculations on what the President would talk about."));

        $crawler = new CnnCrawler;

        $scraper = new CnnScraper;

        $collector = new Collector($crawler, $scraper);

        $callback = function ($article, $link) {
            return $article;
        };

        $result = $collector->collect($callback);

        $this->assertEquals($expected, $result);
    }
}
