<?php
/**
 * Created by John Huseinovic
 * Date: 7/11/12
 * Time: 12:31 PM
 */
class Pixel_model extends CI_Model
{
    private $siteconfig;
    private $keyword;

    function init(&$siteconfig, $keyword)
    {
        $this->siteconfig = &$siteconfig;
        $this->keyword = $keyword;
    }

    function get($type)
    {
        $confid = $this->siteconfig->getConfigID();
        $ci = &get_instance();
        $ci->load->model('Traffic_model');
        $pixels = $ci->Traffic_model->getAll($confid);

        if(sizeof($pixels) == 0)
        {
            log_message('info', "TRAFFIC : No Traffic configs found for {$confid}");
            return false;
        }

        $out = array();
        foreach($pixels as $pixel)
        {
            if($pixel['keyword'] == $this->keyword && $pixel['pixeltype'] == $type && trim($pixel['pixel']))
                $out[ $pixel['id'] ] = $pixel['pixel'];
        }

        if(count($out) == 0)
        {
            log_message('info', "TRAFFIC : No Pixels found found for {$confid}/{$this->keyword} [{$type}]");
            return false;
        }
        $ids = array_keys($out);

        log_message('info', "TRAFFIC : Pixels found found for {$confid}/{$this->keyword} [{$type}] (". implode(",", $ids) .")");

        $this->db->set('pixelfired', 'pixelfired+1', false);
        $this->db->set('pixelfired_total', 'pixelfired_total+1', false);
        $this->db->where_in('id', $ids );
        $this->db->update('traffic');

        return implode("\n", $out);

    }

    function save($msisdn)
    {
        $this->load->helper('string');

        $confid = $this->siteconfig->getConfigID();

        $ci = &get_instance();
        $ci->load->model('Traffic_model');
        if(!$ci->Traffic_model->load($confid, $this->keyword))
        {
            log_message('info', "TRAFFIC : No Traffic config found for {$confid}/{$this->keyword}");
            return false;
        }

//        if(!$ci->Traffic_model->pixel)
//        {
//            log_message('info', 'TRAFFIC : No Traffic pixel found #{$ci->Traffic_model->id}');
//            return false;
//        }

        $data = array();
        $data['configid'] = $confid;
        $data['shortcode'] = $this->siteconfig->getShortcode();
        $data['keyword'] = $this->keyword;
        $data['msisdn'] = $msisdn;

        $query = array();
        $query = $this->session->userdata('QUERY_STRING');

        # Pixel tracking instances

        /* Mobiforce pixel tracking url uses mfParam, convert it to subid */
        if(isset($query['mfParam']))
        {
            $subid = $query['mfParam'];

            $data['query']['subid'] = $subid;
            $data['query'] = json_encode($data['query']);
            //exit(print_r($data['query']));
        }
        else if(isset($query['path']))
        {
            $subid = $query['path'];
            $transaction_id = $query['transaction_id'];
            $data['query']['subid'] = $subid;
            $data['query']['transaction_id'] = $transaction_id;
            $data['query'] = json_encode($data['query']);
        }
        // new affiliate added by Mo - START

        else if(isset($query['CID'])&& isset($query['ClickID']))
        {
            $subid = $query['CID'];
            $ClickID = $query['ClickID'];
            $data['query']['subid'] = $subid;
            $data['query']['ClickID'] = $ClickID;
            $data['query'] = json_encode($data['query']);
        }
        // new affiliate added by Mo - END

        // Monster CPA / Inmobi S2S
        else if(isset($query['clickID']))
        {
            $subid = $query['clickID'];

            $data['query']['subid'] = $subid;
            $data['query'] = json_encode($data['query']);
        }

        else if(isset($query['ClickID']))
        {
            $subid = $query['ClickID'];

            $data['query']['subid'] = $subid;
            $data['query'] = json_encode($data['query']);
        }

        else if(isset($query['clickid']))
        {
            $subid = $query['clickid'];

            $data['query']['subid'] = $subid;
            $data['query'] = json_encode($data['query']);
        }

        /* Maroon Tech */
        else if(isset($query['click_id']))
        {
            $subid = $query['click_id'];

            $data['query']['subid'] = $subid;
            $data['query'] = json_encode($data['query']);
        }

        /* Ringtone Partner */
        else if(isset($query['uc']))
        {
            $subid = $query['uc'];

            $data['query']['subid'] = $subid;
            $data['query'] = json_encode($data['query']);
        }
        /* reporo */
        else if(isset($query['rcid']))
        {
            $subid = $query['rcid'];

            $data['query']['subid'] = $subid;
            $data['query'] = json_encode($data['query']);
        }
        /* DSNR */
        else if(isset($query['ymid']))
        {
            $subid = $query['ymid'];

            $data['query']['subid'] = $subid;
            $data['query'] = json_encode($data['query']);
        }
        /* Spiroox */
        else if(isset($query['CID_SPX']))
        {
            $cid_spx = $query['CID_SPX'];            

            $data['query']['subid'] = $cid_spx;
            $data['query']['ID_LEAD'] = random_string('alnum', 10);
            $data['query'] = json_encode($data['query']);
        }
        /* Wap optin pixel tracking */
        else if($this->session->userdata('waptracking'))
        {
            {
                $subid = $this->session->userdata('waptracking');

                $data['query']['subid'] = $subid;
                $data['query'] = json_encode($data['query']);
            }
        }
        else
        {
            $data['query'] = json_encode($this->session->userdata('QUERY_STRING'));
        }
        $data['created'] = date("Y-m-d H:i:s");

        $this->db->insert('pixel_queue', $data);
        return true;
    }
}
