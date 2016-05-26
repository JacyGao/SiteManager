<?php
    /**
     * Created by John Huseinovic
     * Date: 15/11/12
     * Time: 5:07 PM
     */
require_once( dirname(__FILE__) ."/portal_model.php");


class Orangeportal_model extends Portal_model
{

    var $Info_Content = 0;
    var $Black_List = 0;

    function GetGames($limit=9)
    {
        $out = $this->GetItems('Games',NULL,$limit);
        return $out;
    }


    function SendLoginURL($mobile, $country, $keyword)
    {
        $msisdn = $this->getMSISDN($mobile);
        $shortcode = $this->siteconfig->getShortcode();

        $ci = &get_instance();

        $ci->load->helper('shorturl');

        $key = $ci->encrypt->encode( $msisdn );

        $url = "http://{$this->Host->hostname}/orangeportal/login_url/{$country}/{$keyword}/?msisdn={$msisdn}&key=". urlencode($key);

        $url = getShortURL($url);

        $message = sprintf("To login to {$this->Host->sitename} Portal, click here %s", $url);

        $response = $this->srs->free_mt($shortcode,$msisdn,$message);

        if ($response < 1) return true;


        return $this->srs->get_error($response);

    }

    /* check if mobile number has been blacklisted */
    function checkBlackList($mobile)
    {
        $this->site_db->select("mobile", false);
        $this->site_db->from("blacklist");
        $this->site_db->where('mobile', $mobile);
        $query = $this->site_db->get();

        if(!$query)
        {
            echo $this->site_db->_error_message();
            return false;
        }

        if( $query->num_rows() > 0 )
        {
            exit("Your mobile number has been suspended due to abnormal actions. Please contact helpline to reactivate your account!");
        }
    }

    function addDailyDownloads()
    {
        $msisdn = $this->session->userdata('LOGGED_IN');

        $this->site_db->set("dailydownloads", "dailydownloads+1", false);
        $this->site_db->where('mobile', $msisdn);
        $this->site_db->update("points");

        return true;
    }

    function checkAllNumbers()
    {
        $query = $this->site_db->query("SELECT mobile FROM points WHERE dailydownloads > 50");
        $blacklist = array();
        foreach ($query->result() as $row)
        {
            array_push($blacklist,$row->mobile);
        }
        return $blacklist;
    }

    function addToBlacklist($mobile)
    {
        $this->site_db->query("INSERT INTO blacklist set mobile=".$mobile);
    }

    function resetDailyDownloads()
    {
        $this->site_db->set("dailydownloads", "0", false);
        $this->site_db->update("points");

        return true;

    }

    /* override GetItems to order by ID (latest uploads)*/
    function GetItems($type=NULL, $category=NULL, $limit=9, $offset=0)
    {
        $this->site_db->select("ID as dbID, PCS as id, artist, title, lower(contentType) as type, category, downloaded as score, preview_url", false);
        $this->site_db->from($this->tbl_items);
        if($type)
            $this->site_db->where('contentType', $type);

        if($category)
            $this->site_db->where('category', $category);

        $this->site_db->order_by('dbID', 'desc');
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

    private function formatResults(&$results)
    {
        foreach($results as $i=>$rs)
        {
            $results[$i] = $this->formatResult($rs);
        }
        return $results;
    }

    private function formatResult(&$rs)
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

            default:
                $rs['preview']['protected'] = "<img src=\"/portal/image/{$rs['id']}/preview.jpg\" alt=\"{$rs['title']}\" width=\"%s\" height=\"%s\" border=0 align=\"absmiddle\" />";
                $rs['preview']['mobile'] = $rs['preview']['protected'];
                $rs['image'] = $rs['preview']['protected'];
                break;

            #...
        }


        return $rs;
    }
}