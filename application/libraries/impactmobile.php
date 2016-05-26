<?php
/**
 * Created by John Huseinovic
 * Date: 7/11/12
 * Time: 2:40 PM
 */
class impactmobile
{
    private $SVCID = 138;
    private $CI;
    var $Error;

    function __construct()
    {
        $this->CI = &get_instance();
    }

    function log($msg)
    {
        log_message('info', "{$_SERVER['HTTP_HOST']} [IMPACTMOBILE] {$msg}");
    }

    function err($msg)
    {
        $this->Error = $msg;

        log_message('error', "{$_SERVER['HTTP_HOST']} [IMAPCTMOBILE] {$msg}");
        return false;
    }

    function lookup($return_url)
    {
        $this->GetToken( "http://". $_SERVER['HTTP_HOST'] . $return_url);
    }

    function validate()
    {
        $token = $this->CI->input->get('token');

        $this->log("Validate token {$token}");

        $status = $this->Identity($token);

        $segs = $this->CI->uri->segment_array();

        # replace method (currently "lookup") to "index"
        $segs[2] = "index";

        $uri = implode("/", $segs);

        $this->log("Redirect user to {$uri}");
        redirect( $uri );
    }

    private function get_cookie_name()
    {
        return md5('CANADA_MSISDN');
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
        $country = $this->CI->config->item('canada', 'countries');

        if( strlen($msisdn) < $country['min-length']) return false;
        if( strlen($msisdn) > $country['max-length']) return false;

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

    private function GetToken($return_url)
    {
        $this->log("GetToken {$return_url}");

        if( $this->check_cookie() ) return true;

        $this->CI->session->unset_userdata('MSISDN');

        $request = "http://wapsvcs1.jumptxt.com/wapsis/discover?svcid=". $this->SVCID ."&url=". urlencode($return_url) ."&rnd=". uniqid();

        $this->log("Redirect User to {$request}");

        redirect($request);
    }

    private function Identity($token)
    {
        $request = "https://wapsvcs1.jumptxt.com/wapsis/identity?svcid=". $this->SVCID ."&token=". $token;

        $identity = new SimpleXMLElement($request,null,true);

        if( isset($identity->status) )
        {
            $attributes = $identity->status->attributes();

            $this->CI->session->set_userdata('MSISDN_DETECTION_PERFORMED', (string)$attributes['code']);

            if($attributes['code'] < 0)
            {
                switch( $attributes['code'] )
                {
                    case "-1": return $this->err("Invalid SVCID"); break;
                    case "-2": return $this->err("Unauthorized redirect URL (not whitelisted)"); break;
                    case "-3": return $this->err("Unable to determine Subscriber"); break;
                    case "-4": return $this->err("Invalid Token"); break;
                    case "-5": return $this->err("Token Expired"); break;
                    case "-6": return $this->err("Unauthorized Carrier"); break;
                }
                return $this->err("Unknown error code!");
            }
            else
            {
                if( !isset($identity->msisdn) )	return false;
                if( $identity->msisdn < 1 )	return false;
                $msisdn = (string)$identity->msisdn;

                if( $this->is_valid_msisdn($msisdn) )
                {
                    $this->CI->session->set_userdata('MSISDN', $msisdn);
                    $this->set_cookie_msisdn($msisdn);
                    return true;
                }
                return $this->err("Invalid MSISDN returned!");
            }

        }
        return $this->err("Status not returned!");
    }
}
