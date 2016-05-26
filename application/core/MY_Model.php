<?php
    /**
     * Created by John Huseinovic
     * Date: 5/11/12
     * Time: 4:05 PM
     */
class My_Model extends CI_Model
{
    var $Frequency;
    var $Subscription_Flow = array('mobile'=>SUBSCRIBE_FLOW_PIN, 'web'=>SUBSCRIBE_FLOW_PIN);
    var $Terms = array('short'=>null, 'long'=>null);
    var $Pin_Message;
    var $Content_Costs = array('Covertones'=>100, 'Polyphonics'=>100, 'Cover_Full_Tracks'=>200, 'True_Tones'=>200, 'Games'=>200, 'Videos'=>200, 'Animations'=>100, 'Wallpapers'=>50 );
    var $Wap_Optin_URL = "";

    protected $Host;
    protected $Country;
    protected $Product;
    protected $CountryNumber;


    function __construct()
    {
        parent::__construct();

    }

    function load(&$host, &$country, $countrynum=0, $productid)
    {

        $this->Host = &$host;
        $this->Country = &$country;
        $this->CountryNumber = $countrynum;

        if(!isset($country->id))
            return false;

        $query = $this->db->get_where('hosts_products', array('hid'=>$host->id, 'cid'=>$country->id, 'cnum'=>(int)$countrynum, 'pid'=>$productid));

        $products = $this->db->get_where('products', array('path'=>$productid));
        $this->Product = $products->row(0);

        if( $query->num_rows() == 0)
        {
            return false;
        }

        $rs = $query->row(0);

        $conf = json_decode($rs->conf);

        $this->id = $rs->id;


        foreach($conf as $key=>$val)
        {
            $this->$key = $val;
        }
    }

    function save()
    {

        $tmp = clone $this;
        unset($tmp->Host, $tmp->Country, $tmp->CountryNumber, $tmp->ProductID);

        if( isset($tmp->id) )
            unset($tmp->id);

        if( isset($tmp->Error) )
            unset($tmp->Error);

        $data = array();
        $data['hid'] = $this->Host->id;
        $data['cid'] = $this->Country->id;
        $data['pid'] = $this->Product->path;
        $data['cnum'] = $this->CountryNumber;
        $data['conf'] = json_encode($tmp);


        if( isset($this->id) )
        {
            #log_message('info', "update hosts_products #{$this->id} .. ".print_r($tmp, true));
            $this->db->update('hosts_products', $data, array('id'=>$this->id));

        }
        else
        {
            #insert
            #log_message('info', "insert hosts_products .. ".print_r($tmp, true));
            $this->db->insert('hosts_products', $data);

        }
    }

    function getMessageFrequency()
    {

        $freq = $this->safe_get('Frequency');
        if(!isset($freq))
            show_error("Billing frequency not configured for <b>". $this->Product->name ."</b>");

        return $freq;
    }

    private function getTerms($type='short')
    {
        $terms = $this->safe_get('Terms');
        if( !is_array($terms) && !is_object($terms) ) return NULL;
        if( is_array($terms) && !isset($terms[$type] ) ) return NULL;
        if( is_object($terms) && !isset($terms->$type ) ) return NULL;

        if( is_array($terms) )
            return $terms[$type];

        if( is_object($terms) )
            return $terms->$type;

    }

    function getShortTerms($product, $description)
    {
        $output = $this->getTerms('short');
        $output = str_replace("%SERVICE_DESCRIPTION%", $description, $output);
        $output = str_replace("%PRODUCT_NAME%", $product, $output);
        $output = str_replace("%SERVICE_NAME%", $this->safe_get('name'), $output);
        $output = str_replace("%SITE_NAME%", $this->safe_get('sitename'), $output);

        return $output;
    }

    function getFullTerms()
    {
        $output = $this->getTerms('long');

        return $output;
    }

    function getSubscriptionFlow()
    {
        $platform = $this->agent->is_mobile()? "mobile":"web";
        $flow = $this->safe_get('Subscription_Flow');

        if(!isset($flow->$platform))
            return false;

        return $flow->$platform;
    }

    function getSignupPinMessage($keyword,$msisdn, $network="premium", $attr=NULL,$shortcode)
    {


        $msg = $this->safe_get('Pin_Message');

        switch( $this->getSubscriptionFlow() )
        {
            case SUBSCRIBE_FLOW_PIN:
                $pin = $this->generate_pin_number();
                $msg = str_replace("[INSTRUCTIONS]", "Enter the PIN \"{$pin}\" ", $msg);
                break;

            case SUBSCRIBE_FLOW_VIA_WAP:
                $this->load->helper('shorturl');

                $key = $this->encrypt->encode("{$msisdn}:{$network}");
                $link = 'http://'.$this->Host->hostname.'/'.$this->Product->path.'/validatepin/'.$this->Country->iso.$this->CountryNumber.'/'.$keyword.'/?key='.urlencode($key);

                $link = getShortURL($link);

                $msg = str_replace("[INSTRUCTIONS]", "Click on the link {$link} ", $msg);
                break;

            case SUBSCRIBE_FLOW_MO_MSG:
                $msg = str_replace("[INSTRUCTIONS]", "Simply reply {$keyword} to {$shortcode}", $msg);
                break;

            default:
                $msg = str_replace("[INSTRUCTIONS]", "", $msg);
        }

        $msg = preg_replace("/\s+/", " ", $msg);

        return $msg;
    }

    function getMSISDN($mobile)
    {
        $mobile = preg_replace("/[^0-9]/","",$mobile);

        if( substr($mobile, 0, strlen($this->Country->prefix)) == $this->Country->prefix )
            $mobile = substr($mobile, strlen($this->Country->prefix));

        if( substr($mobile, 0, 1) == "0" )
            $mobile = substr($mobile, 1);

        return $this->Country->prefix . $mobile;
    }

    function getProductName()
    {
        return $this->Product->name;
    }

    function safe_get($index)
    {
        #log_message('debug', "SafeGet {$index} : ". $this->Config[$index] );
        if( !isset($this->$index) ) return NULL;
        return $this->$index;
    }

    protected function generate_pin_number()
    {
        $pin = rand(1000,9999);
        $this->session->set_userdata('SIGNUP_PIN', $pin);
        return $pin;
    }

    function check_pin_input($input)
    {
        $pin = $this->session->userdata('SIGNUP_PIN');
        return ( $pin == $input );
    }


}