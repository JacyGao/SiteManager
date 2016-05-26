<?php
/**
 * Created by John Huseinovic
 * Date: 28/11/12
 * Time: 11:02 AM
 */
require_once( dirname(__FILE__) ."/inc_functions.php" );
require_once( dirname(__FILE__) ."/errors.php" );
require_once( dirname(__FILE__) ."/users.php" );
require_once( dirname(__FILE__) ."/number_lookup.php" );

define("SRS_ENDPOINT_TAS", "http://tas.mobivate.com/srs/Enterprise");
define("SRS_ENDPOINT_HATCH", "http://hatch.mobivate.com/srs/Enterprise");
define("SRS_ENDPOINT_APPS", "http://apps.mobivate.com/srs/Enterprise");
define("SRS_ENDPOINT_SMSC", "http://srs.smsc.com.au/Enterprise");

class message
{
    private $ALWAYS_ALLOW = array(
        16478016148,
        61433694974,
        6421828828,
        27745804170,
        27828801020,
        447588388677,
        447774539526,
        447532173551,
        447895279870,
        447956020025,
        447501202683,
        447762557229,
        61402123100,
        27828801020,
        27700000061,27700000062,27700000063,27700000075
        );

    # BLACKLIST {$COUNTRY}{$MOBILE}  610410788959 is correct.
    private $BLACKLIST = array(
        610414566055,610410788959,610411084820,14164007901,19055314005,14164643285,14165057776,14166627653,14163197356,14163190282,19053341492,61428288225,610428288225,61428519750,610428519750);

    private $BONGO_POX_SHORTCODES = array(
        19926646,66668,57848,38991);

    private $FIXED_PROVIDER = false;

    private $req;
    private $MsgType;
    private $Country;
    private $Mobile;
    private $MSISDN;
    private $Network;

    const MESSAGE_TYPE_PIN = "PIN";
    const MESSAGE_TYPE_SUBSCRIBE = "SUBSCRIBE";
    const MESSAGE_TYPE_MESSAGE = "MESSAGE";
    const MESSAGE_TYPE_PCS = "PCS";

    private $db;


    function __construct($req = array())
    {
        $this->req = array_change_key_case($req, CASE_UPPER);

        $this->db = @mysql_connect("mobivate.com","mobivate_web","05u38jgjj245") or writeLog('error', __LINE__ .": ". mysql_error());
        @mysql_select_db("mobivate_smsgw", $this->db) or writeLog('error', __LINE__ .": ". mysql_error());

    }

    function __destruct()
    {
        mysql_close($this->db);
    }

    function validateInput()
    {
        if( !isset($this->req['UNAME']) )
            return errors::invalid_username;

        if( !isset($this->req['PWD']) )
            return errors::invalid_password;

        if( !users::validate($this->req['UNAME'],$this->req['PWD']) )
            return errors::username_password_incorrect;

        if( !isset($this->req['COUNTRY']) )
            return errors::country_not_specified;

        if( !isset($this->req['MOBILE'])  )
            return errors::mobile_not_specified;

        if( !isset($this->req['SHORTCODE']) )
            return errors::shortcode_not_specified;

        if( !isset($this->req['PROVIDER']) )
            return errors::provider_not_specified;

        if( !isset($this->req['MESSAGE']) )
            return errors::empty_message;

        if( !isset($this->req['TYPE']) )
            return errors::type_not_specified;

        if( in_array($this->req['COUNTRY'].$this->req['MOBILE'], $this->BLACKLIST) )
        {
            mail('john@mobileapplications.com.au','Blacklisted Number', implode("\n", $this->req) );
            return errors::blacklisted_recipient;
        }

        $this->MsgType = trim($this->req['TYPE']);

        $this->req['PROVIDER'] = str_replace("primary","premium", strtolower($this->req['PROVIDER']));

        return $this->validateMobile();
    }

    function validateMobile()
    {

        $this->Country = (int)preg_replace("/[^0-9]/", "", $this->req['COUNTRY']);
        $this->Mobile = preg_replace("/[^0-9]/", "", $this->req['MOBILE']);

        writeLog( "sms", "{$this->Country} / {$this->Mobile}" );

        if(strlen($this->Country) < 1) return errors::country_not_specified;
        if(strlen($this->Mobile) < 9) return errors::invalid_number_format;

        $PREFIXES = array();

        # US & CANADA
        $PREFIXES[1] = range(20,98);
        # AU
        $PREFIXES[61] = range(40,49);
        # NZ
        $PREFIXES[64] = array(21, 29);
        # UK
        $PREFIXES[44] = array(12, 15, 16, 20, 37, 38, 40, 41, 42, 44, 46, 49, 58, 77, 78, 79, 97, 80, 83, 85, 86, 93, 95, 96, 97);
        # SA
        $PREFIXES[27] = array(71, 72, 73, 74, 76, 78, 79, 82, 83, 84);

        $PREFIXES[254] = array(70,71,72,73,75,77,78,79);

        switch($this->Country)
        {

            case 1:
                if(strlen($this->Mobile) != 10) return errors::invalid_number_format_for_country;
                $this->MSISDN = $this->Country . $this->Mobile;
                break;

            case 61:
                $this->MSISDN = (in_array( substr($this->Mobile,1,2), $PREFIXES[ $this->Country ])? "{$this->Country}". substr($this->Mobile, 1, 10) : NULL);
                break;

            case 254:
                $this->MSISDN = (in_array( substr($this->Mobile,1,2), $PREFIXES[ $this->Country ])? "{$this->Country}". substr($this->Mobile, 1, 10) : NULL);
                break;

            default:
                if( substr($this->Mobile, 0, 1) == "0"  ) {
                    $this->MSISDN = "{$this->Country}". substr($this->Mobile, 1, 11);
                } else {
                    return errors::invalid_number_format_for_country;
                }
                break;

        }

        writeLog( "debug", "{$this->Country} + {$this->Mobile} => {$this->MSISDN}" );

        if( is_null( $this->MSISDN ) )
            return errors::invalid_number_format_for_country;

        return true;

    }

    function prepareMessage()
    {
        $FIXED_PROVIDER = false;

        $sms = new SMS_Gateway();

        $sms->set("PROVIDER", $this->req['PROVIDER'] );

        switch($this->Country)
        {
            case "61":
                $network = number_lookup::australia($this->MSISDN);
                if( $sms->get('PROVIDER') != 'default' )
                    $sms->set('PROVIDER', (strtolower($network) == 'unknown'? 'premium':$network) );

                writeLog( "debug", __LINE__ ." Network : {$network}" );
                break;

            case "27":
                switch( $sms->get('PROVIDER') )
                {
                    case "1":
                        $sms->set('PROVIDER', 'vodacomsa' );
                        break;

                    case "2":
                        $sms->set('PROVIDER', 'mtnsa' );
                        break;

                    case "3":
                        $sms->set('PROVIDER', 'cellcsa' );
                        break;

                    case "15":
                        $sms->set('PROVIDER', '8tasa' );
                        break;

                    case "default":
                        break;

                    default:
                        $network = number_lookup::south_africa($this->MSISDN);
                        $sms->set('PROVIDER', (strtolower($network) == 'unknown'? 'premium':$network) );
                        writeLog( "debug", __LINE__ ." Network : {$network}" );
                        break;
                }

                break;
        }

        writeLog( "debug", __LINE__ ." Provider : ". $sms->get('PROVIDER') );

        if( $this->req['SHORTCODE'] == '61428288225' || $this->req['SHORTCODE'] == '61428519750' )
            $sms->set('PROVIDER', 'default');

        $sms->set('MESSAGE_TEXT', $this->req['MESSAGE']);

        if( in_array($this->req['SHORTCODE'], $this->BONGO_POX_SHORTCODES) ) # BONGO
        {
            $sms->set("USER_NAME","bongoiegw");
            $sms->set("PASSWORD","2doY0DT");
            $sms->URL = "http://pox.smsc.com.au/pox/input/smsinput.php";
            writeLog( "debug", __LINE__ ." Is Bongo Shortcode" );
        }
        else
        {
            if($this->req['UNAME'] == "mobigr8quiz" && $this->req['SHORTCODE'] != "61428288225" )
            {
                $sms->set("USER_NAME","mobileapps.quiz");
                $sms->set("PASSWORD","appl1cat10ns");
                writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') );
            }
            elseif($this->req['UNAME'] == "cmgkenya" )
            {
                $sms->set("USER_NAME","cmg");
                $sms->set("PASSWORD","ExRZ0q4E");


                if( $sms->get('PROVIDER') == "default")
                {
                    $sms->set("CAMPAIGN", "kebulk1");
                    $FIXED_PROVIDER = true;
                    writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );
                }
                else
                {
                    $sms->set("PROVIDER","premium");
                    $sms->set("CAMPAIGN", "keperm1");
                    writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );
                }
            }
            elseif($this->req['UNAME'] == "cmgghana" )
            {
                $sms->set("USER_NAME","cmg");
                $sms->set("PASSWORD","ExRZ0q4E");

                writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );

                if( $sms->get('PROVIDER') == "default2")
                {
                    $sms->set("PROVIDER","default");
                    $sms->set("CAMPAIGN", "bulk2");
                    $FIXED_PROVIDER = true;
                    writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );

                }

            }
            else if($this->req['UNAME'] == "freeworldwide")
            {
                $sms->set("USER_NAME","freeworldwide");
                $sms->set("PASSWORD","bI3FMzJi");
                writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') );
            }/* Add instance for user freeworldwide for Kenya free MTs*/
            else
            {
                $IsAlphaNumeric = preg_replace("/[0-9]/","", trim($this->req['SHORTCODE']));

                writeLog( "debug", __LINE__ ." IsAlphaNumeric ". $IsAlphaNumeric );

                if($IsAlphaNumeric || $this->req['SHORTCODE'] == "611902996699" || $this->req['SHORTCODE'] == "447797804021" )
                {
                    $this->req['SHORTCODE'] = preg_replace("/[^0-9a-zA-Z]/", "", $this->req['SHORTCODE']);
                    $this->req['SHORTCODE'] = substr($this->req['SHORTCODE'], 0, 15);
                    $this->req['TYPE'] = self::MESSAGE_TYPE_MESSAGE;

                    $sms->set("PROVIDER","default");

                    $sms->set("USER_NAME","mobileapps.any");
                    $sms->set("PASSWORD", "appl1cat10ns");

                    writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );


                }

                elseif( in_array($this->req['SHORTCODE'], array(193030,39887,36308,43128,43493,43487,41572,41573,41662,38900,1910,6655,41291,43292,43293,5595,6181,20019,6191,30191,31356,8080,7878,7979,43054,37467,6141,1906,43157,43295,31355,30191,40849,43022,43486,43741,31409,31995,43392,43492,31602,43448))  ) {

                    $sms->set("USER_NAME","mobileapps");
                    $sms->set("PASSWORD", "appl1cat10ns");

                    writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );

                }
                elseif( in_array($this->req['SHORTCODE'], array(33100))  ) {

                    if( $sms->get('PROVIDER') == "default")
                    {
                        $sms->set("USER_NAME","freeworldwide");
                        $sms->set("PASSWORD","bI3FMzJi");

                        writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );
                    }
                    else
                    {
                        $sms->set("USER_NAME","mobileapps");
                        $sms->set("PASSWORD", "appl1cat10ns");

                        writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );
                    }

                }
                elseif( $this->req['SHORTCODE'] == "19900500")
                {
                    $sms->set("USER_NAME","mobivate");
                    $sms->set("PASSWORD", "x7FNfwA6");

                    writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );
                }
                else
                {
                    $sms->set("USER_NAME","reason8");
                    $sms->set("PASSWORD", "Yhuk6f34xX");

                    writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );

                }
            }


            switch($this->req['TYPE'])
            {
                default:
                case self::MESSAGE_TYPE_PIN:
                case self::MESSAGE_TYPE_MESSAGE:
                    if($this->req['SHORTCODE'] == "77000")
                    {
                        $sms->set("USER_NAME","chatgw.77000");
                        $sms->set("PASSWORD", "OzZ97Pwh");
                    }
                    if($this->req['SHORTCODE'] == "88088")
                    {
                        $sms->set("USER_NAME","chatgw.88088");
                        $sms->set("PASSWORD", "1pwZAoHR");
                    }
                    $sms->URL = getSRSURL($this->req['SHORTCODE']) . "/sendsmsv2";

                    writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );

                    break;

                case self::MESSAGE_TYPE_SUBSCRIBE:
                    if($this->req['SHORTCODE'] == "88088" || $this->req['SHORTCODE'] == "77000")
                    {
                        $sms->set("USER_NAME","mobileapps");
                        $sms->set("PASSWORD", "appl1cat10ns");
                    }

                    $sms->URL = getSRSURL($this->req['SHORTCODE']) . "/pushsmsv2";

                    writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );

                    break;
            }

            $copyOfPost = $this->req;
            unset(
            $copyOfPost['UNAME'],
            $copyOfPost['PWD'],
            $copyOfPost['COUNTRY'],
            $copyOfPost['MOBILE'],
            $copyOfPost['SHORTCODE'],
            $copyOfPost['PROVIDER'],
            $copyOfPost['TYPE'],
            $copyOfPost['SERVICE'],
            $copyOfPost['AFFILIATE'],
            $copyOfPost['MESSAGE'],
            $copyOfPost['IP'],
            $copyOfPost['__UTMZ'],
            $copyOfPost['__UTMA'],
            $copyOfPost['PHPSESSID']
            );

            foreach($copyOfPost as $key=>$val) { $sms->set( $key, $val ); }

            writeLog( "debug", __LINE__ ." Type ". $this->req['TYPE'] );

            if ( $this->req['TYPE'] == self::MESSAGE_TYPE_PIN )
            {
                writeLog( "debug", __LINE__ ." Match ". $this->req['TYPE'] );

                if($sms->get('PROVIDER') == "HUTC3G")
                    $sms->set('MESSAGE_TEXT', "Free Msg: ". $sms->get('MESSAGE_TEXT') );

                $sms->set("RECIPIENT", $this->MSISDN);
                $sms->set("ORIGINATOR",$this->req['SHORTCODE']);

                if(!$FIXED_PROVIDER)
                    $sms->set("PROVIDER","default");		# OVERRIDE PROVIDER TO DEFAULT

                if(!in_array($sms->get('RECIPIENT'), $this->ALWAYS_ALLOW ))
                {
                    $where = array();
                    if(isset($this->req['SERVICE'])) $where[] = "SERVICE='". mysql_real_escape_string( $this->req['SERVICE'] ) ."'";
                    if(isset($this->req['SHORTCODE'])) $where[] = "ORIGINATOR='". mysql_real_escape_string( $this->req['SHORTCODE'] ) ."'";
                    if(isset($this->req['MOBILE'])) $where[] = "RECEPIENT='". mysql_real_escape_string( $this->req['MOBILE'] ) ."'";
                    if(isset($this->req['AFFILIATE'])) $where[] = "AFFILIATE='". mysql_real_escape_string( $this->req['AFFILIATE'] ) ."'";
                    if(isset($this->req['REFERER'])) $where[] = "REFERER='". mysql_real_escape_string( $this->req['REFERER'] ) ."'";

                    $query = "SELECT ID FROM sms_logs WHERE ". implode(" AND ", $where);

                    writeLog("debug", __LINE__ ." :: ". $query); $spammer = mysql_query($query, $this->db)  or die( mysql_error());

                    if( mysql_num_rows($spammer) > 5 )
                    {
                        writeLog( "error", __LINE__ ." :: Blocked user for too many attempts! ". mysql_num_rows($spammer) );
                        return errors::too_many_attempts;
                    }
                }

                writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );


            }
            elseif ( $this->req['TYPE'] == self::MESSAGE_TYPE_MESSAGE )
            {
                writeLog( "debug", __LINE__ ." Match ". $this->req['TYPE'] );

                $sms->set("RECIPIENT", $this->MSISDN);
                $sms->set("ORIGINATOR",$this->req['SHORTCODE']);

                $where = array();
                $where[] = "ORIGINATOR='". mysql_real_escape_string( $this->MSISDN ) ."'";
                $where[] = "RECEPIENT='". mysql_real_escape_string( $this->req['SHORTCODE'] ) ."'";
                $where[] = "MESSAGE='". mysql_real_escape_string( $sms->get('MESSAGE_TEXT') ) ."'";
                $where[] = "DATE_ADD(posted,INTERVAL 2 MINUTE) >= '". date("Y-m-d H:i:s") ."'";
                if(isset($this->req['AFFILIATE'])) $where[] = "AFFILIATE='". mysql_real_escape_string( $this->req['AFFILIATE'] ) ."'";

                $query = "SELECT ID , posted, DATE_ADD(posted,INTERVAL 2 MINUTE) FROM sms_logs WHERE ". implode(" AND ", $where);

                writeLog("debug", __LINE__ ." :: ". $query); $spammer = mysql_query($query, $this->db);


                if( mysql_num_rows($spammer) > 0 )
                    return errors::repeated_message;

                writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );


            }
            elseif ( $this->req['TYPE'] == self::MESSAGE_TYPE_SUBSCRIBE )
            {
                writeLog( "debug", __LINE__ ." Match ". $this->req['TYPE'] );

                $sms->set("RECIPIENT", $this->MSISDN);
                $sms->set("ORIGINATOR",$this->req['SHORTCODE']);

                if( !in_array($this->MSISDN, $this->ALWAYS_ALLOW) )
                {
                    $where = array();
                    $where[] = "ORIGINATOR='". mysql_real_escape_string( $this->MSISDN ) ."'";
                    $where[] = "RECEPIENT='". mysql_real_escape_string( $this->req['SHORTCODE'] ) ."'";
                    $where[] = "MESSAGE='". mysql_real_escape_string( $sms->get('MESSAGE_TEXT') ) ."'";
                    $where[] = "DATE_ADD(posted,INTERVAL 2 MINUTE) >= '". date("Y-m-d H:i:s") ."'";
                    if(isset($this->req['AFFILIATE'])) $where[] = "AFFILIATE='". mysql_real_escape_string( $this->req['AFFILIATE'] ) ."'";

                    $query = "SELECT ID , posted, DATE_ADD(posted,INTERVAL 2 MINUTE) FROM sms_logs WHERE ". implode(" AND ", $where);

                    writeLog("debug", __LINE__ ." :: ". $query); $spammer = mysql_query($query, $this->db) or writeLog('error', __LINE__ .": ". mysql_error());

                    if( mysql_num_rows($spammer) > 0 )
                        return errors::subscription_loop;

                    writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );

                }

                if( $sms->get('PROVIDER') == "HUTC3G" &&
                    !in_array($sms->get('ORIGINATOR'), array('19900500','19900600','193030','61428288225','61428519750')) )
                {
                    $sms->URL = getSRSURL($_REQUEST['SHORTCODE']) . "/sendsmsv2";

                    $sms->set('PROVIDER', "default");
                    $sms->set('MESSAGE_TEXT', "(Free Msg) Unfortunately we are unable to provide any content at the moment to Three customers. Please try again later.");

                    writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );
                }
                else
                {

                    $sms->set("RECIPIENT", $this->req['SHORTCODE']);
                    $sms->set("ORIGINATOR", $this->MSISDN);

                    $sParams = array();
                    $sParams[] = "posted='". date("Y-m-d H:i:s") ."'";
                    $sParams[] = "SERVICE='{$this->req['SERVICE']}'";
                    $sParams[] = "SHORTCODE='". $sms->get("RECIPIENT") ."'";
                    $sParams[] = "MOBILENO='". $sms->get("ORIGINATOR") ."'";
                    $sParams[] = "PROVIDER='". $sms->get("PROVIDER") ."'";
                    if(isset($_REQUEST['AFFILIATE']))
                       $sParams[] = "AFFILIATE='{$_REQUEST['AFFILIATE']}'";
                    $sParams[] = "PARAMS='". addslashes($sms->get("MESSAGE_TEXT")) ."'";

                    if(isset($_SERVER['HTTP_REFERER']))
                        $sParams[] = "REFERER='". $_SERVER['HTTP_REFERER'] ."'";

                    if(!isset($_REQUEST['IP']))
                        $_REQUEST['IP'] = (isset($_SERVER['REMOTE_ADDR'])? $_SERVER['REMOTE_ADDR']:"");

                    $sParams[] = "IP='". $_REQUEST['IP'] ."'";

                    $query = "INSERT INTO sms_subs_all SET ". implode(", ", $sParams);

                    writeLog("debug", __LINE__ ." :: ". $query); mysql_query($query, $this->db ) or writeLog('error', __LINE__ .": ". mysql_error());

                    if( isset($this->req['SERVICE']) )
                    {

                        $msgarr = explode(" ", $sms->get("MESSAGE_TEXT"));
                        $kw = $msgarr[0];

                        $Check_PSS_Subscriber = "http://apps.mobivate.com/pss/IsSubscribedTo.php?service=". $sms->get("RECIPIENT") ."&mobile=". $sms->get("ORIGINATOR") ."&kw=". $kw;
                        $subscribed = file($Check_PSS_Subscriber);
                        if( strstr($subscribed[0], "NOT_SUBSCRIBED") == true || in_array($sms->get("ORIGINATOR"), $this->ALWAYS_ALLOW) )
                        {
                            $query = "INSERT INTO sms_subscribers SET ". implode(", ", $sParams);

                            writeLog("debug", __LINE__ ." :: ". $query); mysql_query($query, $this->db ) or writeLog('error', mysql_error());
                        }
                        else
                        {
                            unset($sms);
                            return errors::already_subscribed;
                        }


                    }

                    writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );


                }

            }
            elseif ( $this->req['TYPE'] == self::MESSAGE_TYPE_PCS )
            {
                writeLog( "debug", __LINE__ ." Match ". $this->req['TYPE'] );

                $sms->URL = getSRSURL($this->req['SHORTCODE']) . "/pushsmsv2";

                $sms->set("RECIPIENT", $this->req['SHORTCODE']);
                $sms->set("ORIGINATOR", $this->MSISDN);

                writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );


            }
            elseif ( substr($this->req['TYPE'],0,3) == "CUE" )
            {
                writeLog( "debug", __LINE__ ." Match ". $this->req['TYPE'] );

                unset(	$copyOfPost['VALUE'] );

                $extraFields = array();
                foreach($copyOfPost as $k=>$v) { $extraFields[] = "{$k}={$v}"; }

                $newType = substr($this->req['TYPE'], 4);

                $sParams[] = "type='". ($newType? $newType:"SUBSCRIBE") ."'";
                $sParams[] = "service='{$this->req['SERVICE']}'";
                $sParams[] = "shortcode='". $this->req['SHORTCODE'] ."'";
                $sParams[] = "mobileno='". $this->req['MOBILE'] ."'";
                $sParams[] = "country='". $this->req['COUNTRY'] ."'";
                $sParams[] = "provider='". $this->req['PROVIDER'] ."'";
                $sParams[] = "affiliate='". mysql_real_escape_string($this->req['AFFILIATE']) ."'";
                $sParams[] = "value='". mysql_real_escape_string($this->req['VALUE']) ."'";
                $sParams[] = "extra='". mysql_real_escape_string( implode("&", $extraFields) ) ."'";
                $sParams[] = "message='". mysql_real_escape_string($sms->get("MESSAGE_TEXT")) ."'";
                $sParams[] = "recorded='". date("Y-m-d H:i:s") ."'";

                $query = "INSERT INTO sms_cue SET ". implode(", ", $sParams);

                writeLog("debug", __LINE__ ." :: ". $query); mysql_query($query, $this->db ) or writeLog('error', __LINE__ .": ". mysql_error());

                writeLog( "debug", __LINE__ ." Match ". $sms->get('USER_NAME') ." : ". $sms->get("CAMPAIGN") );

                return errors::message_queued;

            }
            else
                return errors::error_parsing_message;

            return $sms;

        }
    }

    function sendSMS(&$sms)
    {
        if( is_integer($sms) )
            return $sms;

        if( !is_object($sms)  )
            return errors::generic_failure;

        $response = $sms->send();
        if ($response == errors::success)
        {

            $sParams = array();
            $sParams[] = "posted='". date("Y-m-d H:i:s") ."'";
            $sParams[] = "SERVICE='{$this->req['SERVICE']}'";
            $sParams[] = "ORIGINATOR='". $sms->get("ORIGINATOR") ."'";
            $sParams[] = "CHARGE='". $sms->get("VALUE") ."'";
            $sParams[] = "RECEPIENT='". $sms->get("RECIPIENT") ."'";
            if(isset($this->req['AFFILIATE']))
                $sParams[] = "AFFILIATE='". mysql_real_escape_string($this->req['AFFILIATE']). "'";
            $sParams[] = "MESSAGE='". mysql_real_escape_string($sms->get('MESSAGE_TEXT')) ."'";
            if(isset($this->req['HTTP_REFERER']))
                $sParams[] = "REFERER='". $this->req['HTTP_REFERER'] ."'";
            if(isset($this->req['IP']))
                $sParams[] = "IP='". $this->req['IP'] ."'";
            $sParams[] = "username='". $this->req['UNAME'] ."'";

            $query = "INSERT INTO sms_logs SET ". implode(", ", $sParams);

            writeLog("debug", __LINE__ ." :: ". $query); @mysql_query($query, $this->db ) or writeLog('error', __LINE__ .": ". mysql_error());

            return true;
        }
        else
            return $response;
    }

    function unqueue( $msisdn )
    {
        $this->MSISDN = $msisdn;

        if( substr($msisdn, 0, 1) == '1') {
            $mobile = substr($msisdn, 1);
            $country = 1;
        } elseif( substr($msisdn, 0, 3) == '254' || substr($msisdn, 0, 3) == '233' ) {
            $mobile = "0". substr($msisdn, 3);
            $country = substr($msisdn, 0, 3);

        } else {
            $mobile = "0". substr($msisdn, 2);
            $country = substr($msisdn, 0, 2);
        }

        $query = "SELECT * FROM sms_cue WHERE mobileno='". addslashes($mobile) ."' AND delivered='0000-00-00 00:00:00'";

        writeLog("debug", __LINE__ ." :: ". $query); $results = mysql_query($query, $this->db) or die(mysql_error());
        if( mysql_num_rows($results) == 0 )
        {
            echo "Nothing Found!";
            return false;
        }


        while($rs = mysql_fetch_array($results, MYSQL_ASSOC))
        {
            $this->req['PROVIDER'] = $rs['provider'];
            $this->req['MESSAGE_TEXT'] = $rs['message'];
            $this->req['COUNTRY'] = $rs['country'];
            $this->req['MOBILE'] = $rs['mobileno'];
            $this->req['SHORTCODE'] = $rs['shortcode'];
            $this->req['TYPE'] = $rs['type'];

            $valid = $this->validateMobile();
            if( $valid === true )
            {
                $sms = $this->prepareMessage();
                $response = $this->sendSMS($sms);

                if($response == errors::success) {
                    echo "Delivered #{$rs['ID']}\n";
                } else {
                    echo "Delivery failed on msg {$rs['ID']}. Error #{$response}\n";
                }
            }


        }

        $query = "UPDATE sms_cue SET delivered='". date("Y-m-d H:i:s") ."' WHERE mobileno='". mysql_real_escape_string($mobile) ."'";

        writeLog("debug", __LINE__ ." :: ". $query); mysql_query($query);

        return true;
    }

}


class SMS_Gateway
{
    var $URL = "";
    var $PARAMS = array();
    private $tried_hosts = array();
    private $tried_users = array();

    function set($key=NULL, $value=NULL) { $this->PARAMS[ strtoupper($key) ] = trim($value); return true; }
    function get($key) { return isset($this->PARAMS[ strtoupper($key) ])? $this->PARAMS[ strtoupper($key) ]:NULL; }

    private function updateURL($new)
    {
        $this->URL = str_replace( SRS_ENDPOINT_APPS, $new,  $this->URL);
        $this->URL = str_replace( SRS_ENDPOINT_HATCH, $new,  $this->URL);
        $this->URL = str_replace( SRS_ENDPOINT_TAS, $new,  $this->URL);
        $this->URL = str_replace( SRS_ENDPOINT_SMSC, $new,  $this->URL);
    }

    private function hasDone($host)
    {
        foreach($this->tried_hosts as $url)
        {
            if( strstr($url, $host) == true ) return true;
        }
        return false;
    }

    private function deliver($pkg)
    {

        $send_start = microtime(true);

        $shortcode = $this->get('ORIGINATOR');
        if( strlen($shortcode) > 10 )
            $shortcode = $this->get('RECIPIENT');

        writeLog( "gw", "Sending {$shortcode} to {$this->URL} (".$this->get('user_name').")" );

        $ch = curl_init($this->URL);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, implode("&", $pkg) );
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);

        $result = curl_exec($ch);
        curl_close ($ch);

        $send_end = microtime(true);
        $benchmark = number_format( ($send_end - $send_start), 3);

        if( $result === false || $curl_errno > 0 )
        {
            writeLog( "gw", "{$curl_errno} ][ {$this->URL}?".implode("&", $pkg) ." ][ {$curl_error} ][ took {$benchmark}sec" );
            return errors::gateway_timeout;
        }

        $result = explode("\n", trim($result), 2);
        $code = $result[0];

        writeLog( "gw", "RESULT: ". json_encode($result) );
        #$code = $code;

        if( (int)$code == errors::invalid_originator_address )
        {
            $this->tried_hosts[] = $this->URL;

            if( !$this->hasDone(SRS_ENDPOINT_APPS) )
            {
                $this->updateURL( SRS_ENDPOINT_APPS );
                writeLog( "gw", "SRS rejected Originator! Retry SRS : " . $this->URL . " ". json_encode($this->tried_hosts));
                return $this->deliver($pkg);
            }
            if( !$this->hasDone(SRS_ENDPOINT_HATCH) )
            {
                $this->updateURL( SRS_ENDPOINT_HATCH );
                writeLog( "gw", "SRS rejected Originator! Retry SRS : " . $this->URL . " ". json_encode($this->tried_hosts));
                return $this->deliver($pkg);
            }
            if( !$this->hasDone(SRS_ENDPOINT_TAS) )
            {
                $this->updateURL( SRS_ENDPOINT_TAS );
                writeLog( "gw", "SRS rejected Originator! Retry SRS : " . $this->URL . " ". json_encode($this->tried_hosts));
                return $this->deliver($pkg);
            }
            if( !$this->hasDone(SRS_ENDPOINT_SMSC) )
            {
                $this->updateURL( SRS_ENDPOINT_SMSC );
                writeLog( "gw", "SRS rejected Originator! Retry SRS : " . $this->URL . " ". json_encode($this->tried_hosts));
                return $this->deliver($pkg);
            }

            writeLog( "notice", "CODE #{$code} From all SRS's. ". json_encode($pkg));
        }


        if( (int)$code == errors::invalid_username )
        {
            $this->tried_users[] = $this->get('USERNAME');

            if( !in_array("reason8", $this->tried_users) )
            {
                $this->set('USERNAME', 'reason8');
                $this->set('PASSWORD', 'Yhuk6f34xX');
                $pkg = $this->wrapPackage();
                writeLog( "gw", "SRS rejected User! Retry Username : " .  $this->get('USERNAME') ." ". json_encode($this->tried_users));
                return $this->deliver($pkg);
            }
            if( !in_array("mobileapps", $this->tried_users) )
            {
                $this->set('USERNAME', 'mobileapps');
                $this->set('PASSWORD', 'appl1cat10ns');
                $pkg = $this->wrapPackage();
                writeLog( "gw", "SRS rejected User! Retry Username : " .  $this->get('USERNAME') ." ". json_encode($this->tried_users));
                return $this->deliver($pkg);
            }
            writeLog( "notice", "CODE #{$code} From all SRS's. ". json_encode($pkg));
        }

        return (int)$code;
    }

    private function wrapPackage()
    {
        $msg = stripslashes($this->get('MESSAGE_TEXT'));
        $msg = str_replace("`","'",$msg);
        $msg = str_replace("�","'",$msg);
        $msg = str_replace("'","'",$msg);
        $msg = str_replace("\"","'",$msg);
        $msg = str_replace("\'","'",$msg);
        $msg = preg_replace("/\\+'/", "'", $msg);
        $this->set('MESSAGE_TEXT', $msg);

        $pkg = array();
        foreach($this->PARAMS as $key=>$val) { $pkg[] = $key ."=". urlencode($val); }

        return $pkg;
    }

    function send()
    {
        if(!$this->URL)
            return errors::undefined_gateway;

        $pkg = $this->wrapPackage();

        $send_start = microtime(true);

        $code = $this->deliver($pkg);

        $send_end = microtime(true);

        $benchmark = number_format( ($send_end - $send_start), 3);

        if( $code == errors::success )
        {
            writeLog( "sms", "{$code} ][ {$this->URL}?".implode("&", $pkg) ." ][ took {$benchmark}sec" );
        }
        else
        {
            writeLog( "error", "{$code} ][ {$this->URL}?".implode("&", $pkg) ." ][ took {$benchmark}sec" );
        }


        return $code;
    }
}

function getSRSURL($shortcode)
{
    global $SMSC_USERNAME;


    $APPS_SRS = array(
        #GHANA
    1901,1902,1903,1906,1908,1910,1944,1946,1940,1443
        #UK
    ,81055
        #KENYA
    ,4545,5051,8081,4884,5525,5535,33100,5595,3545,5828,30828,8838,3339,6141,6191,30191,30191
        #TANZANIA
    ,15363,15375
        #MALAWI
    ,8080,7878,7979
        #NIGERIA
    ,3336,35969,3995,5682,8838
        #UGANDA
    ,6655
        #UK & USA
    ,80708,66400,80608,60609,60608,60607,80023,80087,80110,84433,66220,66800,85900,28444,33100,33500,28444,65055
        #NZ
    ,2008,840,98998,841,98666,4774,4775,98638,345, 4878,9200,4879,98890,9201,98637
        #CANADA
    ,33000, 55000, 77000, 88000, 88088
        #SOUTH AFRICA - moved 24th March 2010 @ 9:20pm
    ,31993,40991,31996,36963,31356,42993,42990,42994,31403,31354,31357,31355,32995,36300,36303,31945,31600,37629,40994,42992,37265,31359,36969,37468,37588,31949,32900,31947,38900,38095,41991,41994,38094,38093,31999,40202,39881,41371,41372,41565,41291,43292,43293
        #AUSTRALIA
    ,193535,19777800,19900500,19900600,19990777,19994878
    );

    $TAS_SRS = array(193030,61428288225,61433694974,61428519750);

    $SMSC_SRS = array();

    $HATCH_SRS = array(39887,43448,31602,36308,6121,40849,43741,43486,43022,43128,33112,6181,31409,31995,20019,43493,43487,41572,41573,43392,41662,8067,43054,37467,43157,43295,43492);
 
    if( in_array($shortcode, $TAS_SRS) ) return SRS_ENDPOINT_TAS;

    if( in_array($shortcode, $HATCH_SRS) ) return SRS_ENDPOINT_HATCH;

    if( in_array($shortcode, $APPS_SRS) || $SMSC_USERNAME == 'mobileapps.any' ) return SRS_ENDPOINT_APPS;

    if( in_array($shortcode, $SMSC_SRS) ) return SRS_ENDPOIN_SMSC;

    return SRS_ENDPOINT_APPS;
}
