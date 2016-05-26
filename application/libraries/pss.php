<?php
/**
 * Created by John Huseinovic
 * Date: 19/12/12
 * Time: 2:44 PM
 */
define("PSS_FREE_SERVICES", "free");
define("PSS_BILLED_SERVICES", "billed");
define("PSS_ALL_SERVICES", null);

class pss
{
    private $username;
    private $password;

    function pss($conf=array())
    {
        if(isset($conf['username']))
            $this->username = $conf['username'];

        if(isset($conf['password']))
            $this->password = $conf['password'];

    }

    function getUserServices($filter=PSS_ALL_SERVICES)
    {
        $url = "http://{$this->username}:{$this->password}@apps.mobivate.com/pss/system/scripts/userservices.php";
        #echo "request url {$url}";

        $services = simplexml_load_file($url);
        $out = array();

        if($filter == PSS_FREE_SERVICES)
        {
            if( count($services->free->service) == 0 )
                return array();
            else
            {
                foreach($services->free->service as $service)
                {
                    $a = $service->attributes();
                    #$out[ (int)$a['accessnumber'] ][PSS_FREE_SERVICES] = array('id'=>(int)$a['id'], 'name'=>(string)$a['name']);
                    $out[PSS_FREE_SERVICES][ (int)$a['accessnumber'] ] = array('id'=>(int)$a['id'], 'name'=>(string)$a['name']);
                }
            }
        }

        if($filter == PSS_BILLED_SERVICES)
        {
            if( count($services->billed->service) == 0 )
                return array();
            else
            {
                foreach($services->billed->service as $service)
                {
                    $a = $service->attributes();
                    ##$out[ (int)$a['accessnumber'] ][PSS_BILLED_SERVICES] = array('id'=>(int)$a['id'], 'name'=>(string)$a['name']);
                    $out[PSS_BILLED_SERVICES][ (int)$a['accessnumber'] ] = array('id'=>(int)$a['id'], 'name'=>(string)$a['name']);
                }
            }
        }

        if($filter == PSS_ALL_SERVICES)
        {
            if( count($services->free)+count($services->billed) == 0 )
                return array();
            else
            {
                foreach($services->free->service as $service)
                {
                    $a = $service->attributes();
                    #$out[ (int)$a['accessnumber'] ][PSS_FREE_SERVICES] = array('id'=>(int)$a['id'], 'name'=>(string)$a['name']);
                    $out[PSS_FREE_SERVICES][ (int)$a['accessnumber'] ] = array('id'=>(int)$a['id'], 'name'=>(string)$a['name']);
                }
                foreach($services->billed->service as $service)
                {
                    $a = $service->attributes();
                    #$out[ (int)$a['accessnumber'] ][PSS_BILLED_SERVICES] = array('id'=>(int)$a['id'], 'name'=>(string)$a['name']);
                    $out[PSS_BILLED_SERVICES][ (int)$a['accessnumber'] ] = array('id'=>(int)$a['id'], 'name'=>(string)$a['name']);
                }
            }
        }

        return $out;
    }

    private function getPSSObject($table, $id, $field="id")
    {
        $results = file_get_contents("http://{$this->username}:{$this->password}@apps.mobivate.com/pss/system/oo/rest.php?table={$table}&{$field}={$id}");

        $results = str_replace("<object {$table}>","<object>", $results);

        if(strstr($results, "No such record") == true)
            return false;

        $xml = @simplexml_load_string($results);
        return $xml;

    }

    function getServiceInfo($id)
    {
        return $this->getPSSObject("pss_services", $id);
    }

    function getChannelInfo($id)
    {
        return $this->getPSSObject("pss_channel", $id);
    }

    function getChannelRules($id)
    {
        return $this->getPSSObject("pss_channel_rules", $id, "channelid");
    }

    function IsKeywordAvailable($serviceid,$keyword, $channelid="-1")
    {
        $xml = simplexml_load_file("http://{$this->username}:{$this->password}@apps.mobivate.com/pss/admin/ajax/keywordcheck/keywordcheck.php?word={$keyword}&service={$serviceid}&channel={$channelid}");
        return count($xml->ajaxaction) == 0;
    }

    function addKeywordToChannel(&$chan, $kw)
    {
        $url = "http://apps.mobivate.com/pss/system/oo/rest.php";

        $chan->keywords .= ",". trim($kw);

        $chanXML = $chan->asXML();

        # strip the XML header
        $chanXML = substr($chanXML, strpos($chanXML, "<object"));

        # fix the <object wrapper for PSS to understand it.
        $chanXML = str_replace("<object>", "<object pss_channel>", $chanXML);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
        curl_setopt($ch, CURLOPT_USERPWD, "{$this->username}:{$this->password}");
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "xml=". $chanXML );

        $results = curl_exec($ch);

        return true;
    }

    function CreateChannel($name, $kws,$billed_service,$free_service,$subscription_rules=array(), $library=1874, $hitURL=NULL)
    {
        $url = "http://apps.mobivate.com/pss/admin/channelmgt.php";
        $params = array();
        $params['channelid'] = "-1";
        $params['kws'] = "{$kws}";
        $params['action'] = "apply";
        $params['active'] = "1";
        $params['contentlib'] = $library;
        $params['primser'] = "{$billed_service}";
        $params['secser'] = "{$free_service}";
        $params['channelname'] = "{$name}";
        $params['channeltz'] = "311"; # Melb/Aus
        $params['polldays'] = $params['pollhours'] = $params['pollmins'] = "0";
        $params['pollmon'] = $params['polltue'] = $params['pollwed'] = $params['pollthu'] = $params['pollfri'] = $params['pollsat'] = $params['pollsun'] = "0";

        if(count($subscription_rules) > 0)
            $params['subresrulelist'] = implode(",",$subscription_rules); #"{S:1}{R:42}{D:0}{U:http://www.site.com}{B:3}";

        if($hitURL)
        {
            $params['alwayshiturl'] = "1";
            $params['hiturl[url]'] = $hitURL;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
        curl_setopt($ch, CURLOPT_USERPWD, "{$this->username}:{$this->password}");
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        $results = curl_exec($ch);

        if(strstr($results,"The following validation errors") == true)
            return false;


        return true;


//alwayshiturl:0
//hiturl[url]:
//hiturl[time]:0
//optinrequest:0
//lang:0
//optinrequestmsg[0]:
//optinrequestmsg[1]:
//optinrequestmsg[2]:
//optinrequestbilled:0
//optinrequestbilled_cost:0
//lang:0
//optinrequestmsgbilled[0]:
//optinrequestmsgbilled[1]:
//optinrequestmsgbilled[2]:
//subsendfree:0
//lang:0
//subsendfreemsg[0]:
//subsendfreemsg[1]:
//subsendfreemsg[2]:
//subsendbilled:0
//subsendbilled_cost:0
//lang:0
//subsendbilledmsg[0]:
//subsendbilledmsg[1]:
//subsendbilledmsg[2]:
//subsendwelcomeonce:0
//subsendcontent:0
//subsendcontent_cost:0
//subssendcontent_free:0
//subsendfixed:0
//subsendfixed_cost:0
//lang:0
//subsendfixedcontent[0]:
//subsendfixedcontent[1]:
//subsendfixedcontent[2]:
//subssendfixed_free:0
//lang:0
//subssendfixedcontent_free[0]:
//subssendfixedcontent_free[1]:
//subssendfixedcontent_free[2]:
//contentdelay[day]:0
//contentdelay[hr]:0
//contentdelay[min]:0
//expmessages:0
//pausecountsendbilled:0
//pausecountsendbilled_cost:0
//lang:0
//pausecountsendbilledmsg[0]:
//pausecountsendbilledmsg[1]:
//pausecountsendbilledmsg[2]:
//pausecountsendfree:0
//lang:0
//pausecountsendfreemsg[0]:
//pausecountsendfreemsg[1]:
//pausecountsendfreemsg[2]:
//expdays:0
//exphours:0
//expmins:0
//pausetimesendbilled:0
//pausetimesendbilled_cost:0
//lang:0
//pausetimesendbilledmsg[0]:
//pausetimesendbilledmsg[1]:
//pausetimesendbilledmsg[2]:
//pausetimesendfree:0
//lang:0
//pausetimesendfreemsg[0]:
//pausetimesendfreemsg[1]:
//pausetimesendfreemsg[2]:
//pausesendfree:0
//lang:0
//pausesendfreemsg[0]:
//pausesendfreemsg[1]:
//pausesendfreemsg[2]:
//pausesendbilled:0
//pausesendbilled_cost:0
//lang:0
//pausesendbilledmsg[0]:
//pausesendbilledmsg[1]:
//pausesendbilledmsg[2]:
//remindercount:0
//remindersendbilled:0
//remindersendbilled_cost:0
//lang:0
//remindersendbilledmsg[0]:
//remindersendbilledmsg[1]:
//remindersendbilledmsg[2]:
//remindersendfree:0
//lang:0
//remindersendfreemsg[0]:
//remindersendfreemsg[1]:
//remindersendfreemsg[2]:
//pcstemplate:0
//lang:0
//pcstemplatemsg[0]:
//pcstemplatemsg[1]:
//pcstemplatemsg[2]:
//helpsendbilled:0
//helpsendbilled_cost:0
//lang:0
//helpsendbilledmsg[0]:
//helpsendbilledmsg[1]:
//helpsendbilledmsg[2]:
//helpsendfree:0
//lang:0
//helpsendfreemsg[0]:
//helpsendfreemsg[1]:
//helpsendfreemsg[2]:
//nonfin_days:0
//nonfin_msgs:0
//qdbgti:1
//yinbzd:
//bvmjfm:D
//qsshua:42
//stwssqcheck:1
//stwssq:
//ytchvr:
//rixket:
//lgyktl:3
//actionruleid:0
//ojctvk:{S:1}{R:42}{D:0}{U:http://www.site.com}{B:3}
    }

    function ServiceKeywordExists($shortcode, $keyword)
    {
        if(strstr($keyword," ") == true)
        {
            $parts = explode(" ", $keyword);
            $keyword = $parts[0];
        }

        $url = "http://unsubscribe:unsubscribe@apps.mobivate.com/pss/kwfind.php?kw={$keyword}&sc={$shortcode}&format=json";
        $results = file_get_contents($url);
        log_message("info", "ServiceKeywordExists({$shortcode},{$keyword}) => {$url} :: {$results}");
        $json = json_decode($results);

        return $json->Total;
    }
}
