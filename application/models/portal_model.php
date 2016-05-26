<?php
/**
 * Created by John Huseinovic
 * Date: 15/11/12
 * Time: 5:07 PM
 */
class Portal_model extends MY_Model
{
    var $Database = array('host'=>'localhost', 'username'=>null, 'password'=>null, 'database'=>null);
    var $PSS_Account = array('username'=>NULL, 'password'=>null);
    var $About_Us_Header;
    var $About_Us_Text;
    var $Contact_us_Text;
    var $Contact_Email;
    var $Order_Flow = ORDER_FLOW_ENTER_NUMBER;
    var $Login_Flow = array('web'=>LOGIN_FLOW_GOT_PIN, 'mobile'=>LOGIN_FLOW_SEND_URL);
    var $Allow_MO_Optin = 0;

    var $Content_Costs = array('Covertones'=>100, 'Polyphonics'=>100, 'Cover_Full_Tracks'=>200, 'Sound Effects'=>200, 'True_Tones'=>200, 'Games'=>200, 'Videos'=>200, 'Animations'=>100, 'Wallpapers'=>50,'Android Apps'=>0 );
    var $Initial_Credits = 200;
    var $Additional_Credits = 100;
    var $Items_Per_Page = array('web'=> 10, 'mobile'=>3);

    protected $tbl_credits;
    protected $tbl_items;
    protected $tbl_users;
    protected $tbl_credits_field;
    var $_Order_Keyword;

    protected $site_db;

    function load(&$host, &$country, $countrynum, $productid)
    {
        parent::load($host, $country, $countrynum, $productid);

        if( $this->uri->segment(1) == "admin" || $this->uri->segment(2) == "image" || $this->uri->segment(2) == "artist" )
            return true;

        if(!$this->SetupDatabase())
        {
            show_error('This site is not yet setup!');
        }
    }

    protected function SetupDatabase()
    {
        $db = (array)$this->Database;
        if( !isset($db['username']) || !$db['username']) return false;

        $dsn = "mysql://{$db['username']}:{$db['password']}@{$db['host']}/{$db['database']}";
        $this->site_db = $this->load->database($dsn, true);

        if(!$this->site_db)
            return false;

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

        return true;
    }

    function __destruct()
    {
        if($this->site_db)
            $this->site_db->close();
    }

    function setOrderKeyword($kw) { $this->_Order_Keyword = $kw; }
    function getOrderKeyword($suffix) { return $this->_Order_Keyword . $suffix; }

    private function mcs_encrypt($pcs, $filename, $type)
    {
        $string = "{$pcs}::{$filename}::". time() ."::{$type}";

        $key = "JohnHuseinovicRulez";
        $result = '';
        for($i=0; $i<strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % strlen($key))-1, 1);
            $char = chr(ord($char)+ord($keychar));
            $result.=$char;
        }

        return base64_encode($result);
    }

   private  function formatResult(&$rs)
    {

        $rs['title'] = stripslashes(urldecode($rs['title']));
        $rs['artist'] = stripslashes(urldecode($rs['artist']));

        $rs['title'] = humanize($rs['title']);
        $rs['artist'] = humanize($rs['artist']);

        $rs['price'] = $this->getContentPrice($rs['type']);

        switch( strtolower($rs['type']) )
        {
            case "animations":
            case "wallpapers":
                $rs['preview']['protected'] = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" data="/css/portal/web/preview.swf" width="%1$s" height="%2$s" id="item_'. $rs['id'] .'" align="middle">'.
                    '<param name="allowScriptAccess" value="sameDomain">'.
                    '<param name="allowFullScreen" value="false">'.
                    '<param name="movie" value="/css/portal/web/preview.swf">'.
                    '<param name="quality" value="high">'.
                    '<param name="flashVars" value="pcs='. $rs['id'] .'">'.
                    '<param name="wmode" value="transparent">'.
                    '<param name="menu" value="false">'.
                    '<embed src="/css/portal/web/preview.swf" flashvars="pcs='. $rs['id'] .'" menu="false" quality="high" wmode="transparent" width="%1$s" height="%2$s" '.
                    'name="item_'. $rs['id'] .'" align="middle" allowscriptaccess="sameDomain" allowfullscreen="false" '.
                    'type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer">'.
                '</object>';

                $rs['preview']['mobile'] = '<img src="/portal/image/'. $rs['id'] .'/preview.jpg" alt="'. $rs['title'] .'" width="%1$s" height="%2$s" border="0" align=\"absmiddle\" />';
                $rs['image'] = $rs['preview']['protected'];
                break;

            /* Show Image of the Artist, while allowing preview (listening) */
            case "cover":
            case "poly":
            case "polyphonics":
            case "cover full tracks":
            case "covertones":

                $rs['preview']['protected'] = "";
                if( isset($rs['preview_url']) && trim($rs['preview_url']) )
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

                $rs['image'] = "<img src=\"/portal/artist/". preg_replace("/[^0-9a-zA-Z]/","",$rs['artist'])."/preview.jpg\" alt=\"{$rs['title']}\" width=\"%s\" height=\"%s\" border=0 align=\"absmiddle\" />";
                $rs['preview']['mobile'] = $rs['image'];
                break;

            /* Disables the Preview picture, since there is no Artist */
            case "sound effects":
                $rs['preview']['protected'] = "";
                if( isset($rs['preview_url']) && trim($rs['preview_url']) )
                {
                    $song_url = "{$rs['preview_url']}";
                    $rs['preview']['protected'] = '<object type="application/x-shockwave-flash" data="http://apps.mobivate.com/mcs/includes/musicplayer.swf" width="17" height="17">'.
                        '<param name="wmode" value="transparent">'.
                        '<param name="flashvars" value="song_url='. $song_url .'&amp;b_bgcolor=FFFFFF&amp;b_fgcolor=73B114">'.
                        '<param name="movie" value="http://apps.mobivate.com/mcs/includes/musicplayer.swf">'.
                        '<param name="menu" value="false">'.
                        '</object>';
                }

                $rs['image'] = "<img src=\"/portal/image/{$rs['id']}/preview.jpg\" alt=\"{$rs['title']}\" width=\"%s\" height=\"%s\" border=0 align=\"absmiddle\" />";
                $rs['preview']['mobile'] = $rs['image'];
                break;
            case "info":
                $rs['image'] = "<img src=\"/css/info/mobile/img/".strtolower($rs['title']).".jpg\" alt=\"{$rs['title']}\" width=\"%s\" height=\"%s\" border=0 align=\"absmiddle\" />";
                break;

            default:
                $rs['preview']['protected'] = "<img src=\"/portal/image/{$rs['id']}/preview.jpg\" alt=\"{$rs['title']}\" width=\"%s\" height=\"%s\" border=0 align=\"absmiddle\" />";
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

    function GetInfo($category, $limit=9, $offset=0, $distinct = true)
    {
        $this->site_db->select("ID as id, title, artist, content, category, lower(contentType) as type, category", false);
        $this->site_db->from("information");
// group by clause by Mo

        if($distinct == true)
        {
            $this->site_db->group_by ("category");
        }

        if($category)
            $this->site_db->where('category', $category);
        if($limit)
            $this->site_db->limit($limit, $offset);
        $query = $this->site_db->get();
        if(!$query)
        {
            return false;
        }
        $out = $query->result_array();
        return $this->formatResults($out);
        print_r($out);
        exit();

    }

    function GetItems($type=NULL, $category=NULL, $limit=9, $offset=0)
    {
        $this->site_db->select("ID as dbID, PCS as id, artist, title, lower(contentType) as type, category, downloaded as score, preview_url", false);
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
        echo $this->formatResults($out);

    }

    function SearchItems($query, $type=NULL, $category=NULL)
    {
        $this->site_db->select("PCS as id, artist, title, lower(contentType) as type, category, downloaded as score, preview_url", false);
        $this->site_db->from($this->tbl_items);

        $this->site_db->like('artist', $query);
        $this->site_db->or_like('title', $query);

        if($type)
            $this->site_db->where('contentType', $type);

        if($category)
            $this->site_db->where('category', $category);

        $this->site_db->order_by('lastDownloaded', 'desc');

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

    function GetInfoItem($id)
    {
        $query = $this->site_db->select("ID as id, artist, title, lower(contentType) as type, category, content", false)
            ->from("information")
            ->where('id', $id)
            ->get();
        if(!$query)
        {
            echo $this->site_db->_error_message();
            return false;
        }
        $rs = (array)$query->row(0);
        return $this->formatResult( $rs );
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

    function GetItemByID($id)
    {
        $query = $this->site_db->select("i.id as dbID, i.PCS as id, i.artist, i.title, lower(i.contentType) as type, i.category, downloaded as score, preview_url", false)
            ->from("{$this->tbl_items} i")
            ->where('i.id', $id)
            ->get();

        if(!$query)
        {
            echo $this->site_db->_error_message();
            return false;
        }

        # Local copy not found, look up MCS
        if( $query->num_rows() == 0 )
            return false;

        return $query->row(0);

    }

    function GetTop10($type = "Cover")
    {
        $out = array();


        $serialized = file_get_contents("http://apps.mobivate.com/mcs/data/TopChart_ZA.dat");
        if($serialized)
        {
            $songs = unserialize($serialized);
            $songs = array_slice($songs, 0, 10);
            foreach($songs as $rs)
            {
                if( $rs['PCS'][$type] )
                {
                    $out[] = array('id'=>$rs['PCS'][$type], 'title'=>$rs['Title'], 'artist'=>$rs['Artist'] ,'type'=>$type,'score'=>'5');

                }
            }
        }

        return $this->formatResults($out);
    }

    function GetLatestContent($limit=10, $offset=0)
    {

        $query = $this->site_db->select("PCS as id, artist, title, lower(contentType) as type, '5' as score, preview_url", false)
                 ->from($this->tbl_items)
                 ->order_by('id', 'desc')
                 ->limit($limit, $offset)
                 ->group_by('title,artist')
                 ->get();

        #echo $this->site_db->last_query();
        #echo $this->site_db->_error_message();
        $out = $query->result_array();

        return $this->formatResults($out);
    }

    function GetContentType(){
        $this->site_db->select("DISTINCT contentType", false);
        $this->site_db->from($this->tbl_items);
        $this->site_db->order_by('contentType');

        $query = $this->site_db->get();

        $types = $query->result();
        print_r($types);
        foreach($types as $rs){
          $tp =  $rs->contentType;
        }
        return $tp;
    }

    function GetContentTypes($limit=9,$ignore=array())
    {
        $out = $items = $sort = array();

        $this->site_db->select("DISTINCT contentType", false);
        $this->site_db->from($this->tbl_items);
        $this->site_db->order_by('contentType');

        if(count($ignore) > 0)
            $this->site_db->where_not_in('contentType', $ignore);

        $query = $this->site_db->get();

        $types = $query->result();

        foreach($types as $rs)
        {
            $items[$rs->contentType] = $this->GetItems($rs->contentType, NULL, $limit);
            $sort[$rs->contentType] = count($items[$rs->contentType]);
        }

        array_multisort($sort,SORT_NUMERIC, SORT_DESC);

        foreach($sort as $k=>$v)
        {
            $out[$k] = &$items[$k];
        }

        return $out;

    }

    function GetRingtones($limit=9)
    {
        $out = array();

        if( $results = $this->GetItems('Covertones', 'Gospel', $limit) )
            $out['Gospel'] = $results;

        if( $results =  $this->GetItems('Polyphonics',NULL,$limit) )
            $out['Polyphonics'] = $results;

        if( $results = $this->GetItems('Covertones',NULL,$limit) )
            $out['Covertones'] = $results;

        if( $results = $this->GetItems('Cover Full Tracks',NULL,$limit) )
            $out['Full Tracks'] = $results;

        return $out;
    }

    function GetVideos($limit=9)
    {
        $out = $this->GetItems('Videos',NULL,$limit);

        return $out;
    }

    function GetInfos($limit=9)
    {
        $out = $this->GetInfo(NULL,$limit,NULL);

        return $out;
    }

    function GetPrices()
    {
        return (array)$this->Content_Costs;
    }

    function GetCredits()
    {

        if(!$this->tbl_credits) return false;

        $msisdn = $this->session->userdata('LOGGED_IN');
        $query = $this->site_db->get_where($this->tbl_credits, array("mobile"=>$msisdn));

        if( $query->num_rows() == 0)
            return 0;

        $rs = $query->row(0);

        $field = $this->tbl_credits_field;

        return (int)$rs->$field;
    }

    function DeductCredits($amount)
    {
        if(!$this->tbl_credits) return false;

        $msisdn = $this->session->userdata('LOGGED_IN');

        $this->site_db->set($this->tbl_credits_field, "{$this->tbl_credits_field}-{$amount}", false);
        $this->site_db->where('mobile', $msisdn);
        $this->site_db->update($this->tbl_credits);
        return true;
    }

    private function generate_pin()
    {
        $pin = rand(1000,9999);
        $this->session->set_userdata('PORTAL_LOGIN_PIN', $pin);
        return $pin;
    }

    function ValidateLoginPIN($input)
    {
        $pin = $this->session->userdata('PORTAL_LOGIN_PIN');
        return ( $pin == $input );
    }

    function CreateUser($mobile, $pin)
    {
        $domain = $this->input->server('HTTP_HOST');
        $this->db->query("INSERT INTO portal_subscribers set domain='{$domain}', mobile='{$mobile}', newpin='{$pin}' ON DUPLICATE KEY UPDATE newpin='{$pin}'");
//        $existing = $this->db->get_where('portal_subscribers', array('domain'=>$this->input->server('HTTP_HOST'), 'mobile'=>$mobile));
//        if( $existing->num_rows() > 0 )
//        {
//            $this->db->update('portal_subscribers', array('domain'=>$this->input->server('HTTP_HOST'), 'mobile'=>$mobile), array('newpin'=>$pin));
//        }
//        else
//        {
//            $this->db->insert('portal_subscribers', array('domain'=>$this->input->server('HTTP_HOST'), 'mobile'=>$mobile,'newpin'=>$pin));
//        }
    }

    function ActivateNewPin($msisdn)
    {
        $mobile = $msisdn;
        if( substr($mobile, 0, strlen($this->Country->prefix)) == $this->Country->prefix )
            $mobile = substr($mobile, strlen($this->Country->prefix));

        if( strlen($mobile) < 7)
            return 0;

        $this->db->set('pin', '`newpin`', false);
        $this->db->where('domain', $this->input->server('HTTP_HOST'));
        $this->db->like('mobile', $mobile, 'before');
        $this->db->update('portal_subscribers');
        return $this->db->affected_rows();
    }

    function ValidateUser($mobile, $pin)
    {
        $query = $this->db->get_where('portal_subscribers', array("domain"=>$this->input->server('HTTP_HOST'), "mobile"=>$mobile, "pin"=>$pin));

        if( !$query )
            return $this->error( $this->db->_error_message() );

        $valid = ($query->num_rows() > 0);

        if( $valid )
            return true;

        return $this->error("Mobile Number / PIN you entered is incorrect");

    }

    function SendLoginPIN($mobile)
    {

        $pin = $this->generate_pin();

        $shortcode = $this->siteconfig->getShortcode();

        $message = sprintf("To login to {$this->Host->sitename} Portal, enter this PIN on the site (%d)", $pin);

        $msisdn = $this->getMSISDN($mobile);
        $this->session->set_userdata('TEMP_MSISDN', $msisdn);

        $response = $this->srs->free_mt($shortcode,$msisdn,$message);

        if ($response < 1) return true;

        return $this->srs->get_error($response);
    }

    function SendLoginURL($mobile, $country, $keyword)
    {
        $msisdn = $this->getMSISDN($mobile);
        $shortcode = $this->siteconfig->getShortcode();

        $ci = &get_instance();

        $ci->load->helper('shorturl');

        $key = $ci->encrypt->encode( $msisdn );

        $url = "http://{$this->Host->hostname}/portal/login_url/{$country}/{$keyword}/?msisdn={$msisdn}&key=". urlencode($key);

        $url = getShortURL($url);

        $message = sprintf("To login to {$this->Host->sitename} Portal, click here %s", $url);

        $response = $this->srs->free_mt($shortcode,$msisdn,$message);

        if ($response < 1) return true;

        return $this->srs->get_error($response);

    }

    private function error($msg)
    {
        $this->Error = $msg;
        return false;
    }

    function getLoginFlow()
    {
        $login = (array)$this->safe_get('Login_Flow');;

        if($this->agent->is_mobile())
            return $login['mobile'];
        else
            return $login['web'];
    }

    function getOrderFlow()
    {
        return $this->safe_get('Order_Flow');
    }

    function getAboutUsHeader()
    {
        return $this->safe_get('About_Us_Header');
    }

    function getAboutUsText()
    {
        return $this->safe_get('About_Us_Text');
    }

    function getContactUsText()
    {
        return $this->safe_get('Contact_us_Text');
    }

    function getContactEmail()
    {
        return $this->safe_get('Contact_Email');
    }

    function getOrderPinMessage($keyword,$msisdn, $network, $pcs)
    {
        $msg = "[INSTRUCTIONS] to gain access to your content.";


        $link = 'http://'.$this->Host->hostname.'/'.$this->Product->path.'/orderpin/'.$this->Country->iso.$this->CountryNumber.'/'.$keyword.'/'.$pcs.'/?key='.urlencode($this->encrypt->encode("{$msisdn}:{$network}"));
        $link = getShortURL($link);
        $msg = str_replace('[INSTRUCTIONS]', "Click on the link {$link} ", $msg);

    
        $msg = preg_replace("/\s+/", " ", $msg);

        return $msg;
    }

    function OrderContent($pcs)
    {
        $item = $this->GetItem($pcs);

        if(!$item)
            show_404("The item you are searching for no longer exists!");


        $flow = $this->getOrderFlow();

        if( $flow != ORDER_FLOW_ENTER_NUMBER && $flow != ORDER_FLOW_SHOW_KEYWORD )
            show_error('Invalid request!');

        return true;


    }

    function SendContent($msisdn, $shortcode, $pcs, $cost=NULL)
    {
        $item = $this->GetItem($pcs);

        if(!$item)
            show_404("the item you are searching for no longer exists!");

        $url = $this->getdownloadurl($msisdn, $shortcode, $pcs);

        $message = "To download {$item['title']} go to {$url} - ". $this->Host->sitename;

        $response = $this->srs->billed_mt($shortcode, $msisdn, $message, $cost);

        if ($response === true) return true;

        return $this->srs->get_error($response);

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
            .($this->agent->is_mobile() ? "&AGENT=". urlencode($_SERVER['HTTP_USER_AGENT']):"");
        $url = file_get_contents($pss);

        return $url;
    }

    function IncreaseDownloadCount($id)
    {
        $this->site_db->set('downloaded', 'downloaded+1', false);
        $this->site_db->where('ID', $id);
        $this->site_db->update($this->tbl_items);
    }

    function IncreaseDisplayedCount($id)
    {
        $this->site_db->set('displayed', 'displayed+1', false);
        $this->site_db->where('ID', $id);
        $this->site_db->update($this->tbl_items);
    }

    function getItemsPerPage()
    {
        $ipp = (array)$this->safe_get('Items_Per_Page');

        if($this->agent->is_mobile())
            return $ipp['mobile'];
        else
            return $ipp['web'];
    }

    function hasClaimedPoints($msisdn, $date)
    {
        $query = $this->site_db->get_where('claimed', array('msisdn'=>$msisdn, 'claimed'=>$date));

        if( !$query )
            return $this->error( $this->db->_error_message() );

        $used = ($query->num_rows() > 0);

        return $used;
    }

    function recordClaimedPoints($msisdn, $date)
    {
        $Initial_Credits = $this->safe_get('Initial_Credits');
        $Additional_Credits = $this->safe_get('Additional_Credits');

        $this->site_db->insert('claimed', array('msisdn'=>$msisdn, 'claimed'=>$date));

        $this->site_db->query("INSERT INTO {$this->tbl_credits} SET mobile='{$msisdn}', {$this->tbl_credits_field}={$Initial_Credits}, creditsAdded='". date("Y-m-d H:i:s") ."', notified=0 ON DUPLICATE KEY UPDATE {$this->tbl_credits_field}={$this->tbl_credits_field}+{$Additional_Credits} , creditsAdded='". date("Y-m-d H:i:s") ."', notified=0", false);
    }

    function recordDownloads($pcs, $msisdn)
    {
        $this->site_db->insert('countdownloads', array('mobile'=>$msisdn, 'pcs'=>$pcs, 'datetime'=>date("Y-m-d H:i:s")));

        return true;
    }

    function pushItem($post)
    {
        $post['inserted'] = date("Y-m-d");

        unset($post['supplierID']);
        
        $inserted = $this->site_db->insert($this->tbl_items, $post);

        if(!$inserted)
        {
            echo $this->site_db->_error_message();
            return false;

        }

        $this->downloadPreview($post['PCS'], $post['preview_url']);

    }

    private function downloadPreview($pcs, $remote)
    {
        $local = "/home/SHARED/previews/{$pcs}.cache";

        if(file_exists($local))
        {
            if(filesize($local) > 0)
            {
                return true;
            }
        }

        $url=parse_url($remote);

        $remote = str_replace(" ","%20",$remote);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote );
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_REFERER, $url['host'] );
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);

        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.8.1.14) Gecko/20080404 Firefox/2.0.0.14");
        $result = curl_exec($ch);
        curl_close ($ch);
        if(stristr($result,"<html") )
        {

            return false;
        } else {
            $lfile = fopen($local, "wb");
            fwrite($lfile, $result, strlen($result));
            fclose($lfile);
            chmod($local, 0777);
            echo "[downloaded preview]";
            return true;
        }
    }

}
