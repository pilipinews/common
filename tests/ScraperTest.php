<?php

namespace Pilipinews\Common;

use Pilipinews\Common\Fixture\CnnScraper;
use Pilipinews\Common\Fixture\SunstarScraper;

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

        $result = $article->body();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests Scraper::remove.
     *
     * @return void
     */
    public function testRemoveMethod()
    {
        $link = 'https://www.sunstar.com.ph/article/1763595';

        $expected = "MANILA -- The largest group of lawyers in the Philippines asked the courts Monday, September 10, to resist \"creeping incursions\" on its independence and warned of judicial \"chaos\" after President Rodrigo Duterte voided an amnesty granted to Senator Antonio Trillanes IV and ordered his arrest.\n\nThe Integrated Bar of the Philippines expressed alarm on the \"overt audacity to publicly arrest and incarcerate\" Trillanes for offenses that have been abolished by a 2011 amnesty approved by Duterte's predecessor and Congress and which led to the dismissal of criminal proceedings against the senator.\n\nDuterte's fiercest critic in Congress, Trillanes has been marooned in the Senate for nearly a week to avoid what he regarded as an illegal arrest after the President signed a proclamation that voided his amnesty as a former navy officer who joined past mutinies. Duterte also asked the Department of Justice and the military to revive criminal proceedings against him, moves that Trillanes and some legal experts say violate the Constitution.\n\nDuterte has been highly sensitive to criticism, especially over his anti-drug crackdown that has left thousands of mostly poor drug suspects dead since he took office in mid-2016. Trillanes has long been in the crosshairs of the President, whom he has also accused of large-scale corruption and involvement in illegal drugs, allegations the volatile leader denies.\n\nIn his proclamation, Duterte declared Trillanes's amnesty void because the senator allegedly failed to file a formal amnesty proclamation and acknowledge guilt for involvement in failed coup attempts years ago. The defiant senator has shown news reports and defense department documents to deny Duterte's claims and asked the Supreme Court to declare Duterte's moves illegal.\n\nAmid those legal questions, the Department of Justice has asked two courts that previously dismissed rebellion and coup charges against Trillanes after his amnesty to issue warrants for the senator's arrest and resume criminal proceedings against him. The department and government lawyers argued that the voiding of the amnesty, which served as the basis of the dismissal of the senator's cases, has revived those cases.\n\nThe lawyers' group, however, argued that the legal move against Trillanes \"runs roughshod over the constitutional guarantee against double jeopardy\" or holding a person to answer twice for the same offense. It \"decries the potential mischief\" where the judiciary is subjected to an \"anomalous situation,\" where one court would uphold the amnesty and another could rule to void it.\n\n\"The chaos that may result\" from the government moves against Trillanes \"undermines our systems that make the orderly administration of justice possible,\" the group said in a statement signed by its president, Abdiel Fajardo.\n\nPresidential spokesman Harry Roque asked the lawyers' group to \"stop too much talk\" and to bring their issues to court and not the media.\n\nAlthough Duterte could order the military to arrest Trillanes for him to face a military court of inquiry into his past coup involvement, the President has decided to wait for civilian courts to rule whether the senator could be arrested to face trial. Trillanes, however, has refused to believe Duterte and refused to leave the Senate, where the media has covered his daily news conferences. (AP)";

        $scraper = new SunstarScraper;

        $article = $scraper->scrape($link);

        $result = $article->body();

        $this->assertEquals($expected, $result);
    }
}
