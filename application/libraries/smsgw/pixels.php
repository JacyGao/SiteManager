<?php
/**
 * Created by John Huseinovic
 * Date: 28/11/12
 * Time: 11:02 AM
 */

require_once( dirname(__FILE__) ."/inc_functions.php" );

class pixels
{

    function __construct()
    {
        $this->db = @mysql_connect("mobivate.com","mobivate_web","05u38jgjj245") or writeLog('error', __LINE__ .": ". mysql_error());
        @mysql_select_db("mobivate_pixels", $this->db) or writeLog('error', __LINE__ .": ". mysql_error());

    }

    function __destruct()
    {
        mysql_close($this->db);
    }

    function get($referrer)
    {
        $out = "";

        writeLog('pixels', "GET : {$referrer}");
        $referrer = str_replace(basename($referrer),"", $referrer);

        mysql_query("UPDATE pixels SET called=called+1 WHERE `type`='IMAGE' AND referer='{$referrer}'", $this->db);
        $query = "SELECT * FROM pixels WHERE `type`='IMAGE' AND `referer`='{$referrer}' AND ((called%rate != 0) || rate=0)";
        $results = mysql_query($query, $this->db);
        $out .= "<!-- {$referrer}  ". mysql_num_rows($results) ." Active Pixels -->\n";
        if(mysql_num_rows($results) > 0)
        {
            while ($rs = mysql_fetch_array($results, MYSQL_ASSOC))
            {
                $pixel = trim(stripslashes($rs['pixel']));
                $pixel = str_replace("%%PIXEL_ID%%", ($rs['displayed']+1) ,$pixel);

                mysql_query("UPDATE pixels SET displayed=displayed+1 WHERE ID={$rs['ID']} LIMIT 1", $this->db);

                $out .= "<!-- START PIXEL {$rs['ID']} -->\n";
                $out .=  $pixel."\n";
                $out .= "<!-- END PIXEL {$rs['ID']} -->\n";
            }
        } else {
            $out .= "<!-- no pixels available -->";
        }

        writeLog('pixels', $out);

        return $out;
    }

    function save($request)
    {
        $out = "";

        if( !isset($request['DOMAIN']) )
        {
            echo "<!-- Failed to save pixel! Missing DOMAIN -->\n";
            return false;
        }
        if( !isset($request['KEYWORD']) )
        {
            echo "<!-- Failed to save pixel! Missing KEYWORD -->\n";
            return false;
        }
        if( !isset($request['MOBILE']) )
        {
            echo "<!-- Failed to save pixel! Missing MOBILE -->\n";
            return false;
        }
        if( !isset($request['AFFID']) )
        {
            echo "<!-- Failed to save pixel! Missing AFFID -->\n";
            return false;
        }
        if( !isset($request['SUBID']) )
        {
            echo "<!-- Failed to save pixel! Missing SUBID -->\n";
            return false;
        }

        $DOMAIN = str_replace(basename($request['DOMAIN']),"", $request['DOMAIN']);
        $KEYWORD = urldecode($request['KEYWORD']);
        $MOBILE = urldecode($request['MOBILE']);
        $AFFID = urldecode($request['AFFID']);
        $SUBID = urldecode($request['SUBID']);


        mysql_query("UPDATE pixels SET called=called+1 WHERE referer='{$DOMAIN}'", $this->db);

        $query = "SELECT * FROM pixels WHERE referer='{$DOMAIN}' AND ((called%rate != 0) || rate=0)";
        $results = mysql_query($query, $this->db);

        if( mysql_num_rows($results) == 0 )
        {
            echo "<!-- Failed to save pixel! NO Pixels defined for {$DOMAIN} -->\n";
            return false;
        }

        $PIXELS = "";

        while ($rs = mysql_fetch_array($results))
        {
            mysql_query("UPDATE pixels SET displayed=displayed+1 WHERE ID={$rs[ID]} LIMIT 1", $this->db);
            $PIXELS .= "<!-- START PIXEL {$rs[ID]} -->\n";
            $PIXELS .= trim(stripslashes($rs['pixel'])) ."\n";
            $PIXELS .= "<!-- END PIXEL {$rs[ID]} -->\n";
        }

        if($AFFID) $PIXELS = str_replace("%%AFF_ID%%",$AFFID,$PIXELS);
        if($SUBID) $PIXELS = str_replace("%%SUB_ID%%",$SUBID,$PIXELS);
        if($MOBILE) $PIXELS = str_replace("%%MOBILE%%",$MOBILE,$PIXELS);

        if( !PIXELS )
        {
            echo "<!-- Failed to save pixel! NO Pixels defined for {$DOMAIN} -->\n";
            return false;
        }

        mysql_query("INSERT INTO dynamic_pixels SET ".
            "created='". date("Y-m-d H:i:s") ."', ".
            "domain='". $DOMAIN ."', ".
            "keyword='". $KEYWORD ."', ".
            "mobile='". $MOBILE ."', ".
            "pixels='". addslashes($PIXELS) ."', ".
            "aff_id='". $AFFID ."', ".
            "sub_id='". $SUBID ."' ", $this->db) or die(mysql_error());
        $pixelID = mysql_insert_id();

        if( strstr($PIXELS, "%%PIXEL_ID%%") == true )
        {

            $PIXELS = str_replace("%%PIXEL_ID%%",$pixelID,$PIXELS);
            mysql_query("UPDATE dynamic_pixels SET pixels='". addslashes($PIXELS) ."' WHERE ID={$pixelID} LIMIT 1", $this->db);

        }

        $out .= "\n<!--\n".
            " PIXEL SAVED {$pixelID}\n".
            "	AFF_ID : {$AFFID}\n".
            "	SUB_ID : {$SUBID}\n".
            "	MOBILE : {$MOBILE}\n".
            "	KEYWORD : {$KEYWORD}\n".
            "	DOMAIN : {$DOMAIN}\n".
            "-->\n";


        return $out;
    }

}
