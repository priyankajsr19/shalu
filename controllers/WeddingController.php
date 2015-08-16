<?php
/*
* 2007-2011 PrestaShop 
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 6594 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

class WeddingControllerCore extends FrontController
{
    
    public function __construct()
    {
        $this->php_self = 'wedding.php';
        parent::__construct();
    }
    public function preProcess() 
    {
        parent::preProcess();
        $page = Tools::getValue("cat");
        self::$smarty->assign("page",$page);

        if( $page === "happybeginnings" ) {
            $main_banner = array("wedding/happy_beginnings_main_banner.jpg","These are going to be your closest memories that you will cherish over the years to come. Go for our collection which had been curated by specialists in the wedding scene and they know exactly what you want. Unlike just another family celebration, create happy beginnings and uncover the best that we have. Combining modern day textiles with ancient techniques, it’s a holy dip that will help create an iridescent imagery.","#");
            self::$smarty->assign("main_banner",$main_banner);
            
            $testimonials = array();
            $testimonial = array("The bridesmaids and sisters’ outfit is beautiful, simple and elegant and the bridesmom’s outfit is beautiful as well.
You been extremely professional, thank you for everything you did for us and for your outstanding customer service.","Vineetha Luke (Mother of Bride)");
            array_push($testimonials, $testimonial);
            $testimonial = array("I just wanted to say the outfits looked beautiful :)","Sheena Luke (Bride)");
            array_push($testimonials, $testimonial);    
            $testimonial = array("Just wanted to say that I received the lehenga choli set yesterday and I absolutely loved it! The work was of extremely high quality and I'm terribly impressed with your team's quick and efficient service and all your kind assistance. I'll definitely be in touch when I next need an outfit. Thanks heaps! :)","Latha Deva (Bride)");
            array_push($testimonials, $testimonial);
            $testimonial = array("<p>Oh my God. The saree is SO GORGEOUS. Everything is fitting perfectly and having the strings on the back of the blouse was perfect too. I totally felt better having those there. Love the little circle latkans you put on them well, they have a bell type of sound: D</p><p>Like if this saree was a guy, I would probably have a crush on him. Haha. My husband was floored and happy that everything turned out so well and everyone was wearing their bridal wear reds/golds but your team totally helped me stand apart from everyone else at the party. The colors were so youthful and refreshing against the traditional deep maroons and greens everyone was wearing.</p><p> <em>Bear hugs and kisses</em> for totally making this happen.</p><p>My aunt asked about the sari and wants to have a sari made so I've sent her your way, but seriously...I felt so happy in the color (by the way the color was perfect....totally how I wanted it). I wore the saree last week....I wore it the Gujarati style, so didn't have any problem with the pleating, however I'm going to a friend's engagment this weekend and will be wearing the sari again, but with the pallu over my shoulder.</p><p>Love you guys for dealing with me and my craziness, cannot say thanks enough!!!!</p>","Navdha Vyas (Bride)");
            array_push($testimonials, $testimonial);    
            self::$smarty->assign("testimonials",$testimonials);
            return;
        }
        //For all other categories
        if( $page === "occasion" ) {
            $main_banner = array("wedding/ocassion_main_banner_2.jpg","An elegance grown in Indian richness, a palette of warm colors juxtaposed with some bright embellishments, we present to you the wardrobe of desire, soaked in classy and timeless looks - The Wedding Closet. From your first wedding inspirations to designer tales until your honeymoon flight, this exclusive Bride and Groom collection is a fusion of tradition and modernity. Weave the theme of integrated passion-meets-fashion statement!");
            
            $other_banners = array();
            $banner = array("wedding/engagement.jpg","She holds out her hand, there is promise in the air as he gently slides the ring on her finger. Lo and behold, they are engaged. The Indian engagement ceremony, an occasion where rings are exchanged between the couple, also known as sagai, mangni, chunni chadana is the first step of a lifelong journey. After a ring ceremony, sweets and gifts are exchanged, a date is set and the union of two families is born",_PS_BASE_URL_."/products/engagementweddingcloset");
            $other_banners["Engagement"] = $banner;

            $banner = array("wedding/sangeet.jpg","Let that Dholak sound go loud, as you prepare to see a day holding hands with your lover, words that will last forever. Let Yellow and Orange hues be your theme before entering the main event when the bells will ring. Amidst the cauldron of wedding day preparation, the fabrics and the colors allow the female associates to sing all night long in merriment.",_PS_BASE_URL_."/products/sangeetweddingcloset");
            $other_banners["Sangeet"] = $banner;

            $banner = array("wedding/mehendi.jpg","The beautiful bride holds her hands out, poised for the earthy Mehendi to be traced lovingly onto them. A tradition that dates back to the Vedic times, the Mehendi ceremony is seen as a means to awaken the brides ‘inner light’. Intricate designs, often concealing the groom's initials are drawn delicately on the bride and groom's hands and feet. A beautiful ceremony, the Mehendi symbolises the coming of age and the start of a new life.",_PS_BASE_URL_."/products/mehendiweddingcloset");
            $other_banners["Mehendi"] = $banner; 
            
            $banner = array("wedding/ceremony.jpg","With the elaboration of Indian fun filled rituals and lifetime commitment of two likeminded souls, the wedding ceremony means a lot even to the families. Fun, frolic and dance heightens the excitement only during this main function. Mingling of cultures and traditions further facilitates these frothy moments in splendid weaves and work. Glow and shine, under the blessings of the Almighty.",_PS_BASE_URL_."/products/ceremonyweddingcloset");
            $other_banners["Ceremony"] = $banner;

            $banner = array("wedding/Pooja.jpg","Marriage is a sacred union of two people and in India, is bathed in the glow of God. Each sacred pooja is an act of worship, symbolising each step of a wedding. From the Sankalp pooja, where the parents pray for the blessings of God on the couple, to the Choora ceremony where the bridal is blessed with beautiful bangles to symbolize a new beginning in her life, to the Ganesh Pooja, where the good will of Ganesha is sought for the wedding, each ritual is steeped in tradition, adding depth and beauty to an Indian wedding.",_PS_BASE_URL_."/products/poojaweddingcloset");
            $other_banners["Pooja"] = $banner;
            
            $banner = array("wedding/reception.jpg","Brush up your special day outfit registry with some rich elements in sweeping highlights of fashion designers. It’s the FINALE, gather, greet and be part of an everlasting time frame. The Bride and Groom now experience the celebrations of a lifetime as they exchange warm and unforgettable hospitality for the blessings of their elder. With thematic options our collection portrays an approach where we consider the comfort of the couple at first in holistic concepts.",_PS_BASE_URL_."/products/receptionweddingcloset");
            $other_banners["Reception"] = $banner;

        } else if( $page === "family") {
            $main_banner = array("wedding/family_main_banner_2.jpg","It’s a wedding and we ought to dress up and dress up well. Style and class is synonymous to this collection, something for everyone in the young couple’s family. Add some drama to the occasion with some international styling, layering and accessorizing your near and dear ones. Let the popular ethnic trend add hues to the event as you take that step ahead with your beloved.");
            
            $other_banners = array();
            $banner = array("wedding/bride.jpg","Draped beautifully in delicate Silk and Net, sparkling stones and exquisite embroidery, a bride sits poised to start a new life. She is beautiful and strong, dazzling and wise. With henna traced on her palms and feet, Kohl lining her expressive eyes and gleaming Gold encircling her neck, she is a queen on her special day.",_PS_BASE_URL_."/products/brideweddingcloset");
            $other_banners["Bride"] = $banner;

            $banner = array("wedding/groom.jpg","You are the man, this special day be the perfect mix of upholding traditions dressed with a refined taste. Yes we talk about a wardrobe for the modern Groom here in masculine classics, musky scents and a kingly charm. Undaunted craftsmanship on the finest of fabrics in these Sherwanis and suits inspired by western classics with utmost cultural closeness. Be it the gold trimmed buttons or the well ironed cuffs, it's for him who knows his choice on the special day.", _PS_BASE_URL_."/products/groomweddingcloset");
            $other_banners["Groom"] = $banner;

            $banner = array("wedding/mom.jpg","Just as the sun blesses this special day, a mother’s blessings are equally important for her children. She honors this day, praying for their happiness and rejoicing in their future. As you stand, tall and proud, wrapped in the purest of silks, watch your child step into a new and wonderful phase of life.",_PS_BASE_URL_."/products/motherweddingcloset");
            $other_banners["Mother"] = $banner; 

            $banner = array("wedding/sister.jpg","This collection entails playfully embroidered ethnic numbers for your blood relations especially your sisters. To make it an easy drape affair, Pavada Davanis and Lehenga Sarees are the ones which will evoke sisterly feelings within you, making the bond stronger between you two. With versatile decorative over light fabrics, these contemporary charmers are work of imagination and pure creativity.",_PS_BASE_URL_."/products/sisterweddingcloset");
            $other_banners["Sister"] = $banner;
            
            $banner = array("wedding/bridesmaid.jpg","Best friends are for life, and they stand by you on all the important days. Like the perfect petals of a flower, they encircle the bride, teasing her, supporting her and giving her strength through the eternal bonds of sisterhood. As the bride walks towards the mandap, these are her soul sisters, each a beauty in her own right, leading the way to a new life.",_PS_BASE_URL_."/products/bridesmaidweddingcloset");
            $other_banners["Bridesmaid"] = $banner;
            
            $banner = array("wedding/brother_2.jpg","Next on our relationship wagon, are the brothers who desire to be the best on their sibling's wedding ceremony. This range guides you through trending ethnic styles, combining the spirit of youthful vigor and charming presence. With those Nehru Suits and Breeches for bottoms, dress in elan.",_PS_BASE_URL_."/products/brotherweddingcloset");
            $other_banners["Brother"] = $banner;
            
            $banner = array("wedding/dad.jpg","You held those hands when they were small, guided their small feet. They looked to you for protection, love and guidance. Now, on the day of your child’s wedding, you are a proud papa watching your child grow and bloom. You are wisdom and dignity personified as you stand by them, dressed in a grand sherwani and pyjama, always by their side…",_PS_BASE_URL_."/products/fatherweddingcloset");
            $other_banners["Dad"] = $banner;
           
            $banner = array("wedding/kids.jpg","The most cheery part of any wedding crowd are the kids; and yes, deciding on their style statement is important. Seeing your nephews and nieces in the best possible outfit, is a common take that you may like to consider in your shopping registry too. In easy-breathe fabrics we present you this nubile soiree of cute Chaniya Cholis and Dhoti Kurta for kids too. Enhancing their comfort will keep you in high spirits keeping their childlike tantrums away.",_PS_BASE_URL_."/products/kidsweddingcloset");
            $other_banners["Kids"] = $banner;

        } else if( $page === "regions" ) {
            $main_banner = array("wedding/regions_main_banner_2.jpg","From the vast, arid regions of Rajasthan to the warm streets of Kolkata, from the lush valleys of Kashmir, to the coasts of Kerala, India is a country so magnificent in its vastness and so varied in its weddings. From each state are beautiful traditions and ceremonies, creating a melting pot of celebration and love. In each state marriage takes on a new meaning and in each region, love is celebrated in a new form...");
            
            $other_banners = array();
            $banner = array("wedding/north.jpg","Think of the dazzle of colours, the glory of music and the festivity of love when it comes to a North Indian wedding. At the center of all this joy, sits a beautiful bride, dressed in ravishing ruby Red Net or beautiful brocade. Rich jewelry encircles her neck, as dazzling as the stones that rain down her lehenga. And amidst all the fun and frenzy, the rituals of Haldi and Mehendi, the sangeet and the kanya-dan, a marriage comes to life.",_PS_BASE_URL_."/products/northweddingcloset");
            $other_banners["North"] = $banner;

            $banner = array("wedding/south.jpg","Like the Haldi on her body, and fragrance of fresh Jasmine flowers in her hair, this section is to the bride with a doe eyed kajal look wearing some heavy Gold jewellery. Here we raise a toast to the South with our exclusive Kanjeevarams and Kasavus blessed with some historic moments, reverberating in the sounds of Nadaswaram. As the bride takes her steps forward, one can see glimpses of  the rich Dravidian heritage woven in Pure Silk threads framed with temple inspired borders .",_PS_BASE_URL_."/products/southweddingcloset");
            $other_banners["South"] = $banner;

            $banner = array("wedding/east.jpg","Beautiful folk music spreads and fills the air as the bride and groom get ready for the wedding, an occasion that is celebrated with great joy over five days in the Eastern states of India. Simple and meaningful rituals are celebrated with great significance as friends and families witness the union of two souls, while all around the reverberations of music and sounds tremble in the air.",_PS_BASE_URL_."/products/eastweddingcloset");
            $other_banners["East"] = $banner; 

            $banner = array("wedding/west.jpg","A colorful band baja proceeds and dancing footsteps welcome the barat. This is the thrill and fun of an affair from Western India. Clad in a Ghagra Choli hiding her emotions under the dupatta, she is the one who is inspired by Bandhej and Kutch work from Gujarat and Rajasthan. Like the lit up sky, bridal emotions reflect with the beaded and mirror embellishments",_PS_BASE_URL_."/products/westweddingcloset");
            $other_banners["West"] = $banner;
            
        } else {
            $main_banner = array("wedding/wedding_main_banner.jpg","An elegance grown in Indian richness, a palette of warm colors juxtaposed with some bright embellishments, we present to you the wardrobe of desire, soaked in classy and timeless looks - The Wedding Closet. From your first wedding inspirations to designer tales until your honeymoon flight, this exclusive Bride and Groom collection is a fusion of tradition and modernity. Weave the theme of integrated passion-meets-fashion statement!");
            
            $other_banners = array();
            $banner = array("wedding/ocassions.jpg","Love, tradition, fun and frolic - threaded through the quintessential Indian wedding are traditions and occasions that are simply sacred to this country. Whether it is Golden turmeric being smoothed onto the bride's skin, shaking a leg to a song or welcoming your nearest and dearest, the Indian wedding is a spectacular spectacle that transcends a simple act of love by celebrating it with all the dazzle and dignity. ",_PS_BASE_URL_."/weddingcloset/occasion");
            $other_banners["Occasion"] = $banner;

            $banner = array("wedding/family.jpg","It’s a wedding and we ought to dress up and dress up well. Style and class is synonymous to this collection, something for everyone in the young couple’s family. Add some drama to the occasion with some international styling, layering and accessorizing your near and dear ones. Let the popular ethnic trend add hues to the event as you take that step ahead with your beloved.",_PS_BASE_URL_."/weddingcloset/family");
            $other_banners["Family"] = $banner;

            $banner = array("wedding/regions.jpg","From the vast, arid regions of Rajasthan to the warm streets of Kolkata, from the lush valleys of Kashmir, to the coasts of Kerala, India is a country so magnificent in its vastness and so varied in its weddings. From each state are beautiful traditions and ceremonies, creating a melting pot of celebration and love. In each state marriage takes on a new meaning and in each region, love is celebrated in a new form...",_PS_BASE_URL_."/weddingcloset/regions");
            $other_banners["Regions"] = $banner; 

            $banner = array("wedding/happy_beginnings.jpg","These are going to be your closest memories that you will cherish over the years to come. Want a customized outfit, one of a kind for the most special moment in your life? Come to IndusDiva’s Design Studio and let’s make your dream come true. Unlike just another family celebration, create happy beginnings and uncover the best that we have. Combining modern day textiles with ancient techniques and the best designing skills put together, it’s a holy dip that will help create an iridescent imagery.",_PS_BASE_URL_."/weddingcloset/happybeginnings");
            $other_banners["Happy Beginnings"] = $banner;
        }
        self::$smarty->assign("main_banner",$main_banner);
        self::$smarty->assign("other_banners", $other_banners);
    }
    public function setMedia()
    {
        parent::setMedia();
        //Tools::addCSS(_THEME_CSS_DIR_.'product_list.css');
    }
    
    public function displayContent()
    {
        parent::displayContent();
        self::$smarty->display(_PS_THEME_DIR_.'wedding.tpl');
    }
}

