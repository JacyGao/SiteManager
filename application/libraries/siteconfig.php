<?php
/**
 * Created by John Huseinovic
 * Date: 5/11/12
 * Time: 5:22 PM
 */
class siteconfig
{
    var $Host;
    var $Country;
    private $Hostname;
    var $CountryNum = 0;
    private $CI;
    private $Config;
    private $ConfigFile;
    private $IsLoaded = false;
    var $IsOnStagingServer = false;

    function __construct($config=array())
    {
        $this->CI = &get_instance();

        $this->Hostname = strtolower($this->CI->input->server('HTTP_HOST'));

        $this->IsOnStagingServer = strstr($this->Hostname, ".s.mobivate.com") == true;

        if($this->IsOnStagingServer)
            $this->Hostname = str_replace(".s.mobivate.com","", $this->Hostname);

        $this->DocumentRoot = dirname($_SERVER['SCRIPT_NAME']);
        if($this->DocumentRoot == "/")
            $this->DocumentRoot = "";

        if( isset($config['country']) )
            $this->Country = &$config['country'];

        if( isset($config['countryKey']) )
        {
            $this->CountryNum = preg_replace('/[^0-9]/', '', $config['countryKey']);
        }

        $this->loadSitesCountryConfig($this->Country);
    }

    function loadSitesCountryConfig($country)
    {

        $this->CI->load->model('Config_model');

        if( isset($country->name))
            log_message('debug', 'Load Site config for country '. strtoupper($country->name) );

        $this->CI->load->model('Host_model', 'Host');

        if( !$this->CI->Host->load($this->Hostname) )
            show_error("This domain hasn't been configured yet!<br /><br /><span style=\"color:#444444; font-style:italic;\">Are you the administrator? If so, please add the domain to the hosts!</b></span>");


        $this->Config = &$this->CI->Config_model;

        if(  $this->Config->load( $this->CI->Host, $country, $this->CountryNum) )
        {
            $this->IsLoaded = true;
            return $this->Config;

        }
        else
            return false;

    }

    function isLoaded()
    {
        return $this->IsLoaded;
    }

    function getConfigID()
    {
        return isset($this->Config->id)? $this->Config->id : null;
    }

    function getShortcode()
    {
        return $this->safe_get('Shortcode');
    }

    function getDefaultKeyword()
    {
        return $this->safe_get('Default_Keyword');
    }

    function getPricing()
    {
        return $this->safe_get('Pricing');
    }

    function getTermsCheckbox($product)
    {
        $output = $this->safe_get('Checkbox');

        $output = str_replace("%TERMS_URL%", $this->DocumentRoot."/".$product."/terms/".$this->Country->iso, $output);
        $output = str_replace("%PRICING%", $this->getPricing(), $output);
        #$output = str_replace("%FREQUENCY%", $this->getMessageFrequency($product), $output);

        if( trim($output) )
        {
            $output = "<input type=\"checkbox\" name=\"terms\" id=\"terms_cb\" value=\"1\" /> <label for=\"terms_cb\">{$output}</label>";
        }
        return $output;
    }

    function getHeaderNote($product)
    {
        $ProductName = $this->getProductName($product);
        $output = $this->safe_get('Header_Note');

        $output = str_replace("%SERVICE_NAME%", $ProductName, $output);
        return $output? $output : "&nbsp;";
    }

    function getHomeRedirect()
    {
        if( isset($this->CI->Host->homepage) ) return $this->CI->Host->homepage;
        return NULL;
    }

    function getTextServices()
    {
        return $this->safe_get('Text_Services');
    }

    function safe_get($index)
    {
        if( !isset($this->Config->$index) ) return NULL;
        return $this->Config->$index;
    }

    function get_config()
    {
        return $this->Config;
    }

    function getProductName($product)
    {
        $this->CI->load->model('Products_model');
        if( $this->CI->Products_model->load($product) )
            return $this->CI->Products_model->name;
        else
            return null;

    }


}
