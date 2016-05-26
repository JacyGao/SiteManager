<?php

define("BILLING_DAILY",1);
define("BILLING_EVERY_SECOND_DAY",2);
define("BILLING_EVERY_THIRD_DAY",3);
define("BILLING_EVERY_FOURTH_DAY",4);
define("BILLING_EVERY_FIFTH_DAY",5);
define("BILLING_EVERY_SIXTH_DAY",6);
define("BILLING_EVERY_WEEK","w");
define("BILLING_ONCE_A_WEEK","o");
define("BILLING_TWICE_A_WEEK","t");
define("BILLING_THREE_TIMES_A_WEEK","r");
define("BILLING_WEEKDAYS","d");
define("BILLING_EVERY_SECOND_WEEK","s");
define("BILLING_MONTHLY","m");
########################

class Integrat
{
    private $UseDev = null;
    private $BILLING = array();
    private $USERS = array();
    private $default_currency = "R";
    private $default_helpline = "0841966960";

    function __construct($useDev=null)
    {
	    $this->UseDev = $useDev;

        $this->BILLING['DAILY'] = BILLING_DAILY;
        $this->BILLING['EVERY_SECOND_DAY'] = BILLING_EVERY_SECOND_DAY;
        $this->BILLING['EVERY_THIRD_DAY'] = BILLING_EVERY_THIRD_DAY;
        $this->BILLING['EVERY_FOURTH_DAY'] = BILLING_EVERY_FOURTH_DAY;
        $this->BILLING['EVERY_FIFTH_DAY'] = BILLING_EVERY_FIFTH_DAY;
        $this->BILLING['EVERY_SIXTH_DAY'] = BILLING_EVERY_SIXTH_DAY;
        $this->BILLING['EVERY_WEEK'] = BILLING_EVERY_WEEK;
        $this->BILLING['ONCE_A_WEEK'] = BILLING_ONCE_A_WEEK;
        $this->BILLING['TWICE_A_WEEK'] = BILLING_TWICE_A_WEEK;
        $this->BILLING['THREE_TIMES_A_WEEK'] = BILLING_THREE_TIMES_A_WEEK;
        $this->BILLING['WEEKDAYS'] = BILLING_WEEKDAYS;
        $this->BILLING['EVERY_SECOND_WEEK'] = BILLING_EVERY_SECOND_WEEK;
        $this->BILLING['MONTHLY'] = BILLING_MONTHLY;

        $this->USERS["MAA0100000000081"] = array("ABGCHAT5",	"4bgch4tz",		"ABGChat");
        $this->USERS["MAA0100000000082"] = array("YELLO",		"chr1stu5",		"ChristianMobile");
        $this->USERS["MAA0100000000083"] = array("CPXMOB",	"c33p33x",		"CpxMobile SA");
        $this->USERS["MAA0100000000037"] = array("HOTOBS",	"h0tn3ss",		"Hotphone");
        $this->USERS["MAA0100000000085"] = array("ZK41374",	"m00b34x",		"Hello");
        $this->USERS["MAA0100000000045"] = array("ABGCHAT5",	"4bgch4t",		"Mobivate");
        $this->USERS["MAA0100000000041"] = array("ABGFIGHT",	"4bgf1gh7",		"Mobivate");
        $this->USERS["MAA0100000000040"] = array("ABGMAIN",	"4bgm41n",		"Mobivate");
        $this->USERS["MAA0100000000042"] = array("GOZOMOOB",	"g00z00m",		"Mobivate");
        $this->USERS["MAA0100000000047"] = array("MIGOBS",	"m33gs4",		"Mobivate");
        $this->USERS["MAA0100000000046"] = array("GOZOMOGA",	"m0b1v44t",		"Mobivate");
        $this->USERS["MAA0100000000049"] = array("USSD535",	"m0b1v44t",		"Mobivate");
        $this->USERS["MAA0100000000095"] = array("USSD535",	"m00b1v4tu",	"Mobivate");
        $this->USERS["MAA0100000000044"] = array("PEACHOB",	"p34chm00b",	"Mobivate");
        $this->USERS["MAA0100000000090"] = array("PEACHOB",	"p33ch33",		"Mobivate");
        $this->USERS["MAA0100000000043"] = array("STRIPOB",	"5tr1p00b",		"Mobivate");
        $this->USERS["MAA0100000000089"] = array("STRIPOB",	"5tr1p33z",		"Mobivate");
        $this->USERS["MAA0100000000048"] = array("MMS",		"t3stmm5",		"Mobivate");
        $this->USERS["MAA0100000000096"] = array("ORMOB",		"0rm00b1l3",	"OrmobileSA");
        $this->USERS["MAA0100000000091"] = array("mobivatemain","m0b1v44t",	"OrmobileSA");
        $this->USERS["FROGGIE43487"] = array('abgmain','4bgm41n', "Froggie");
        $this->USERS["MobileMo"] = array('migsa','m33gs4', "Mobile Mojo");
        $this->USERS["TPW"] = array('migsa','m33gs4', "TextPlayWin");
        $this->USERS["Mmonkey"] = array('migsa','m33gs4', "Mintmonkey");
        #$this->USERS["getmobicontent"] = array('MIGOBS','m33gs4', "getmobicontent");
        $this->USERS["getmobicontent"] = array('migsa','m33gs4', "getmobicontent");
        $this->USERS["MAA0100000000099"] = array('migsa','m33gs4', "Exvidz");

        $this->USERS["MAA0100000000092"] = array('mobivatemain','m0b1v44t',	"TextPlayWin");
        $this->USERS["MAA0100000000093"] = array('mobivatemain','m0b1v44t',	"TextPlayWin");
        $this->USERS["MAA0100000002013"] = array('mobivatemain','m0b1v44t',	"MobileMojo");

	# http://desk.mobivate.com/helpdesk/tickets/3400
        $this->USERS["MAA010000997D69R"] = array('OrmobileSA',	'W0f98D', 	"");
        $this->USERS["MAA0100002z8626K"] = array('OrmobileSA',  'W0f98D',       "");
        $this->USERS["MAA010000w39797H"] = array('OrmobileSA',  'W0f98D',       "");
        $this->USERS["MAA01000284X66zY"] = array('OrmobileSA',  'W0f98D',       "");
        $this->USERS["MAA01000S8LTKyse"] = array('OrmobileSA',  'W0f98D',       "");
        $this->USERS["MAA01000Z12T02Pk"] = array('OrmobileSA',  'W0f98D',       "");
        $this->USERS["MAA01000KN62Nin4"] = array('OrmobileSA',  'W0f98D',       "");
        $this->USERS["MAA010007C5N6Hlm"] = array('OrmobileSA',  'W0f98D',       "");
        $this->USERS["MAA01000K0PFm9kB"] = array('OrmobileSA',  'W0f98D',       "");
        $this->USERS["MAA01000j61884KO"] = array('OrmobileSA',  'W0f98D',       "");

        $this->USERS["MAA010002a147QVp"] = array('OrmobileSA',  'W0f98D',       "");
        $this->USERS["MAA01000wSG6v7qI"] = array('OrmobileSA',  'W0f98D',       "");
        $this->USERS["MAA01000iVzHnq7y"] = array('OrmobileSA',  'W0f98D',       "");


    }

    private function getAccount($KEY)
    {
        if(!isset($this->USERS[ $KEY ]))
            return false;

        return $this->USERS[ $KEY ];
    }

    private function getBillingFrequency($freq)
    {
        $freq = strtoupper($freq);

        if(!isset($this->BILLING[ $freq ]))
            return BILLING_DAILY;

        return $this->BILLING[ $freq ];
    }


    function redirect($key, $host,  $logo_url='images/header.jpg', $service_name='Mobivate Club',  $success_url='mnp_ok.php', $fail_url='mnp_fail.php', $subscription_service="no", $billing_amount=NULL, $billing_frequency=NULL, $billing_currency="R", $helpline=null)
    {
        $url = $this->getURL($key, $host, $logo_url, $service_name, $success_url, $fail_url, $subscription_service, $billing_amount, $billing_frequency, $billing_currency, $helpline );
        if(!$url)
        {
            if($fail_url == "default")
                echo "Invalid KEY";
            else
                header("Location: http://{$host}/{$fail_url}?error=invalidkey");
            return;
        }

        header("Location: {$url}");
    }

    function getURL($key, $host, $logo_url='images/header.jpg', $service_name='Mobivate Club', $success_url='mnp_ok.php', $fail_url='mnp_fail.php',  $subscription_service="no", $billing_amount=NULL, $billing_frequency=NULL, $billing_currency="R", $helpline=null )
    {
        $account = $this->getAccount($key);
        if(!$account)
        {
            return false;
        }


        list($username, $password, $service_provider) = $account;

        if(is_numeric($billing_amount) && $billing_amount>0)
            $endpoint = "http://wap.integrat.co.za/mAPI". ($this->UseDev? "_dev":"") .".php";
        else
            $endpoint = "http://wap.integrat.co.za/dAPI.php";


        $billing_frequency = $this->getBillingFrequency($billing_frequency);

        #$url = "http://api.integrat.co.za/clients/msisdn_client.php";

        /*
            *  *cc - the username provided to you to use this API
            * *pw - the associated password
            * *srl - Success URL (The URL to direct to if the MSISDN was detected and the person accepted)
            * *frl - Fail URL (The URL to direct to if the MSISDN could not be picked up. This will usually point to your pinAPI implementation)
            * *lrl - Logo URL (The URL of the graphic / icon to be displayed on the confirmation page if the MSISDN was picked up)
            * *su - Subscription Service ( = yes ) or Once-off charge ( = no )
            * *sn - Service (Your Service) Name
            * *sp - Service Provider (Your) Name
            * bc - Billing Currency ( e.g. R = South African Rand , KSH = Kenyan Shillings) - defaults to R for South African Rand (ZAR)
            * *ba - Bill Amount (e.g. 10.50)
            * *bf - Bill Frequency =
                  o '1' => 'daily',
                  o '2' => 'every second day'
                  o '3' => 'every third day'
                  o '4' => 'every fourth day'
                  o '5' => 'every fifth day'
                  o '6' => 'every sixth day'
                  o 'w' => 'every week'
                  o 'o' => 'once a week'
                  o 't' => 'twice a week'
                  o 'r'=>'three times a week'
                  o 'd'=>'weekdays'
                  o 's'=>'every second week'
                  o 'm'=>'monthly'
            * cs - Call Center Number - defaults to 0822350400.
        */
        $req = array ();
        $req[] = "cc=". urlencode($username);
        $req[] = "pw=". urlencode($password);
        $req[] = "srl=". urlencode("http://". $host ."/". $success_url);
        if($fail_url != 'default')
            $req[] = "frl=". urlencode("http://". $host ."/". $fail_url);
        else
        $req[] = "frl=". urlencode($fail_url);
        $req[] = "lrl=". urlencode("http://". $host ."/". $logo_url);
        $req[] = "su=". urlencode($subscription_service);
        $req[] = "sn=". urlencode($service_name);
        //$req[] = "dn=". urlencode($host);change as requested by sybille
        $req[] = "dn=".urlencode("Content");
        $req[] = "sp=". urlencode($service_provider);
        $req[] = "bc=". urlencode($billing_currency? $billing_currency:$this->default_currency);
        $req[] = "ba=". urlencode($billing_amount);
        $req[] = "bf=". urlencode($billing_frequency);
        $req[] = "cs=". urlencode($helpline? $helpline:$this->default_helpline);

        $location = $endpoint ."?". implode("&", $req);

        return $location;
    }

}
