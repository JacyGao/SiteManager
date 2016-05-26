<?php
/**
 * Created by John Huseinovic
 * Date: 5/11/12
 * Time: 4:05 PM
 */
class My_Controller extends CI_Controller
{
    var $DocumentRoot;
    var $Description;

    var $CountryKey;
    var $Country;
    var $Keyword;
    var $siteconfig;
    var $srs;
    var $CountryIsRequired = true;

    function __construct($country_required=true)
    {
        parent::__construct();

        # RECORD any queries in the url into the session QUERY_STRING;
        $query = $this->input->get();
        if( sizeof($query) > 0 && !$this->session->userdata('QUERY_STRING') )
        {
            log_message('info', 'Store Query '. json_encode($query));
            $this->session->set_userdata('QUERY_STRING', $query);
        }

        log_message('debug', $this->agent->agent_string() );

        $this->CountryIsRequired = $country_required;

        $this->setDocumentRoot();

        $this->setCountryKey();

        if( in_array($this->uri->segment(1), array("portal", "splash")) )
        {
            if( in_array($this->uri->segment(2), array("artist","image")) )
                $this->CountryIsRequired = false;
        }

        if(!$this->loadCountry() && $this->CountryIsRequired)
            show_error('Unknown country!');


        $this->setKeyword();

        if( !isset($this->CountryNotRequired) )
            $this->loadSiteConfig();

        if( get_class($this) != "Welcome" )
            $this->loadProductModel();

        $this->load->library('srs');

        if ( !$this->session->userdata('LandedOnPage') )
            $this->session->set_userdata('LandedOnPage', $this->uri->uri_string() );

    }

    private function setDocumentRoot()
    {
        $this->DocumentRoot = dirname($_SERVER['SCRIPT_NAME']);
        if($this->DocumentRoot == "/")
            $this->DocumentRoot = "";

        log_message('debug', "Set DocumentRoot : '{$this->DocumentRoot}'");
    }

    private function setCountryKey()
    {
        if($this->uri->total_segments() < 2)
            $this->CountryKey = "undefined";
        elseif($this->uri->total_segments() == 2)
            $this->CountryKey = $this->uri->segment(2);
        else
            $this->CountryKey = $this->uri->segment(3);

        log_message('debug', "Set CountryKey : '{$this->CountryKey}'");
    }

    private function loadCountry()
    {

        if( $this->CountryKey )
        {
            $iso = preg_replace("/[^a-z]/","", strtolower($this->CountryKey));

            if( !trim($iso) )
            {
                log_message('error', 'CountryKey Not specified, could not load Country Config Data');
                return false;
            }

            $this->load->model('Country_model', 'Country');

            if( $this->Country->load($iso) )
            {
                log_message('debug', 'Loaded Country Configuration : '. $this->Country->name);
                return true;
            }
            else
            {
                log_message('error', 'Did not find Country Configuration for : '. $iso);
                return false;
            }
        }

        log_message('error', 'CountryKey Not specified, could not load Country Config Data');
        return false;
    }

    private function setKeyword()
    {
        if($this->uri->total_segments() < 3)
            $this->Keyword = isset($this->Product)? "gen".$this->Product : "none";
        elseif($this->uri->total_segments() == 3)
            $this->Keyword = $this->uri->segment(3);
        else
            $this->Keyword = $this->uri->segment(4)? $this->uri->segment(4) : "gen".$this->Product;

        log_message('debug', "Set Keyword : '{$this->Keyword}'");
    }

    private function loadSiteConfig()
    {
        $this->load->library('siteconfig', array('country'=>$this->Country, 'countryKey'=>$this->CountryKey));

        if( $this->CountryIsRequired && $this->CountryKey!="undefined" )
        {

            if( $this->siteconfig->isLoaded() )
            {
                log_message('debug', 'Loaded Country Specific Site Configuration : '. $this->siteconfig->safe_get('Sitename'));
                $this->load->model("Traffic_Model", "Traffic");
                $trafficLoaded = $this->Traffic->load($this->siteconfig->getConfigID(), $this->Keyword);
//                if(!$trafficLoaded)
//                    log_message('debug', 'Did not load Traffic Configuration : '. $this->siteconfig->safe_get('Sitename'));
//                else
//                    log_message('debug', 'Loaded Traffic Configuration : '. $this->siteconfig->safe_get('Sitename'));
            }
            else
            {
                show_error("Country not configured");
            }

        }
        else
        {
            #$this->load->library('siteconfig');
            log_message('debug', 'Loaded Generic Site Configuration : '. $this->siteconfig->safe_get('Sitename'));
        }
    }

    private function loadProductModel()
    {
        $this->Product = $this->uri->segment(1);

        $this->load->model("{$this->Product}_model", "Product_model");


        $this->Product_model->load($this->Host, $this->Country, $this->siteconfig->CountryNum, $this->Product);

    }

    protected function Display($page,$data=array())
    {
        if( !isset($this->DocumentRoot) )
            show_error("Controller incomplete, missing DocumentRoot", 500);

        if( !isset($this->Product) )
            show_error("Controller incomplete, missing Product", 500);

        if( !isset($this->Description) )
            show_error("This Product is not available at this moment.<p style=\"color:#CCCCCC\">(DESCRIPTION NOT AVAILABLE / NO SUBSCRIPTION FLOW)</p>", 500);


        $data['DocumentRoot'] = $this->DocumentRoot;
        $data['ProductPath'] = $this->Product;
        $data['Shortcode'] = $this->siteconfig->getShortcode();
        $data['Pricing'] = $this->siteconfig->getPricing();
        $data['Country'] =  $this->CountryKey;
        $data['CountryName'] = $this->Country->name;
        $data['Keyword'] = $this->Keyword;
        $data['Header_Note'] = $this->siteconfig->getHeaderNote($this->Product);
        $data['Copyright'] = "Mobivate &copy; ". date("Y");

        $data['MobileExample'] = $this->Country->example;
        $data['MaxInputLength'] = $this->Country->maxlength;
        $data['Placeholder'] = $this->Country->placeholder;

        if( !isset($data['Terms_And_Conditions']) )
            $data['Terms_And_Conditions'] = $this->Product_model->getShortTerms($this->Product, $this->Description);

        $data['TITLE'] = $this->Host->sitename ." - ". $this->Product_model->getProductName();

        #echo "<!-- ". $this->agent->platform() ."||". $this->agent->mobile() ."||". $this->agent->browser() ."||".  $this->agent->agent_string() ." -->\n";

        if ($this->agent->is_mobile())
        {

            $data['DOCTYPE'] = doctype();
            $data['CSS'] = link_tag('css/mobile.css');
            $data['CSS'] .= link_tag('css/mobile.css');

            $data['META'] = "";

            //if( $this->agent->is_mobile('iphone') || $this->agent->is_mobile('ipad') || $this->agent->is_mobile('Android') || $this->agent->is_mobile('windows') || $this->agent->is_mobile('htc') )
            if(preg_match('/(iphone|ipad|android|windows)/i', $_SERVER['HTTP_USER_AGENT']))
            {
                $data['WRAPPER_START'] = "<body onload=\"window.scrollTo(0,1);\">";
                $data['WRAPPER_END'] = "</body></html><!-- Code produced by Mobivate Site Manager -->";

                $template = "{$this->Product}/mobile/smartphone/{$page}";
            }
            elseif( strstr( $this->input->server('HTTP_ACCEPT'), 'html') == true)
            {
                $data['WRAPPER_START'] = "<body>";
                $data['WRAPPER_END'] = "</body></html><!-- Code produced by Mobivate Site Manager -->";

                $template = "{$this->Product}/mobile/html/{$page}";
            }
            else # if( strstr( $this->input->server('HTTP_ACCEPT'), 'wml') == true)
            {
                $data['WRAPPER_START'] = '<?xml version="1.0"?><!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN"
                "http://www.wapforum.org/DTD/wml_1.1.xml" ><wml>';
                $data['WRAPPER_END'] = "</wml>";

                $template = "{$this->Product}/mobile/wml/{$page}";
            }

        }
        else
        {
            $template = "{$this->Product}/web/{$page}";

            $data['DOCTYPE'] = doctype('html5');

            $data['WRAPPER_START'] = "<body>";
            $data['WRAPPER_END'] = "</body></html><!-- Code produced by Mobivate Site Manager -->";

            $meta = array();
            $meta[] = array('name' => 'robots', 'content' => 'no-cache');
            $meta[] = array('name' => 'description', 'content' => 'This is a subscription service. '. $this->Product_model->getProductName() .'. '. $this->siteconfig->getPricing());
            $meta[] = array('name' => 'keywords', 'content' => $this->Product_model->getProductName() .','. $this->siteconfig->getShortcode());

            if ($this->agent->accept_charset('utf-8'))
                $meta[] = array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv');

            $meta[] = array('name' => 'Copyright', 'content' => 'Mobivate limited (www.mobivate.com)');
            $data['META'] = meta($meta);
        }

        #echo "<!-- Template: {$template} -->\n";
        #$header = $this->parser->parse('portal/web/inc_header.php', $data, true);
        #$content = $this->parser->parse($template, $data, true);
        #$footer = $this->parser->parse('portal/web/inc_footer.php', $data, true);
        #echo $header . $content . $footer;

        $this->load->model('Traffic_model','Traffic');

        log_message('info', "Displaying page using {$template} for ". $this->agent->agent_string() );

        if(isset($this->Traffic))
        {
            if($this->session->userdata('COUNTED_VISITOR'))
                $this->Traffic->increment('pageviews');
            else
            {
                $this->Traffic->increment( array('visitors', 'pageviews') );
                $this->session->set_userdata('COUNTED_VISITOR', true);
            }
        }

        // Enable Profile if the site is shown on Staging Server :)
        $this->output->enable_profiler( $this->siteconfig->IsOnStagingServer );

        return $this->parser->parse($template, $data);
    }

    public function index()
    {
        $this->_index();
    }

    protected function _index($data=array())
    {
        $this->number_detection();

        $this->Display( 'index', $data);
    }

    protected function number_detection()
    {
        if( $this->input->get('RESET') )
        {
            log_message('info', 'Reset Called, Unset userdata MSISDN_DETECTION_PERFORMED');
            $this->session->unset_userdata('MSISDN_DETECTION_PERFORMED');
        }


        # check if mobile device
        if( $this->agent->is_mobile() )
        {
            log_message('info', "{$_SERVER['HTTP_HOST']} ". $this->input->ip_address() ." is a Mobile Client (". $this->agent->mobile() .")" );

            # check if msisdn detection is required
            if( $this->siteconfig->safe_get('Mobile_Detection') )
            {
                log_message('info', "{$_SERVER['HTTP_HOST']} Config requires MSISDN Detection!" );

                # check if the detection hasn't been performed already
                if( !$this->session->userdata('MSISDN_DETECTION_PERFORMED') )
                {
                    log_message('info', "{$_SERVER['HTTP_HOST']} MSISDN hasn't been performed yet!" );

                    # mark the detection as performed so we don't do it again when we are here!
                    $this->session->set_userdata('MSISDN_DETECTION_PERFORMED',true);

                    # perform lookup for different countries

                    $return_url = "{$this->DocumentRoot}/{$this->Product}/lookup/{$this->CountryKey}/{$this->Keyword}";

                    if( strstr($this->CountryKey, CANADA) == true )
                    {
                        log_message('info', "{$_SERVER['HTTP_HOST']} ". $this->input->ip_address() ." Start Lookup via ImpactMobile");
                        $this->load->library('impactmobile');
                        $this->impactmobile->lookup( $return_url );

                    }

                    if( strstr($this->CountryKey, SOUTH_AFRICA) == true )
                    {
                        log_message('info', "{$_SERVER['HTTP_HOST']} ". $this->input->ip_address() ." Start Lookup via Integrat");
                        $this->load->library('integrat');
                        $this->integrat->lookup( $return_url );
                    }
                }
                else
                    log_message('info', "{$_SERVER['HTTP_HOST']} MSISDN has been performed already! (". $this->session->userdata('MSISDN') .")" );
            }
        }
    }

    public function lookup()
    {
        if( strstr($this->CountryKey, CANADA) == true )
        {
            $this->load->library('impactmobile');
            $this->impactmobile->validate();

        }

        if( strstr($this->CountryKey, SOUTH_AFRICA) == true )
        {
            $this->load->library('integrat');
            $this->integrat->validate();
        }
    }

    public function loadnext()
    {
        $page = $this->uri->segment(5);

        $data = array('next'=>$page);

        $this->Display( __FUNCTION__, $data);
    }

    private function get_msisdn($mobile)
    {
        $mobile = preg_replace("/[^0-9]/","", $mobile);

        if( substr($mobile, 0, 1) == "0")
            $mobile = substr($mobile, 1);

        $prefix = $this->Country->prefix;

        if( substr($mobile, 0, strlen($prefix)) != $prefix )
            $msisdn = $prefix . $mobile;
        else
            $msisdn = $mobile;

        if( strlen($msisdn) < $this->Country->minlength) return false;
        if( strlen($msisdn) > $this->Country->maxlength) return false;

        return $msisdn;
    }

    protected function startSubscription($mobile)
    {
        $result = $this->realStartSubscription($mobile);

        if( $result !== true )
            return $this->sorry($result);

        $this->postSubscription();

    }

    protected function postSubscription()
    {

        $flow = $this->Product_model->getSubscriptionFlow();


        switch( $flow )
        {

            case SUBSCRIBE_FLOW_PIN:
                if ($this->agent->is_mobile())
                {
                    redirect("{$this->DocumentRoot}/{$this->Product}/validatepin/{$this->CountryKey}/{$this->Keyword}");
                }
                else
                {
                    redirect("{$this->DocumentRoot}/{$this->Product}/loadnext/{$this->CountryKey}/{$this->Keyword}/validatepin");
                }
                break;

            case SUBSCRIBE_FLOW_DOI:
                $this->Traffic->increment('subscribers');

                if ($this->agent->is_mobile())
                {
                    redirect("{$this->DocumentRoot}/{$this->Product}/doi/{$this->CountryKey}/{$this->Keyword}");
                }
                else
                {
                    redirect("{$this->DocumentRoot}/{$this->Product}/loadnext/{$this->CountryKey}/{$this->Keyword}/doi");
                }
                break;

            case SUBSCRIBE_FLOW_DIRECT_MALAWI:
                # TODO : implement SUBSCRIBE_FLOW_DIRECT_MALAWI!
                break;

            case SUBSCRIBE_FLOW_MO_MSG:
            case SUBSCRIBE_FLOW_VIA_WAP:

                if ($this->agent->is_mobile())
                {
                    redirect("{$this->DocumentRoot}/{$this->Product}/checksms/{$this->CountryKey}/{$this->Keyword}");
                }
                else
                {
                    redirect("{$this->DocumentRoot}/{$this->Product}/loadnext/{$this->CountryKey}/{$this->Keyword}/checksms");
                }
                break;


        }
    }

    protected function realStartSubscription($mobile, $network="premium")
    {

        $flow = $this->Product_model->getSubscriptionFlow();

        $msisdn = $this->get_msisdn($mobile);

        if( !$msisdn )
            return 'Please enter valid mobile number!';


        $this->session->set_userdata('MSISDN', $msisdn);
        $this->session->set_userdata('NETWORK', $network);

        if( $this->Country->iso == SOUTH_AFRICA )
        {
            if( $this->siteconfig->safe_get('Network_Detection') )
            {
                $this->load->library("integrat");
                $network = $this->integrat->network_lookup($msisdn);

                $this->session->set_userdata('NETWORK', $network);

                if($network == "VODACOMSA")
                {
                    $flow = SUBSCRIBE_FLOW_DOI;
                    $this->Product_model->Subscription_Flow->mobile = $flow;
                    $this->Product_model->Subscription_Flow->web = $flow;

                }
            }
        }


        switch( $flow )
        {
            case SUBSCRIBE_FLOW_NONE:
                # The Subscription is DISABLED!
                return "The subscriptions are not allowed on this website!";
                break;

            case SUBSCRIBE_FLOW_MO_MSG:
            case SUBSCRIBE_FLOW_PIN:
            case SUBSCRIBE_FLOW_VIA_WAP:
                return $this->sendpin();
                break;


            case SUBSCRIBE_FLOW_DOI:
            case SUBSCRIBE_FLOW_HIDDEN:
                return $this->subscribe();
                break;

            case SUBSCRIBE_FLOW_DIRECT_MALAWI:
                # TODO : implement SUBSCRIBE_FLOW_DIRECT_MALAWI!
                return "Not yet implemented!";
                break;


            case SUBSCRIBE_FLOW_MO:
                # NOTHING TO DO HERE!!! user sent in an MO to PSS!
                return "Invalid request!";
                break;

            default:
                return "Undefined subscription flow requested!";
                break;

        }
    }

    protected function sendpin($attr=null)
    {

        $shortcode = $this->siteconfig->getShortcode();

        $msisdn = $this->session->userdata('MSISDN');
        $network = $this->session->userdata('NETWORK');

        //save pixel
        $this->load->model('Pixel_model', 'Pixels');
        $this->Pixels->init( $this->siteconfig , $this->Keyword );

        $this->Pixels->save($msisdn);

        $message = $this->Product_model->getSignupPinMessage($this->Keyword, $msisdn, $network, $attr,$shortcode);

        // Jacy, Are you serious with this shit?????
        // if (strpos($msisdn,'254') !== false) {
        // What about +61-793-254-11111? What do you think happens with that message?


        // Send the message to SRSGW with provider 'default'. SRSGW will route the message to correct SRS Username/Password!
        $response = $this->srs->free_mt($shortcode, $msisdn, $message);

        if ($response === true) return true;

        return $this->srs->get_error($response);
    }

    protected function sendMo($attr=null)
    {

        $shortcode = $this->siteconfig->getShortcode();

        $msisdn = $this->session->userdata('MSISDN');
        $network = $this->session->userdata('NETWORK');

        $message = $this->Product_model->getSignupPinMessage($this->Keyword, $msisdn, $network, $attr);

        $response = $this->srs->free_mt($shortcode, $msisdn, $message);

        if ($response === true) return true;

        return $this->srs->get_error($response);
    }

    public function validatepin()
    {
        $this->load->helper(array('form', 'url'));

        $pin = $this->input->get_post('pin');
        $key = $this->input->get_post('key');
        $subscribe = false;
        $msisdn = NULL;
        $network = NULL;

        if($key && !$pin)
        {
            $decrypted = $this->encrypt->decode($key);

            $arr = explode(":", $decrypted);

            $msisdn = $arr[0];

            if(isset($arr[1]))
                $network = $arr[1];

            if($msisdn)
            {
                $this->session->set_userdata('MSISDN', $msisdn);
                $this->session->set_userdata('NETWORK', $network);
                $subscribe = true;
            }


        }
        elseif($pin)
        {
            $subscribe = $this->Product_model->check_pin_input($pin);
        }

        if( $subscribe )
        {
            $result = $this->subscribe();
            if( $result )
            {

                if ($this->agent->is_mobile())
                {
                    redirect("{$this->DocumentRoot}/{$this->Product}/thankyou/{$this->CountryKey}/{$this->Keyword}");
                }
                else
                {
                    redirect("{$this->DocumentRoot}/{$this->Product}/loadnext/{$this->CountryKey}/{$this->Keyword}/thankyou");
                }
            }
            else
            {
                $this->sorry($result);
            }
        }
        else
        {
            $data = array();
            $this->Display( __FUNCTION__, $data);
        }
    }

    protected function subscribe()
    {

        $sub = &$this->Subscription_model;

        $shortcode = $this->siteconfig->getShortcode();
        $msisdn = $this->session->userdata('MSISDN');
        $network = $this->session->userdata('NETWORK');
        $keyword = $this->Keyword;

        if(substr($msisdn,0,2) == 27){

            if(strtolower($network) == "VODACOM" || strtolower($network) == "VODACOMSA")
            {
                $keyword = $keyword;
            }
            else
            {
                $keyword = "doi".$this->Keyword;
            }
        }

        $subscribed = $sub->Subscribe($shortcode,$msisdn,$keyword,$network);

        if($sub->Error == ERROR_UNKNOWNKEYWORD)
        {
            $_kw = $keyword;
            $keyword = $this->siteconfig->getDefaultKeyword();

            if($keyword)
            {
                log_message("info", "{$_kw} is an invalid keyword! Using default keyword {$keyword}");
                $subscribed = $sub->Subscribe($shortcode,$msisdn,$keyword,$network);
            }
        }

        if( $subscribed )
        {
            $this->load->model('Pixel_model', 'Pixels');
            $this->Pixels->init( $this->siteconfig , $this->Keyword );

            $this->Pixels->save($msisdn);

            if (method_exists($this->Product_model, 'ActivateNewPin'))
                $this->Product_model->ActivateNewPin( $msisdn );

            $this->Traffic->increment('subscribers');

            $scheduled =  $this->session->userdata('SCHEDULED_MESSAGES');
            if( is_array($scheduled) )
            {
                foreach($scheduled as $msg)
                {
                    if( !isset($msg['type'])) $msg['type'] = "free";

                    switch($msg['type'])
                    {
                        case FREE_MESSAGE:
                            break;

                        case BILL_MESSAGE:
                            break;
                    }
                }
            }

            return true;
        }
        else
        {
            return $sub->Error;
        }

    }

    public function about()
    {
        $data = array();
        $data['About_Us_Header'] = $this->siteconfig->getAboutUsHeader();
        $data['About_Us_Text'] = $this->siteconfig->getAboutUsText();

        $this->Display( __FUNCTION__, $data);
    }

    public function thankyou()
    {
        $this->load->model('Pixel_model', 'Pixels');
        $this->Pixels->init( $this->siteconfig , $this->Keyword );

        $data = array();
        $data['pixels'] = $this->Pixels->get(PIXELTYPE_HTML);

        $this->Display( __FUNCTION__, $data);
    }

    public function success()
    {
        $data = array();

        $this->Display( __FUNCTION__, $data);
    }

    public function loginsuccess()
    {

        $data = array();

        $this->Display( __FUNCTION__, $data);
    }


    public function pinsuccess()
    {

        $data = array();

        $this->Display( __FUNCTION__, $data);
    }

    public function pinfail()
    {

        $data = array();

        $this->Display( __FUNCTION__, $data);
    }

    public function checksms()
    {
        $this->load->model('Pixel_model', 'Pixels');
        $this->Pixels->init( $this->siteconfig , $this->Keyword );

        $data = array();
        $data['pixels'] = $this->Pixels->get(PIXELTYPE_HTML);

        $this->Display( __FUNCTION__, $data);
    }

    public function doi()
    {
        $this->load->model('Pixel_model', 'Pixels');
        $this->Pixels->init( $this->siteconfig , $this->Keyword );

        $data = array();
        $data['pixels'] = $this->Pixels->get(PIXELTYPE_HTML);

        $this->Display( __FUNCTION__, $data);
    }

    public function sorry($msg)
    {
        $data = array('ErrorMessage'=>$msg);
        $this->Display( __FUNCTION__, $data);
    }

    public function terms()
    {
        $data = array();
        $data['Long_Terms_And_Conditions'] = $this->Product_model->getFullTerms();

        $this->Display( __FUNCTION__, $data);
    }

    function info()
    {
        header("Content-type:text/plain");

        $seg = $this->uri->segment_array();
        print_r($seg);

        print_r($_SERVER);

    }

    function profiler()
    {
        $this->output->enable_profiler(TRUE);
    }

    function fakelogin()
    {
        $msisdn = $this->uri->segment(5);
        $this->session->set_userdata('MSISDN', $msisdn);
        $this->session->set_userdata('MSISDN_DETECTION_PERFORMED', 'FAKED');

        redirect("/". $this->uri->segment(1) ."/index/". $this->uri->segment(3)."/".$this->uri->segment(4));
    }

    function test()
    {
        $msisdn = "6143369474";

        $this->load->model('Pixel_model', 'Pixels');
        $this->Pixels->init( $this->siteconfig , $this->Keyword );

        $this->Pixels->save($msisdn);

    }

    public function mobivate_get_current_pin()
    {
        echo $this->session->userdata('SIGNUP_PIN');
    }

    public function url_sms($phone, $text)
    {
        if ( $this->agent->is_mobile() && preg_match('/(iphone|ipad)/i', $_SERVER['HTTP_USER_AGENT']) ) {
            
            $sms_link = "sms://$phone;body=".rawurlencode($text);

        } else {

            $sms_link = "sms://$phone?body=".rawurlencode($text);
            
        }

        return $sms_link;
    }

}