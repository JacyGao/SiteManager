<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jacy Gao
 * Date: 31/01/13
 * Time: 2:23 PM
 * To change this template use File | Settings | File Templates.
 */

class Love_model extends MY_Model
{
    var $Database = array('host'=>'localhost', 'username'=>null, 'password'=>null, 'database'=>null);
    var $PSS_Account = array('username'=>NULL, 'password'=>null);
    var $Login_Flow = array('web'=>LOGIN_FLOW_GOT_PIN, 'mobile'=>LOGIN_FLOW_SEND_URL);

    var $Items_Per_Page = array('web'=> 4, 'mobile'=>4);

    protected $tbl_credits;
    protected $tbl_items;
    protected $tbl_users;
    protected $tbl_credits_field;
    var $_Order_Keyword;

    protected $site_db;

    function load(&$host, &$country, $countrynum, $productid)
    {
        parent::load($host, $country, $countrynum, $productid);

        $this->SetupDatabase();
    }

    private function SetupDatabase()
    {
        $db = (array)$this->Database;
        if( !isset($db['username']) || !$db['username']) return false;

        $dsn = "mysql://{$db['username']}:{$db['password']}@{$db['host']}/{$db['database']}";
        $this->site_db = $this->load->database($dsn, true);


        # find right Credits table
        if ($this->site_db->table_exists('points')) $this->tbl_credits = "points";
        if ($this->site_db->table_exists('credit_points')) $this->tbl_credits = "credit_points";

        if( isset($this->tbl_credits) )
        {
            if ($this->site_db->field_exists('points', $this->tbl_credits)) $this->tbl_credits_field = "points";
            if ($this->site_db->field_exists('credits', $this->tbl_credits)) $this->tbl_credits_field = "credits";
        }

        # find right Prices table
        #if ($this->site_db->table_exists('pricing')) $this->tbl_pricing = "pricing";
        #if ($this->site_db->table_exists('prices')) $this->tbl_pricing = "prices";

        # find right Items table
        if ($this->site_db->table_exists('information')) $this->tbl_items = "information";

        # find right Users table
        if ($this->site_db->table_exists('credit_users')) $this->tbl_users = "credit_users";
        if ($this->site_db->table_exists('users')) $this->tbl_users = "users";
    }

    function __destruct()
    {
        if($this->site_db)
            $this->site_db->close();
    }

    function getContentPrice($type)
    {
        $type = ucwords($type);

        $type = str_replace(" ","_", $type);


        if( $type == "Cover" ) $type = "Covertones";
        if( $type == "Poly" ) $type = "Polyphonics";
        if( $type == "Poly" ) $type = "Polyphonics";

        $prices = (array)$this->Content_Costs;

        if( !isset($prices[$type]) )
            return 75;

        return $prices[$type];
    }

    private function formatResult(&$rs)
    {
        return $rs;
    }

    private function formatResults(&$results)
    {
        foreach($results as $i=>$rs)
        {
            $results[$i] = $this->formatResult($rs);
        }
        return $results;
    }

    function GetItem($categ)
    {
        $currentDate = date('z')+1;
        $query = $this->site_db->select("i.day, i.content, i.category", false)
            ->from("{$this->tbl_items} i")
            ->where('i.category', $categ)
            ->where('i.day',$currentDate)
            ->get();

        if(!$query)
        {
            echo $this->site_db->_error_message();
            return false;
        }

        if( $query->num_rows() > 0 )
        {
            $rs = (array)$query->row(0);
        }
        return $this->formatResult( $rs );

    }

    function getLoginFlow()
    {
        $login = (array)$this->safe_get('Login_Flow');;

        if($this->agent->is_mobile())
            return $login['mobile'];
        else
            return $login['web'];
    }

    function getSubs($mobile){

        $query = $this->site_db->select("c.points", false)
            ->from("{$this->tbl_credits_field} c")
            ->where('c.mobile',$mobile)
            ->get();

        if(!$query)
        {
            echo $this->site_db->_error_message();
            return false;
        }

        if( $query->num_rows() > 0 )
        {
            $rs = (array)$query->row(0);
        }
        return $this->formatResult( $rs );
    }
}
