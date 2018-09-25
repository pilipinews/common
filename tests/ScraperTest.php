<?php

namespace Pilipinews\Common;

use Pilipinews\Common\Fixture\CnnScraper;
use Pilipinews\Common\Fixture\AbsScraper;

/**
 * Scraper Test
 *
 * @package Pilipinews
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ScraperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Scraper::tweet.
     *
     * @return void
     */
    public function testTweetMethod()
    {
        $link = 'http://cnnphilippines.com/news/2018/09/11/AFP-tank-sightings-EDSA.html';

        $expected = "METRO MANILA (CNN PHILIPPINES, SEPTEMBER 11) - The Armed Forces of the Philippines (AFP) allayed the public's fears of stronger military presence in Metro Manila.\n\n\"We wish to categorically state that there were no such sizeable movements of military aircraft or armoured vehicles,\" AFP Spokesman Col. Edgard Arevalo said in a statement.\n\nThis after a video of a military tank plying EDSA surfaced on social media.\n\nTWEET: so i spotted 2 army tanks along edsa earlier going to school. Nation Adress??? Jk. pic.twitter.com/svQTBZIWak- josh (@johnjoshcarillo) September 10, 2018\n\nArevalo said if these were true, they are considered \"routine movements that are properly coordinated.\"\n\n\"These transportations may happen any time of the day or night especially in localities where there are military camps. Some are even announced to the public in so far as they will not compromise operational security,\" he said.\n\nThe AFP urged the public to stay calm as there is no cause for alarm, and called for a stop to misinformation.\n\nTalks of military tank sightings came amid President Rodrigo Duterte's plan that he will speak to the nation on Tuesday afternoon. Presidential Spokesperson Harry Roque on Monday said Duterte \"wants to speak to the nation,\" without giving any possible topics, prompting speculations on what the President would talk about.";

        $scraper = new CnnScraper;

        $article = $scraper->scrape($link);

        $result = (string) $article->body();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests Scraper::remove.
     *
     * @return void
     */
    public function testRemoveMethod()
    {
        $link = 'http://cnnphilippines.com/news/2018/09/11/AFP-tank-sightings-EDSA.html';

        $expected = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat optio, incidunt inventore enim ullam earum, libero commodi et soluta facilis veniam quae ut nihil officia accusantium totam, ab possimus quos.\n\nMagnam ratione reiciendis, hic amet consectetur voluptates repellat mollitia, odio quas ipsum excepturi quasi rem recusandae delectus suscipit molestiae quaerat porro, eos.";

        $scraper = new AbsScraper;

        $article = $scraper->scrape($link);

        $result = (string) $article->body();

        $this->assertEquals($expected, $result);
    }
}
