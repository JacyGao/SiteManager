<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Jacy Gao
 * Date: 31/01/13
 * Time: 2:23 PM
 * To change this template use File | Settings | File Templates.
 */

class Splash_model extends MY_Model
{
    var $Database = array('host'=>'localhost', 'username'=>null, 'password'=>null, 'database'=>null);
    var $PSS_Account = array('username'=>NULL, 'password'=>null);
    var $Order_Flow = ORDER_FLOW_ENTER_NUMBER;
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
        if ($this->site_db->table_exists('items')) $this->tbl_items = "items";

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

        $rs['title'] = stripslashes(urldecode($rs['title']));
        $rs['artist'] = stripslashes(urldecode($rs['artist']));

        #$rs['title'] = humanize($rs['title']);
        #$rs['artist'] = humanize($rs['artist']);

        $rs['price'] = $this->getContentPrice($rs['type']);

        switch( strtolower($rs['type']) )
        {
            case "animations":
            case "wallpapers":
                $rs['preview']['protected'] = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" data="/css/splash/web/preview.swf" width="%1$s" height="%2$s" id="item_'. $rs['id'] .'" align="middle">'.
                    '<param name="allowScriptAccess" value="sameDomain">'.
                    '<param name="allowFullScreen" value="false">'.
                    '<param name="movie" value="/css/splash/web/preview.swf">'.
                    '<param name="quality" value="high">'.
                    '<param name="flashVars" value="pcs='. $rs['id'] .'">'.
                    '<param name="wmode" value="transparent">'.
                    '<param name="menu" value="false">'.
                    '<embed src="/css/splash/web/preview.swf" flashvars="pcs='. $rs['id'] .'" menu="false" quality="high" wmode="transparent" width="%1$s" height="%2$s" '.
                    'name="item_'. $rs['id'] .'" align="middle" allowscriptaccess="sameDomain" allowfullscreen="false" '.
                    'type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer">'.
                    '</object>';

                $rs['preview']['mobile'] = '<img src="/splash/image/'. $rs['id'] .'/preview.jpg" alt="'. $rs['title'] .'" width="%1$s" height="%2$s" border="0" align=\"absmiddle\" />';
                $rs['image'] = $rs['preview']['protected'];
                break;

            case "cover":
            case "poly":
            case "polyphonics":
            case "cover full tracks":
            case "covertones":


                $rs['preview']['protected'] = "";
                if( isset($rs['preview_url']) )
                {
                    $song_url = "{$rs['preview_url']}";
//                    $rs['preview']['protected'] = '<object type="application/x-shockwave-flash" data="http://apps.mobivate.com/mcs/includes/musicplayer.swf?&amp;song_url='. $song_url .'&amp;b_bgcolor=FFFFFF&amp;b_fgcolor=73B114&amp;" width="17" height="17">'.
//                        '<param name="wmode" value="transparent">'.
//                        '<param name="movie" value="http://apps.mobivate.com/mcs/includes/musicplayer.swf?&amp;song_url='. $song_url .'&amp;b_bgcolor=FFFFFF&amp;b_fgcolor=73B114&amp;">'.
//                        '</object>';
                    $rs['preview']['protected'] = '<object type="application/x-shockwave-flash" data="http://apps.mobivate.com/mcs/includes/musicplayer.swf" width="17" height="17">'.
                        '<param name="wmode" value="transparent">'.
                        '<param name="flashvars" value="song_url='. $song_url .'&amp;b_bgcolor=FFFFFF&amp;b_fgcolor=73B114">'.
                        '<param name="movie" value="http://apps.mobivate.com/mcs/includes/musicplayer.swf">'.
                        '<param name="menu" value="false">'.
                        '</object>';
                }

                $rs['image'] = "<img src=\"/splash/artist/". preg_replace("/[^0-9a-zA-Z]/","",$rs['artist'])."/preview.jpg\" alt=\"{$rs['title']}\" width=\"%s\" height=\"%s\" border=0 align=\"absmiddle\" />";
                $rs['preview']['mobile'] = $rs['image'];
                break;


            case "sound effects":
                $rs['preview']['protected'] = "";
                if( isset($rs['preview_url']) && trim($rs['preview_url']) )
                {
                    $song_url = "{$rs['preview_url']}";
                    $rs['preview']['protected'] = '<object type="application/x-shockwave-flash" data="http://apps.mobivate.com/mcs/includes/musicplayer.swf?&amp;song_url='. $song_url .'&amp;b_bgcolor=FFFFFF&amp;b_fgcolor=73B114&amp;" width="17" height="17">'.
                        '<param name="wmode" value="transparent">'.
                        '<param name="movie" value="http://apps.mobivate.com/mcs/includes/musicplayer.swf?&amp;song_url='. $song_url .'&amp;b_bgcolor=FFFFFF&amp;b_fgcolor=73B114&amp;">'.
                        '</object>';
                }

                $rs['image'] = "<img src=\"/splash/image/{$rs['id']}/preview.jpg\" alt=\"{$rs['title']}\" width=\"%s\" height=\"%s\" border=0 align=\"absmiddle\" />";
                $rs['preview']['mobile'] = $rs['image'];
                break;

            default:
                $rs['preview']['protected'] = "<img src=\"/splash/image/{$rs['id']}/preview.jpg\" alt=\"{$rs['title']}\" width=\"%s\" height=\"%s\" border=0 align=\"absmiddle\" />";
                $rs['preview']['mobile'] = $rs['preview']['protected'];
                $rs['image'] = $rs['preview']['protected'];
                break;

            #...
        }


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

    function GetItems($type=NULL, $category=NULL, $limit=9, $offset=0)
    {
        $this->site_db->select("PCS as id, artist, title, lower(contentType) as type, category, downloaded as score, preview_url", false);
        $this->site_db->from($this->tbl_items);
        if($type)
            $this->site_db->where('contentType', $type);

        if($category)
            $this->site_db->where('category', $category);

        $this->site_db->order_by('lastDownloaded', 'desc');
        if($limit)
            $this->site_db->limit($limit, $offset);

        $query = $this->site_db->get();

        if(!$query)
        {
            echo $this->site_db->_error_message();
            return false;
        }

        if( $query->num_rows() == 0 )
            return false;


        $out = $query->result_array();

        return $this->formatResults($out);
    }

    function GetVideos($limit=4)
    {
        $out = $this->GetItems('Videos',NULL,$limit);

        return $out;
    }

    function GetGames($limit=10)
    {
        $out = $this->GetItems('Games',NULL,$limit);

        return $out;
    }

    function getItemsPerPage()
    {
        $ipp = (array)$this->safe_get('Items_Per_Page');

        if($this->agent->is_mobile())
            return $ipp['mobile'];
        else
            return $ipp['web'];
    }

    function GetItem($pcs)
    {

        $query = $this->site_db->select("i.id as dbID, i.PCS as id, i.artist, i.title, lower(i.contentType) as type, i.category, downloaded as score, preview_url", false)
            ->from("{$this->tbl_items} i")
            ->where('i.PCS', $pcs)
            ->get();

        if(!$query)
        {
            echo $this->site_db->_error_message();
            return false;
        }

        # Local copy not found, look up MCS
        if( $query->num_rows() > 0 )
        {
            $rs = (array)$query->row(0);
        }
        else
        {
            $url = "http://apps.mobivate.com/mcs/items.php?format=XML&USER=mobivate&PWD=etavibom&ITEMS=". $pcs;

            $content = file_get_contents($url);

            try
            {
                $xml = simplexml_load_string($content);

                if( !$xml->Item1->PCS )
                    return false;

                $rs = array();
                $rs['dbID'] = $xml->Item1->PCS;
                $rs['id'] = $xml->Item1->PCS;
                $rs['artist'] = $xml->Item1->Artist;
                $rs['title'] = $xml->Item1->Title;
                $rs['type'] = strtolower($xml->Item1->Content);
                $rs['category'] = $xml->Item1->Category;
                $rs['price'] = $this->getContentPrice($rs['type']);
                $rs['score'] = 10;
                $rs['preview_url'] = $xml->Item1->File;
            }
            catch(Exception $e)
            {
                return false;
            }

        }


        return $this->formatResult( $rs );

    }

    function setOrderKeyword($kw) { $this->_Order_Keyword = $kw; }
    function getOrderKeyword($suffix) { return $this->_Order_Keyword . $suffix; }

    function getOrderFlow()
    {
        return $this->safe_get('Order_Flow');
    }

    function getLoginFlow()
    {
        $login = (array)$this->safe_get('Login_Flow');;

        if($this->agent->is_mobile())
            return $login['mobile'];
        else
            return $login['web'];
    }

    function getDownloadURL($mobile,$shortcode,$pcs)
    {
        if( !isset($this->PSS_Account->username) || !isset($this->PSS_Account->password) )
            show_error("This site is completely configured. This action cannot be completed!");

        $msisdn = $this->getMSISDN($mobile);

        $pss = "http://{$this->PSS_Account->username}:{$this->PSS_Account->password}@apps.mobivate.com/pss/pcsgenerate.php"
            ."?USER={$this->PSS_Account->username}"
            ."&PWD={$this->PSS_Account->password}"
            ."&CODE={$pcs}"
            ."&SRC={$shortcode}"
            ."&DEST={$msisdn}"
            .($this->agent->is_mobile() ? "&AGENT=". $_SERVER['HTTP_USER_AGENT']:"");

        $url = file_get_contents($pss);

        return $url;
    }

    function IncreaseDownloadCount($id)
    {
        $this->site_db->set('downloaded', 'downloaded+1', false);
        $this->site_db->where('ID', $id);
        $this->site_db->update($this->tbl_items);
    }
}
