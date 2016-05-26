<?php
/**
 * Created by John Huseinovic
 * Date: 7/11/12
 * Time: 12:31 PM
 */
class Config_model extends CI_Model
{
    var $id;
    var $Host;
    var $Country;
    var $Country_Number;
    var $Sitename;
    var $Shortcode;
    var $Pricing;
    var $Joining_Fee;
    var $Header_Note;
    var $Checkbox;
    var $Mobile_Detection = false;
    var $Network_Detection = false;
    var $Default_Keyword = "";

    #var $Login_Flow =  LOGIN_FLOW_GOT_PIN;
    #var $Order_Flow = ORDER_FLOW_ENTER_NUMBER;
    #var $Pin_Message;

    #var $Terms = array('short'=>null, 'long'=>null);
    #var $Frequency = array();
    #var $Database = array('host'=>'localhost', 'username'=>null, 'password'=>null, 'database'=>null);
    #var $About_Us_Header;
    #var $About_Us_Text;
    #var $Contact_us_Text;
    #var $Contact_Email;

    function load(&$host, &$country, $countryNum=0)
    {
        if( !isset($host->id) )
        {
            log_message('error', "Host doesn't have [id] specified!");
            return false;
        }
        $this->Host = &$host;

        if( !isset($country->id) )
        {
            log_message('error', "Country doesn't have [id] specified!");
            return false;
        }
        $this->Country = &$country;


        $this->Country_Number = $countryNum;

        $where = array();
        $where['hostid'] = $this->Host->id;
        if($country->id)
        {
            $where['countryid'] = $country->id;
            $where['countrynum'] = $countryNum;
        }


        $configs = $this->db->get_where('configs', $where);
        if( $configs->num_rows() == 0)
        {
            log_message('error', "No Config found ({$this->Host->id},{$country->id},{$countryNum})");
            return false;
        }

        $rs = $configs->row(0);

        $this->id = $rs->id;

        try
        {
            $json = json_decode($rs->config);
            if( $json )
            {
                foreach($json as $key=>$val)
                {
                    #log_message('debug', "Set {$key} = ". print_r($val, true));
                    $this->$key = $val;
                }
            }

        } catch(Exception $e)
        {
            log_message('error', $e->getMessage());
        }
        return true;

    }

    function save()
    {
        $tmp = clone $this;
        unset($tmp->id, $tmp->Country, $tmp->CountryNum, $tmp->Host);
        $data = array();

        $data['hostid'] = $this->Host->id;
        $data['countryid'] = $this->Country->id;
        $data['countrynum'] = $this->Country_Number;
        $data['config'] = json_encode($tmp);


        if( $this->id )
        {
            #update
            $this->db->update('configs', $data, array('id'=>$this->id));

        }
        else
        {
            #insert
            $this->db->insert('configs', $data);

        }
    }

    function loadAll(&$host, &$country)
    {
        if(!is_object($host)) $host = (object)$host;
        if(!is_object($country)) $country = (object)$country;

        if( !isset($host->id) )
        {
            log_message('error', "Host doesn't have [id] specified!");
            return false;
        }

        if( !isset($country->id) )
        {
            log_message('error', "Country doesn't have [id] specified!");
            return false;
        }


        $where = array();
        $where['hostid'] = $host->id;
        if($country->id)
        {
            $where['countryid'] = $country->id;
        }


        $configs = $this->db->get_where('configs', $where);


        if( $configs->num_rows() == 0)
        {
            log_message('error', "No Configs found ({$host->id},{$country->id})");
            return array();
        }

        return $configs->result_array();



    }

}
