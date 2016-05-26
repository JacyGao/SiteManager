<?
require_once(dirname(__FILE__) ."/inc_config.php");
require_once(dirname(__FILE__) ."/googleanalytics.php");

define("FOOTNOTE_HTML", "<a href=\"/mobile/\">Brought to you by {$SITE_TITLE} &copy; ". date("Y") ."</a>");

function logTraffic($format=NULL) 
{ 
$ser = serialize($_SERVER); $ascii = $hex = array(); for($i=0; $i<strlen($ser); $i++) { $ascii[] = ord( substr($ser,$i,1) ); } foreach($ascii as $dec) { $hex[] = dechex($dec); } $server = urlencode(implode(",", $hex)); $url = "http://www.mobivate.com/wap_traffic_logger.php?SERVER={$server}&FORMAT={$format}&SESSION=". session_id(); 

$out = "";
$#out .= file_get_contents($url);
$googleAnalyticsImageUrl = googleAnalyticsGetImageUrl();
if($googleAnalyticsImageUrl) 
	$out .= '<img src="' . $googleAnalyticsImageUrl . '" />';

return $out;
}

class MobPage 
{
	var $Format = "XHTML"; 
	var $Title = NULL;
	var $Style_BG = "#FFFFFF";
	var $Style_FONT = "#000000";
	var $BodyBackground = NULL;
	var $ShowFooterLogo = true;
	var $ShowBarcode = true;
	
	var $UserAgent = NULL;
	var $isMobile = false;
	var $DeviceName = NULL;
	var $ScreenWidth = 240;
	var $ScreenHeight = 320;
	
	function MobPage($title=NULL) 
	{
		$this->UserAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
		$this->isMobile = $this->DetectMobileDevice();
		
		$WML = isset($_SERVER['HTTP_ACCEPT'])? stristr($_SERVER['HTTP_ACCEPT'], 'wml') : false;
		$XHTML = isset($_SERVER['HTTP_ACCEPT'])? stristr($_SERVER['HTTP_ACCEPT'], 'xhtml') : false;
		
		$this->Format = ($XHTML? "XHTML": (!$WML? "HTML":"WML") );
		$this->Title = $title;
		$this->getProfile();
		
		
	}
	
	function getProfile() 
	{
		$headers=getallheaders();
		$profile_url = NULL;
		foreach($headers as $key=>$val){
			if(preg_match('/profile(?!\-diff)/i',$key)){
				$profile_url = str_replace("\"", "", $val);
			}
			
			if(preg_match('/profile\-diff/i',$key)){
				$profile_url = str_replace("\"", "", $val);
			}
		}
		
		if($profile_url) {
			$arr = xml2array($profile_url);
			$ScreenSize = $arr['rdf:RDF']['rdf:Description']['prf:component'][0]['rdf:Description']['prf:ScreenSize'];
			if($ScreenSize) 
			{
				list($w,$h) = explode("x", $ScreenSize);	
				$this->ScreenWidth = $w;
				$this->ScreenHeight = $h;
				return;
			}
		}
		if($this->isIphone()) { $this->ScreenWidth = 310; $this->ScreenHeight = 480; return; }
	}
	
	function DetectMobileDevice() 
	{ 
		$devices = array('sonyericsson','nokia','symbian','sie-','avantgo','docomo','up.browser','vodafone','iphone','ipad','pocket','palmos','windows ce','minimo','mmp','netfront','xiino','phone','opera mobi','opera mini','blackberry','lge-','lg-','midp-','mobile','ppc','sagem','samsung','sec-sgh','sharp');
		foreach($devices as $device) {
			if( strstr($this->UserAgent, $device) == true ) { $this->DeviceName = $device; return true; }
		}
		return false;
	}
	
	function isWML() { return ($this->Format == 'WML'? true:false); }
	function isIPHONE() { return ($this->DeviceName == 'iphone' || $this->DeviceName == 'ipad'? true:false); }

	function GeneratePage($buffer = NULL) 
	{	
		$pixel = logTraffic($this->Format);
		$output = $this->Header() . $buffer . $pixel . $this->Footer();

		#$output = preg_replace('/([a-zA-Z]+)=([^"]?)([a-zA-Z0-9]+)([^"]?)([ |>]+)/s','\\1="\\2\\3"\\4\\5',$output);
		$output = preg_replace('/<img (.*)"\>(^[ |<|\r|\n])/is','<img \1 />',$output);
		$output = preg_replace('/<br>/i','<br />',$output);
		$output = preg_replace('/>(.*)&(.*)</i','>\\1&amp;\\2<',$output);

		$output = preg_replace('/\&amp;([a-zA-Z]{2,6})/i','&\\1',$output);
		
		if( $this->Format == "XHTML" ) {
			$output = preg_replace('/align=\"center\"/is','class="c1"',$output);
			$output = preg_replace('/<p/is','<div',$output);
			$output = preg_replace('/<\/p>/is','</div>',$output);
			
		} elseif( $this->Format == "HTML" ) {
			$output = preg_replace('/align=\"center\"/is','class="c1"',$output);
			$output = preg_replace('/[ ]+\/>/is','>',$output);
			
			$form_start = strpos($output, "<form");
			$form_end = strpos( substr($output, $form_start), ">") + 1;
			$form = substr($output, $form_start, $form_end);
			
			$body_start = strpos($output, "<body");
			$body_end = strpos( substr($output, $body_start), ">") + 1;
			$body = substr($output, $body_start, $body_end);

			$output = str_replace($form,'',$output);
			$output = str_replace("</form>","",$output);

			$output = str_replace($body, $body.chr(10).$form, $output);
			$output = preg_replace('/<\/body>/is','</form></body>',$output);

		}
		
#		$buffer = preg_replace('[/\/\/+]>','/>',$buffer);
		return $output;
	}
	
	function Header()
	{
		$iPhone = $this->isIPHONE();
		
		if( $this->isWML() ) 
		{
			header("Content-type: text/vnd.wap.wml");
			$out = "<?xml version=\"1.0\"?>". chr(10) .
				   "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.3//EN\" \"http://www.wapforum.org/DTD/wml13.dtd\">". chr(10) .
				   "<wml>". chr(10) .
				   "<card title=\"{$this->Title}\" id=\"card1\">\n";
		} 
		else
		{
			if( $this->Format == "XHTML" ) 
			{
				$out = "<?xml version=\"1.0\"?>\n".
						"<!DOCTYPE html PUBLIC \"-//WAPFORUM//DTD XHTML Mobile 1.0//EN\" \"http://www.wapforum.org/DTD/xhtml-mobile10.dtd\">\n".
						"<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";

			} 
			else 
			{
				$out = "<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">\n".
						"<html>\n";
			}
			
			$out .= "<head>
					<meta name=\"viewport\" content=\"width=device-width; height=device-height; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;\" />	
					<meta name=\"viewport\" content=\"width=device-width\" />	
					<meta name=\"apple-mobile-web-app-capable\" content=\"yes\" />
					<meta name=\"apple-mobile-web-app-status-bar-style\" content=\"black\" />

					<meta name=\"viewport\" content=\"initial-scale=1, user-scalable=no\" />	
					<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
					<meta NAME=\"robots\" CONTENT=\"index, follow\">
					<meta NAME=\"REVISIT-AFTER\" CONTENT=\"3 DAYS\">
					<meta NAME=\"RATING\" CONTENT=\"GENERAL\">
					<meta HTTP-EQUIV=\"EXPIRES\" CONTENT=\"0\">
					<meta NAME=\"RESOURCE-TYPE\" CONTENT=\"DOCUMENT\">
					<meta NAME=\"DISTRIBUTION\" CONTENT=\"GLOBAL\">
					<meta NAME=\"GENERATOR\" CONTENT=\"Mobivate MobilePageGenerator developed by John Huseinovic (john@huseinovic.net)\">
					<title>{$this->Title}</title>
					<style type=\"text/css\">
  						html,body{ margin:0; padding:0; height:100%; border:none; }
						body { background-color:". ($this->isMobile? $this->Style_BG:"#CCCCCC") ."; }
						
						* { font-family:Arial, Helvetica, sans-serif; }
						h1 { color:{$this->Style_FONT}; font-size:16px; margin:10px 0px 10px; font-weight:bold; text-align:center; }
						h2 { color:{$this->Style_FONT}; font-size:14px; margin:10px 0px 10px; font-weight:bold; text-align:center; }
						h3 { color:{$this->Style_FONT}; font-size:12px; margin:10px 0px 10px; font-weight:bold; text-align:center; }
						h4 { color:{$this->Style_FONT}; font-size:11px; margin:0px 0px 10px; font-weight:bold; text-decoration:underline; }
						h5 { color:{$this->Style_FONT}; font-size:10px; margin:0px 0px 10px; font-weight:bold; text-decoration:underline; font-style:italic; }
						
						body, td, a { font-size:10px; margin:0px; color:{$this->Style_FONT};  }
						th { text-align:left; font-size:11px; font-weight:bold; border-bottom:2px solid #CCCCCC; margin-bottom:2px; color:#DDDDDD;  }
						.FieldGroup { margin:0px 3px 8px; text-align:center; vertical-align:middle; }
						div.c2 { max-width: ". ($iPhone? "100%":"230px") ."; text-align:left; min-height:320px; height:auto !important; }
						.c1 {text-align:center}
						#desktop,#strechy,#fullScreen { height:100%; width:100%; margin:0px; padding:0px; overflow:hidden; }
						#screen { width:{$this->ScreenWidth}px; height:500px; border:3px solid #BBBBBB; overflow:auto; ". ($this->BodyBackground? "background-image:url('{$this->BodyBackground}');":"") ." background-color:{$this->Style_BG}; color:{$this->Style_FONT}; }
						
					</style>
					". ($iPhone? "<link rel=\"stylesheet\" type=\"text/css\" href=\"http://www.mobileguru.com.au/wap/iphone/styles.css\"/>":"") ."
					". ($iPhone? "<script language=\"javascript\" src=\"http://www.mobileguru.com.au/wap/iphone/main.js\"></script>":"") ."
				</head>
				<body". (!$this->isMobile? " style=\"overflow:hidden; height:100%; width:100%; margin:0px; padding:0px;\"":"") . ($iPhone? " onload=\"window.scrollTo(0,1);\"":"") ." >\n"; 
			
			if(!$this->isMobile) 
			{ 
				$out .= "<table id=\"desktop\" border=\"0\">". chr(10) .
						"<tr><td height=20 style=\" background-color:#BBBBBB; font-weight:bold; color:#FFFFFF; padding:3px; font-size:14px;\">{$this->Title} - Phone Emulator</td></tr>". chr(10) .
						"<tr><td align=\"center\" valign=\"center\">". chr(10) .
						"<center>".
						"<div id=\"screen\" >\n";
			}
			
			$out .= "<div id=\"preloader\"></div>\n"; 
			$out .= "<div id=\"stretchy\">\n"; 
			$out .= "	<div id=\"fullScreen\">\n"; 
			
		}
		return $out;
	}
	
	function Footer() 
	{ 
		$out = "";
		
		$iPhone = $this->isIPHONE();
		if($this->ShowFooterLogo) 
		{
			$out .= "<p align=\"center\" class=\"footer\"><br />". chr(10).
					FOOTNOTE_HTML . chr(10).
					"</p>\n";
		}
				
		if($this->isWML()) { 
			$out .= "	</card>". chr(10). 
					"</wml>";
		} else {

			$out .= "	</div>". 
					"</div>\n"; 
					
			if(!$this->isMobile && !$iPhone) 
			{
				$tag = "URL:";
				$url = "http://". $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				$ip = (sizeof($_GET)==0? (strstr($url, "?") == true? "":"?"):"&") ."SessionIP={$_SERVER['REMOTE_ADDR']}";
				
				$out .= "</div>". chr(10).
						"</center>". chr(10).
						"</td></tr>". chr(10).
						"<tr><td height=30 align=\"center\" style=\"font-size:10px; color:#444444;\">".
							"This is a desktop adoptation of the mobile page. Please navigate to this page using your mobile phone.<br />". 
							"{$url}".
							"</td></tr>". chr(10).
						"</table>\n";
						
				if($this->ShowBarcode) {
					$out .="<img src=\"http://www.mobivate.com/QR/?d=". urlencode($tag .$url . $ip) . "\" border=0 alt=\"{$url}\" title=\"{$url}\" style=\"position:fixed; bottom:0px; right:0px;\" />\n";
				}
						
			}
			
			$out .= "</body>". chr(10).
					"</html>";
		} 
		return $out;
	}
}

##########################
function xml2array($url, $get_attributes = 1, $priority = 'tag')
{
    $contents = "";
    if (!function_exists('xml_parser_create'))
    {
        return array ();
    }
    $parser = xml_parser_create('');
    if (!($fp = @ fopen($url, 'rb')))
    {
        return array ();
    }
    while (!feof($fp))
    {
        $contents .= fread($fp, 8192);
    }
    fclose($fp);
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($contents), $xml_values);
    xml_parser_free($parser);
    if (!$xml_values)
        return; //Hmm...
    $xml_array = array ();
    $parents = array ();
    $opened_tags = array ();
    $arr = array ();
    $current = & $xml_array;
    $repeated_tag_index = array ();
    foreach ($xml_values as $data)
    {
        unset ($attributes, $value);
        extract($data);
        $result = array ();
        $attributes_data = array ();
        if (isset ($value))
        {
            if ($priority == 'tag')
                $result = $value;
            else
                $result['value'] = $value;
        }
        if (isset ($attributes) and $get_attributes)
        {
            foreach ($attributes as $attr => $val)
            {
                if ($priority == 'tag')
                    $attributes_data[$attr] = $val;
                else
                    $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
            }
        }
        if ($type == "open")
        {
            $parent[$level -1] = & $current;
            if (!is_array($current) or (!in_array($tag, array_keys($current))))
            {
                $current[$tag] = $result;
                if ($attributes_data)
                    $current[$tag . '_attr'] = $attributes_data;
                $repeated_tag_index[$tag . '_' . $level] = 1;
                $current = & $current[$tag];
            }
            else
            {
                if (isset ($current[$tag][0]))
                {
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    $repeated_tag_index[$tag . '_' . $level]++;
                }
                else
                {
                    $current[$tag] = array (
                        $current[$tag],
                        $result
                    );
                    $repeated_tag_index[$tag . '_' . $level] = 2;
                    if (isset ($current[$tag . '_attr']))
                    {
                        $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                        unset ($current[$tag . '_attr']);
                    }
                }
                $last_item_index = $repeated_tag_index[$tag . '_' . $level] - 1;
                $current = & $current[$tag][$last_item_index];
            }
        }
        elseif ($type == "complete")
        {
            if (!isset ($current[$tag]))
            {
                $current[$tag] = $result;
                $repeated_tag_index[$tag . '_' . $level] = 1;
                if ($priority == 'tag' and $attributes_data)
                    $current[$tag . '_attr'] = $attributes_data;
            }
            else
            {
                if (isset ($current[$tag][0]) and is_array($current[$tag]))
                {
                    $current[$tag][$repeated_tag_index[$tag . '_' . $level]] = $result;
                    if ($priority == 'tag' and $get_attributes and $attributes_data)
                    {
                        $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                    }
                    $repeated_tag_index[$tag . '_' . $level]++;
                }
                else
                {
                    $current[$tag] = array (
                        $current[$tag],
                        $result
                    );
                    $repeated_tag_index[$tag . '_' . $level] = 1;
                    if ($priority == 'tag' and $get_attributes)
                    {
                        if (isset ($current[$tag . '_attr']))
                        {
                            $current[$tag]['0_attr'] = $current[$tag . '_attr'];
                            unset ($current[$tag . '_attr']);
                        }
                        if ($attributes_data)
                        {
                            $current[$tag][$repeated_tag_index[$tag . '_' . $level] . '_attr'] = $attributes_data;
                        }
                    }
                    $repeated_tag_index[$tag . '_' . $level]++; //0 and 1 index is already taken
                }
            }
        }
        elseif ($type == 'close')
        {
            $current = & $parent[$level -1];
        }
    }
    return ($xml_array);
}

?>