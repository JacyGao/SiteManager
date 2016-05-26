<?
$CONFIG_VERSION = 2.0;

$GEO_OPTIMIZER = "http://aff.ringtonepartner.com/geo/preset/4385/2/";

$EXIT_TRAFFIC = "http://aff.ringtonepartner.com/geo/preset/4385/7/";

$SECRET = date("Y-m-d")."~~Huseinovic";

list($HTTP_HOST, $PLATFORM, $DOMAIN_COUNTRY, $DOMAIN_KEYWORD, $DOMAIN_NAME, $DOMAIN_EXT) = $DOMAIN;
#echo "NEW CONFIGURATION";

$SUBDOMAIN = $DOMAIN_KEYWORD;

$KW_DIGIT = (int)preg_replace("/[^0-9]/","",$DOMAIN_KEYWORD);
$ALT_KEYWORD = $DOMAIN_KEYWORD;
$HEADER_NOTE = $MIDDLE_NOTE = "";

$SUBSCR_MSG_PER_WEEK = $BUY_CREDITS_REST = $FOR_HELP_TEXT = $SHORTCODE = $PRICE_PREFIX = $SUBSCR_COST = NULL;
$COST = array('Covertones'=>0,'Polyphonics'=>0,'Sound Effects'=>0,'Wallpapers'=>0,'Games'=>0);

switch($DOMAIN_COUNTRY)
{

    case "SA":
        $COUNTRY = SOUTH_AFRICA;
        $SUBSCR_COST = 5;
        $SUBSCR_MSG_PER_WEEK = 7;
        $DOMAIN_KEYWORD = "VID";
        $SHORTCODE = 31359;
        $CURRENCY = "ZAR";
        $PRICE_PREFIX = "R";
        $MOBILE_PREFIX = "0";
        $COUNTRY_NAME = "South Africa";
        $SUPPORT_EMAIL = "sa@helpsms.net";
        $HELPLINE_PHONE = "0110621402";
        $FOR_HELP_TEXT = "For HELP please call <a href=\"tel:{$HELPLINE_PHONE}\">{$HELPLINE_PHONE}</a> or email <a href=\"mailto:{$SUPPORT_EMAIL}\">{$SUPPORT_EMAIL}</a> - sms STOP to {$SHORTCODE} to end at any time. ";

        $COSTS = "The {$SITE_TITLE} subscription service costs {$PRICE_PREFIX}{$SUBSCR_COST} ". ($SUBSCR_MSG_PER_WEEK<7? "{$SUBSCR_MSG_PER_WEEK}x/week":"per day");

        $PSS = array("mobivate","main99");

        $COST['Wallpapers'] = $COST['Animations'] = 50;
        $COST['Games'] = 450;
        $COST['Videos'] = $COST['Covertones'] = $COST['Truetones'] = $COST['Polyphonics'] = 100;
        $COST['Cover Full Tracks'] = 200;

        $KEYWORD = strtolower($PLATFORM.$DOMAIN_KEYWORD);
        $ON_ENTRY = "NUMBER_DETECTION";
        $HOME_TITLE = "Scroll down &amp; CLICK THE BUTTON RIGHT NOW for COOL mobile stuff!!";
        $HOME_INTRO = "Bringing u great FUN and great value";

        switch( substr($DOMAIN_KEYWORD, 0, 3) )
        {
            case "GEN":
                $CONTENTTYPES = array('Games','Covertones','Polyphonics','Sound Effects','Videos','Animations','Wallpapers');
                $CONTENT_ORDER = $CONTENTTYPES;
                #$OTHER_SITES = array("vid{$KW_DIGIT}","tone{$KW_DIGIT}","wall{$KW_DIGIT}");

                $HOME_TITLE = "Scroll down &amp; CLICK THE BUTTON RIGHT NOW for great mobile content!!";
                $HOME_INTRO = "GET THE LATEST MOBILE CONTENT";
                break;
            case "GAM":
                $CONTENTTYPES = array('Games');
                $CONTENT_ORDER = array();
                $OTHER_SITES = array("vid{$KW_DIGIT}","tone{$KW_DIGIT}","wall{$KW_DIGIT}");

                $HOME_TITLE = "Scroll down &amp; CLICK THE BUTTON RIGHT NOW for great mobile GAMES!!";
                $HOME_INTRO = "GET THE LATEST GAMES";
                break;
            case "TON":
                $CONTENTTYPES  = array('Covertones','Polyphonics','Sound Effects');
                $CONTENT_ORDER = $CONTENTTYPES;
                $OTHER_SITES = array("vid{$KW_DIGIT}","game{$KW_DIGIT}","wall{$KW_DIGIT}");

                $ITEMS_PER_ROW = 1;
                $ITEMS_PER_PAGE = 20;
                $HOME_TITLE = "Scroll down &amp; CLICK THE BUTTON RIGHT NOW for top chart TONES!!";
                $HOME_INTRO = "GET THE LATEST TONES";
                break;
            case "VID":
                $CONTENTTYPES = $CONTENT_ORDER = array('Videos'/*,'Animations'*/);
                $OTHER_SITES = array("tone{$KW_DIGIT}","game{$KW_DIGIT}","wall{$KW_DIGIT}");

                $HOME_TITLE = "Scroll down &amp; Scroll down & CLICK THE BUTTON RIGHT NOW for crazy & fun VIDEOS!!";
                $HOME_INTRO = "GET THE LATEST VIDEOS";
                break;
            case "WAL":
                $CONTENTTYPES = array('Wallpapers');
                $CONTENT_ORDER = array();
                $OTHER_SITES = array("vid{$KW_DIGIT}","tone{$KW_DIGIT}","game{$KW_DIGIT}");

                $HOME_TITLE = "Scroll down &amp; Scroll down & CLICK THE BUTTON RIGHT NOW for great mobile WALLPAPERS!!";
                $HOME_INTRO = "GET THE LATEST WALLPAPERS";
                break;
        }
        break;

        break;

    case "GH":

        $COUNTRY = GHANA;
        $SUBSCR_COST = 30;
        $SUBSCR_MSG_PER_WEEK = 4;

        $ON_ENTRY = "SUBSCRIBE"; #"INSTANT_JOIN";
        $IS_MO = (substr($DOMAIN_KEYWORD, -2) == "MO");

        $IS_EM = (substr($DOMAIN_KEYWORD, -2) == "EM");
        $IS_EM = true;
        $HOME_TITLE = "Download Great Mobile Videos and Pics.<br />We have HUNDREDS of content items for you to choose from.";

        if(isset($_GET['KEYWORD']) ){
            $KEYWORD=strtoupper($_GET['KEYWORD']);
        }
        else if(isset($_SESSION['keyword'])){
            $KEYWORD=strtoupper($_SESSION['keyword']);
        }
        else {$KEYWORD="HOT";}

        $_SESSION['keyword'] = $KEYWORD;
        #$KEYWORD = $OrderCode = strtoupper($KEYWORD . $KW_DIGIT);
        $SHORTCODE = "1906";
        $CURRENCY = "";
        $PRICE_PREFIX = "Cedi ";
        $MOBILE_PREFIX = "02";
        $COUNTRY_NAME = "Ghana";
        $HELPLINE_PHONE = "";
        $SUPPORT_EMAIL = "support@helpsms.net";
        $FOR_HELP_TEXT = "For HELP please email {$SUPPORT_EMAIL}";
        $NO_DOI = true;

        $COSTS = "The {$SITE_TITLE} gives you {$SUBSCR_CREDITS_ON_SUB} credits, subscription service costs just {$PRICE_PREFIX}{$SUBSCR_COST} to join and then {$PRICE_PREFIX}{$SUBSCR_COST} ". ($SUBSCR_MSG_PER_WEEK<7? "{$SUBSCR_MSG_PER_WEEK}x/week":"per day");

        $PSS = array("mgga","mgga");

        $NETWORK_OPTIONS = array('mtngh'=>'MTN');

        switch($KW_DIGIT)
        {
            case 1: $ALT_KEYWORD = "GIRLS"; break;
            case 2: $ALT_KEYWORD = "VIDEO"; break;
            case 3: $ALT_KEYWORD = "CHICK"; break;
            case 4: $ALT_KEYWORD = "COOL"; break;
            case 5: $ALT_KEYWORD = "NOW"; break;
            case 6: $ALT_KEYWORD = "WANT"; break;

        }

        #$COST['Wallpapers'] = $COST['Animations'] = 50;
        #$COST['Games'] = 200;
        #$COST['Videos'] = $COST['Covertones'] = $COST['Truetones'] = $COST['Polyphonics'] = 100;
        #$COST['Cover Full Tracks'] = 200;
        $COST['Wallpapers'] = 50;
        $COST['Videos'] = 100;


        switch( substr($DOMAIN_KEYWORD, 0, 3) )
        {
            case "GEN":
                $CONTENTTYPES = array('Videos');
                $CONTENT_ORDER = $CONTENTTYPES;
                #$OTHER_SITES = array("vid{$KW_DIGIT}","tone{$KW_DIGIT}","wall{$KW_DIGIT}");

                #$HOME_TITLE = "Scroll down &amp; CLICK THE BUTTON RIGHT NOW for great mobile content!!";
                $HOME_INTRO = "GET THE HOTTEST VIDEOS IN KENYA";
                break;


        }


        if($IS_EM)
        {
            $ON_ENTRY = "ENTER_MOBILE";
            $HEADER_NOTE = "";
            $FOOTER_NOTE = "By clicking the button above you are confirming that you want to join the service. SMS stop to {$SHORTCODE} to end or call 0714869943 (Safaricom) 0736510786 (Zain). Cost Ksh{$SUBSCR_COST} to join and Ksh{$SUBSCR_COST} per message; 1 message per day.";
        }

        if($IS_MO)
        {

            #<a href=\"sms:{$SHORTCODE}?BODY={$ALT_KEYWORD} - THIS IS IT! Before u get Kenyas BEST mobile service, u MUST send this SMS to {$SHORTCODE} TODAY. So send this message right NOW!\">Join NOW, sms <b>{$ALT_KEYWORD}</b> to <b>{$SHORTCODE}</b></a>

            $MO_ORDER_ONLY = true;
            $ON_ENTRY = "HOMEPAGE";
            $ITEMS_PER_ROW = 2;

            switch($KW_DIGIT)
            {
                case 1: $ALT_KEYWORD = "FUN"; break;
                case 2: $ALT_KEYWORD = "GET"; break;
                case 3: $ALT_KEYWORD = "STUFF"; break;
                case 4: $ALT_KEYWORD = "COOL"; break;
                case 5: $ALT_KEYWORD = "NOW"; break;
                case 6: $ALT_KEYWORD = "WANT"; break;

            }

            #$KEYWORD = $OrderCode = $ALT_KEYWORD;
            $ALT_KEYWORD = $KEYWORD;
            $HEADER_NOTE = "<h3>To get your download just SMS the word <a href=\"sms:{$SHORTCODE}?BODY={$OrderCode} - THIS IS IT! Before u get Kenyas BEST mobile service, u MUST send this SMS to {$SHORTCODE} TODAY. So send this message right NOW!\">{$OrderCode} to {$SHORTCODE}</a> right NOW!</h3>";
            $HEADER_NOTE .= "<h4>4 BONUS downloads when u join!!</h4>";
            $MIDDLE_NOTE = $HEADER_NOTE;
            $HEADER_NOTE .= "<small>See terms below</small>";
        }

        $TERMS_CONDITIONS = "<p align=\"left\" class=\"messageBox\">".
            "This is a subscription service. By clicking GO you agree to the Ts&Cs. You will have access to the hottest content for 0.30 cedi per message / 4 msgs per week. To unsubscribe sms STOP to 1906. for help email support@helpsms.net.".
            "</p>";
        $ALT_KEYWORD = $KEYWORD;
        break;

    case "KE":
        $COUNTRY = KENYA;
        $SUBSCR_COST = 30;
        $SUBSCR_MSG_PER_WEEK = 4;
        $ON_ENTRY = "SUBSCRIBE"; #"INSTANT_JOIN";

        $IS_MO = (substr($DOMAIN_KEYWORD, -2) == "MO");

        $IS_EM = (substr($DOMAIN_KEYWORD, -2) == "EM");

        $IS_EM = true;

        $HOME_TITLE = "Download Great Mobile Videos and Pics.<br />We have HUNDREDS of content items for you to choose from.";

        $KEYWORD = $OrderCode = strtoupper("babe" . $KW_DIGIT);

        $SHORTCODE = "33100";
        $CURRENCY = "";
        $PRICE_PREFIX = "Ksh ";
        $MOBILE_PREFIX = "07";
        $COUNTRY_NAME = "Kenya";
        $HELPLINE_PHONE = "";
        $SUPPORT_EMAIL = "ke@helpsms.net";
        $FOR_HELP_TEXT = "For HELP please email {$SUPPORT_EMAIL} or call 0720 632 682 (Safaricom customers) or 0736 510 786 (Airtel customers).";
        $NO_DOI = true;

        $COSTS = "The {$SITE_TITLE} gives you {$SUBSCR_CREDITS_ON_SUB} credits, subscription service costs just {$PRICE_PREFIX}{$SUBSCR_COST} to join and then {$PRICE_PREFIX}{$SUBSCR_COST} ". ($SUBSCR_MSG_PER_WEEK<7? "{$SUBSCR_MSG_PER_WEEK}x/week":"per day");

        $PSS = array("mgke","mgke");

        if($SUBDOMAIN == "2S"){
            $SHORTCODE = "6141";
            $PSS = array("tske","tske");
        }

        $NETWORK_OPTIONS = array('safaricomke'=>'Safaricom', 'airtelke'=>'Airtel', 'yuke'=>'Yu');

        switch($KW_DIGIT)
        {
            case 1: $ALT_KEYWORD = "GIRLS"; break;
            case 2: $ALT_KEYWORD = "VIDEO"; break;
            case 3: $ALT_KEYWORD = "CHICK"; break;
            case 4: $ALT_KEYWORD = "COOL"; break;
            case 5: $ALT_KEYWORD = "NOW"; break;
            case 6: $ALT_KEYWORD = "WANT"; break;

        }

        #$COST['Wallpapers'] = $COST['Animations'] = 50;
        #$COST['Games'] = 200;
        #$COST['Videos'] = $COST['Covertones'] = $COST['Truetones'] = $COST['Polyphonics'] = 100;
        #$COST['Cover Full Tracks'] = 200;
        $COST['Wallpapers'] = 50;
        $COST['Videos'] = 100;


        switch( substr($DOMAIN_KEYWORD, 0, 3) )
        {
            case "GEN":
                $CONTENTTYPES = array('Videos');
                $CONTENT_ORDER = $CONTENTTYPES;
                #$OTHER_SITES = array("vid{$KW_DIGIT}","tone{$KW_DIGIT}","wall{$KW_DIGIT}");

                #$HOME_TITLE = "Scroll down &amp; CLICK THE BUTTON RIGHT NOW for great mobile content!!";
                $HOME_INTRO = "GET THE HOTTEST VIDEOS IN KENYA";
                break;


        }


        if($IS_EM)
        {
            $ON_ENTRY = "ENTER_MOBILE";
            $HEADER_NOTE = "";
            $FOOTER_NOTE = "By clicking the button above you are confirming that you want to join the service. SMS stop to {$SHORTCODE} to end or call 0714869943 (Safaricom) 0736510786 (Zain). Cost Ksh{$SUBSCR_COST} to join and Ksh{$SUBSCR_COST} per message; 1 message per day.";
        }

        if($IS_MO)
        {

            #<a href=\"sms:{$SHORTCODE}?BODY={$ALT_KEYWORD} - THIS IS IT! Before u get Kenyas BEST mobile service, u MUST send this SMS to {$SHORTCODE} TODAY. So send this message right NOW!\">Join NOW, sms <b>{$ALT_KEYWORD}</b> to <b>{$SHORTCODE}</b></a>

            $MO_ORDER_ONLY = true;
            $ON_ENTRY = "HOMEPAGE";
            $ITEMS_PER_ROW = 2;

            switch($KW_DIGIT)
            {
                case 1: $ALT_KEYWORD = "FUN"; break;
                case 2: $ALT_KEYWORD = "GET"; break;
                case 3: $ALT_KEYWORD = "STUFF"; break;
                case 4: $ALT_KEYWORD = "COOL"; break;
                case 5: $ALT_KEYWORD = "NOW"; break;
                case 6: $ALT_KEYWORD = "WANT"; break;

            }

            $KEYWORD = $OrderCode = $ALT_KEYWORD;

            $HEADER_NOTE = "<h3>To get your download just SMS the word <a href=\"sms:{$SHORTCODE}?BODY={$OrderCode} - THIS IS IT! Before u get Kenyas BEST mobile service, u MUST send this SMS to {$SHORTCODE} TODAY. So send this message right NOW!\">{$OrderCode} to {$SHORTCODE}</a> right NOW!</h3>";
            $HEADER_NOTE .= "<h4>4 BONUS downloads when u join!!</h4>";
            $MIDDLE_NOTE = $HEADER_NOTE;
            $HEADER_NOTE .= "<small>See terms below</small>";

        }


        break;

}


if(!isset($TERMS_CONDITIONS))
    $TERMS_CONDITIONS = "<p align=\"left\" class=\"messageBox\">".
        "<h1>Terms and Conditions</h1>".
        "You must be 18+. ".
        "You'll receive {$SUBSCR_CREDITS_ON_SUB} FREE credits when you join. ".
        "Wallpapers cost just {$COST['Wallpapers']} credits and Videos {$COST['Videos']} credits. ".
        "WAP enabled phones are required to download content and GPRS rates apply. ".
        $COSTS.
        ", you will get 100 credits on each successful billing enabling you to download any content on the wapsite instantly! ".
        "All prices are including VAT. ".
        "The bill payers permission is required before using the services advertised on this wapsite.  ".
        "Incorrect entries/requests will be billed in full. ".
        "By utilizing the services, you agree that we may contact you via SMS with promotional information/offers from time to time. ".
        "We are not liable for any loss, damage or expense arising from the use by you of the services, and the services are used at your own risk. ".
        "All information and pricing of the services are correct at the date it is published on the web site but may be subject to changes. ".
        "To unsubscribe, simply SMS STOP to {$SHORTCODE}. ".
        $FOR_HELP_TEXT.
        "Participation in and/or use by you of the services constitutes acceptance by you of the Terms and Conditions; ".
        "Services brought to you by {$SITE_TITLE}".
        "</p>";

if(!isset($BUY_CREDITS_REST))
    $BUY_CREDITS_REST = "You will be charged R{$SUBSCR_COST} for the initial subscription which will give you {$SUBSCR_CREDITS_PER_MSG} credits to use on {$SITE_TITLE}! ".
        "You will then be charged ". ($SUBSCR_MSG_PER_WEEK<7? "{$PRICE_PREFIX}{$SUBSCR_COST}, {$SUBSCR_MSG_PER_WEEK}x/week":"{$PRICE_PREFIX}{$SUBSCR_COST} daily") ." which will give your ". ($SUBSCR_MSG_PER_WEEK * $SUBSCR_CREDITS_PER_MSG)." credits /week to spend on any {$SITE_TITLE} content! ".
        "You can stop at anytime, just SMS STOP to {$SHORTCODE}. ".
        "<br /><br />".
        $FOR_HELP_TEXT;

$BUY_CREDITS_REST = "<br />"; #OVERRIDE THE OLD TEXT

if(!isset($BUY_CREDITS_GOT_MSISDN))
    $BUY_CREDITS_GOT_MSISDN = "<p align=\"left\" class=\"messageBox\">".
        "By clicking on the button you're accepting the <a href=\"terms.php?back=buy_credits.php\"><u>Terms and Conditions</u></a>.".
        $BUY_CREDITS_REST.
        "</p>";


if(!isset($BUY_CREDITS_NO_MSISDN))
    $BUY_CREDITS_NO_MSISDN = "<p align=\"left\" class=\"messageBox\">".
        "By entering your mobile number and replying <b>YES</b> to <b>{$SHORTCODE}</b> you're accepting the Terms and Conditions. ".
        $BUY_CREDITS_REST.
        "</p>";