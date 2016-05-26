<?php
/**
 * Created by John Huseinovic
 * Date: 7/11/12
 * Time: 2:40 PM
 */
class integrat
{
    private $CI;
    var $Error;

    function __construct()
    {
        $this->CI = &get_instance();
    }

    function log($msg)
    {
        log_message('info', "{$_SERVER['HTTP_HOST']} [INTEGRAT] {$msg}");
    }

    function err($msg)
    {
        $this->Error = $msg;

        log_message('error', "{$_SERVER['HTTP_HOST']} [INTEGRAT] {$msg}");
        return false;
    }

    function lookup($return_url)
    {
        $SITE_TITLE = $this->CI->siteconfig->safe_get('sitename');

        #$url = file_get_contents("http://www.mobivate.com/smsgw/integrat.php?KEY=MAA0100000000085&HOST={$_SERVER['HTTP_HOST']}&HEADER=/images/header.jpg&SERVICE=". urlencode($SITE_TITLE) ."&DONT_REDIRECT");

        # format=". (strtolower($page->Format) == "wml"? strtolower($page->Format):"xhtml") ."
        $accept = $this->CI->input->server('HTTP_ACCEPT');
        $format = "wml";
        if( strstr($accept, "html") == true ) $format = "xhtml";

        $integrat = "http://wap.integrat.co.za/api.php?clientcode=MOBIVATE&enctype=none&format={$format}&returnurl=". urlencode("http://". $_SERVER['HTTP_HOST'] . $return_url ."?");

        $this->log("Redirect user to {$integrat}");
        redirect($integrat);
    }

    function validate()
    {

        $segs = $this->CI->uri->segment_array();

        # replace method (currently "lookup") to "index"
        $segs[2] = "index";

        $uri = implode("/", $segs);

        if($this->extract_number())
        {
            $this->log("Redirect user to {$uri}");
            redirect( $uri );
        }
        else
        {
            $this->log("Redirect user to {$uri}");
            redirect( $uri );
        }


    }

    private function extract_number()
    {
        $msisdn = $this->CI->input->get('msisdn');


        if( $this->is_valid_msisdn($msisdn) )
        {
            $this->CI->session->set_userdata('MSISDN', $msisdn);
            $this->set_cookie_msisdn($msisdn);

            return true;
        }

        return $this->err("Invalid MSISDN returned!");
    }

    private function get_cookie_name()
    {
        return md5('SOUTHAFRICA_MSISDN');
    }

    private function get_cookie_msisdn()
    {
        $encr_msisdn = $this->CI->input->cookie( $this->get_cookie_name() );
        if( $encr_msisdn )
        {
            $msisdn = $this->CI->encrypt->decode($encr_msisdn);
            return $msisdn;
        }
        return false;
    }

    private function set_cookie_msisdn($msisdn)
    {
        $encr_msisdn = $this->CI->encrypt->encode($msisdn);
        $cookie = array(
            'name'   => $this->get_cookie_name(),
            'value'  => $encr_msisdn ,
            'expire' => '86500',
            'domain' => '.'. $_SERVER['HTTP_HOST'],
            'path'   => '/',
            'prefix' => '',
            'secure' => FALSE
        );

        $this->CI->input->set_cookie($cookie);

    }

    private function is_valid_msisdn(&$msisdn)
    {
        $msisdn = preg_replace("/[^0-9]/","", $msisdn);
        $country = $this->CI->Country;

        if( strlen($msisdn) < $country->minlength) return false;
        if( strlen($msisdn) > $country->maxlength) return false;

        return true;
    }

    private function check_cookie()
    {
        $msisdn = $this->get_cookie_msisdn();
        if( $msisdn && $this->is_valid_msisdn($msisdn) )
        {
            $this->log("Found MSISDN in Cookie {$msisdn}");
            $this->CI->session->set_userdata('MSISDN', $msisdn);
            $this->CI->session->set_userdata('MSISDN_DETECTION_PERFORMED', 'cookie');
            return true;
        }
        return false;
    }

    public function network_lookup($msisdn)
    {
        require_once( dirname(__FILE__) ."/smsgw/number_lookup.php");

        $result = number_lookup::south_africa($msisdn);

        if($result == "UNKNOWN")
            $result = "premium";

        return $result;

    }


}
