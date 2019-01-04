<?php

namespace Pilipinews\Common;

use Pilipinews\Common\Fixture\AbsScraper;
use Pilipinews\Common\Fixture\CnnScraper;
use Pilipinews\Common\Fixture\RapScraper;

/**
 * Scraper Test
 *
 * @package Pilipinews
 * @author  Rougin Gutib <rougingutib@gmail.com>
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
        $link = 'https://news.abs-cbn.com/news/09/18/17/law-student-nasawi-sa-atake-sa-puso-pamilya-kumbinsidong-dahil-ito-sa-hazing';

        $expected = "LAW STUDENT, NASAWI SA ATAKE SA PUSO; PAMILYA, KUMBINSIDONG DAHIL ITO SA HAZING\n\nVIDEO: https://www.youtube.com/embed/fmjy1h8yrGo?enablejsapi=1\n\n- MGA OPISYAL AT MIYEMBRO NG AEGIS JURIS, SINUSPENDE KASUNOD NG PAGKAMATAY NG LAW STUDENT\n- OPISYAL NG BARANGAY, DUDA KUNG TALAGANG NATAGPUAN SA BANGKETA ANG BANGKAY\n- NAGPAKILALANG NAKAKITA SA BANGKAY, AYAW HUMARAP SA NEWS TEAM\n\nHindi pa rin matanggap ng mag-asawang Horacio Castillo, Jr. at Carmina Castillo na bangkay na nilang masisilayan ang kanilang panganay na anak na si Horacio Tomas Castillo III, isang law student sa University of Santo Tomas (UST).\n\nNatagpuan umano ang 22 anyos na si Horacio, alyas \"Atio\" na nakabalot ng puting kumot sa isang bangketa sa Balut, Tondo sa Maynila.\n\nHinihinalang biktima ng hazing si Castillo.\n\nAnila, nitong Sabado, Setyembre 16, nagpaalam ang anak na dadalo sa welcome ceremonies ng Aegis Juris, na umano'y opisyal na fraternity sa UST.\n\nKinabahan na ang pamilya nang hindi na nagparamdam kinabukasan ang anak.\n\nPasado ala-1 ng madaling araw nitong Lunes, Setyembre 18, nakatanggap ang mag-asawa ng anonymous text message na nagsasabing nasa Chinese General Hospital na ang kanilang anak at wala nang buhay.\n\nHustisya ngayon ang hiling ng pamilya Castillo.\n\nBUMUHOS ANG PAKIKIRAMAY\n\nAyon sa mga kaanak at malalapit na kaibigan, masayahin, mahilig magpatawa, palakaibigan at magalang si Castillo.\n\nMasipag din sa pag-aaral at mga gawain sa eskuwelahan.\n\nNaging miyembro ng student council si Castillo nang siya'y kumukuha pa ng kaniyang kursong undergraduate na political science sa UST.\n\nAyon sa ama, pangarap ni Castillo na mapabilang sa isa sa mga abogado sa Korte Suprema.\n\nPOST: https://www.facebook.com/photo.php?fbid=10209380480697716&set=a.1362721316815.2046515.1495053209&type=3&theater\n\nMahilig din si Castillo maglabas ng saloobin hinggil sa mga isyung panlipunan, gaya ng isang Facebook post niyang naghahayag ng pagtutol sa mga extrajudicial killings kaugnay ng giyera kontra droga.\n\nBumuhos sa Facebook account ni Castillo ang pakikiramay.\n\nMay Facebook account din na ginawa para sa paghingi ng hustisya sa kaniyang kamatayan. Dito inilabas ng mga kaibigan ni Castillo ang sama ng loob, lalo na sa mga umano'y nasa likod ng kaniyang pagkamatay.\n\nHiling din ng mga kaibigan ni Castillo ang agarang pagsuko ng mga salarin.\n\nVIDEO: https://www.youtube.com/embed/jgfXj4S1huQ?enablejsapi=1\n\nSANHI NG PAGKAMATAY\n\nBatay sa paunang ulat ng Manila Police District (MPD) Homicide Division, pasado alas-7 ng umaga ng Linggo nakita ng nagpakilalang si John Paul Sarte Solano ang katawan ni Castillo sa bangketa.\n\nSiya rin ang nagdala sa biktima sa Chinese General Hopsital pero idineklarang dead on arrival si Castillo.\n\nTila duda naman sa kuwento ni Solano ang kagawad na si Daniel Sayson.\n\nAni Sayson, tiyak na dudumugin ng mga residente ang bangketa kung talagang may patay ngang nakita roon. Pero hindi naman daw ito nangyari.\n\nDagdag pa ni Sayson, malabong sa Chinese General Hospital itakbo ang biktima dahil mas malapit ang Tondo General Hospital sa kanilang barangay.\n\nSinubukan ng ABS-CBN na puntahan si Solano sa San Lazaro Hospital pero tumanggi siyang humarap sa camera.\n\nAyon sa opisyal na ulat ng MPD, cardiac arrest o atake sa puso ang ikinamatay ng biktima. Mayroon din siyang hematoma o namuong dugo sa dalawang braso.\n\nKumbinsido ang mga magulang ni Castillo na hazing ang ikinamatay ng anak dahil sa matinding pamamaga ng braso, mga pasa, at paso ng kandila sa katawan.\n\nVIDEO: https://www.youtube.com/embed/OtOhy011HCs?enablejsapi=1\n\nUST Faculty of Civil Law: All the officers and members of the Aegis JurisFraternity have been placed under preventive suspension. pic.twitter.com/xfrMT1E4Ug (https://t.co/xfrMT1E4Ug)\n\n- ABS-CBN News (@ABSCBNNews) September 18, 2017 (https://twitter.com/ABSCBNNews/status/909659210866032640)\n\nKinondena ng UST Faculty of Civil Law ang insidente.\n\nSa isang pahayag, isinaad nilang mananagot ang mga dawit sa krimen.\n\nBukod sa pagsuspende sa mga opisyal at miyembro ng Aegis Juris, pinagbawalan na rin silang pumasok sa campus at dumalo sa mga klase habang gumugulong ang imbestigasyon.\n\nSa pahayag ng Aegis Juris Fraternity, sinabi naman nilang handa silang makipagtulungan sa pagsisiyasat.\n\n- ULAT NINA LYZA AQUINO, ZYANN AMBROSIO AT KORI QUINTOS, ABS-CBN NEWS";

        $scraper = new AbsScraper;

        $article = $scraper->scrape($link);

        $result = (string) $article->post();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests Scraper::html.
     *
     * @return void
     */
    public function testHtmlMethod()
    {
        $link = 'https://www.rappler.com/nation/220222-duterte-signs-joint-resolution-extension-2018-budget-validity';

        $expected = "DUTERTE SIGNS RESOLUTION EXTENDING LIFE OF 2018 BUDGET FOR ANOTHER YEAR\n\nPHOTO: https://assets.rappler.com/04780EAE781C459D9466A37B953A6D58/img/41334DCCAAD4410B9E00C353B4097C26/duterte-marco-polo-davao-journey-20th-dec82018-007.jpg - 2018 BUDGET EXTENSION. President Rodrigo Duterte delivers his speech during the Marco Polo Davao Journey @ 20 at the Marco Polo Davao on December 7, 2018. Photo by Robinson Niāal Jr/Presidential Photo\n\nMANILA, Philippines - President Rodrigo Duterte has signed a joint resolution extending for one year the availability of funds allocated for maintenance and other operating expenses (MOOE) and for capital outlay under the 2018 national budget.\n\nHouse Majority Leader Rolando Andaya Jr said in a House hearing at Naga City on Thursday, January 3, that the President already signed Joint Resolution (JR) 3. Executive Secretary Salvador Medialdea confirmed this to Rappler, saying Duterte signed the document on December 28, 2018.\n\nJR 3 extends the validity of the MOEE and capital outlay funds under the P3.767-trillion 2018 budget (https://www.rappler.com/nation/191749-philippines-duterte-signs-2018-national-budget-law)to December 31, 2019. Without the extension, unused funds will go back to the National Treasury.\n\n\"Resolved by the House of Representatives, the Senate of the Philippines voting separately, to extend the validity and period of availability of the Fiscal Year 2018 appropriations for maintenance and other operating expenses and capital outlays to December 31, 2019, amending for the purpose Section 61 of the General Provisions of Republic Act No. 10964, otherwise known as the General Appropriations Act of Fiscal Year 2018,\" said JR 3.\n\nThe joint resolution ensures that funds for ongoing rehabilitation efforts - like the allocations for rebuilding war-torn Marawi City (http://www.apple.com) - can still be used legally by the government beyond December 31, 2018.\n\nIn the resolution, Duterte cited the need for funds to rehabilitate regions still suffering from the aftermath of several calamities like Typhoons Rosita and Ompong, flash floods, and flooding incidents caused by the southwest monsoon.\n\nThe House approved (https://www.rappler.com/nation/217573-house-3rd-reading-joint-resolution-extension-availability-2018-national-budget) the joint resolution on November 27, while the Senate gave its nod to the bill on December 3. - WITH REPORTS FROM PIA RANADA/RAPPLER.COM";

        $scraper = new RapScraper;

        $article = $scraper->scrape($link);

        $result = (string) $article->post();

        $this->assertEquals($expected, $result);
    }
}
