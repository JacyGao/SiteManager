<?php
    /**
     * Created by John Huseinovic
     * Date: 15/11/12
     * Time: 5:07 PM
     * Updated by Jacy Gao
     * Date: 19/06/13
     * Time: 5:25 PM
     */

require_once( dirname(__FILE__) ."/portal_model.php");

class LandingPage_model extends Portal_model
{
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
   function getLoginFlow()
    {
        $login = (array)$this->safe_get('Login_Flow');;

        if($this->agent->is_mobile())
            return $login['mobile'];
        else
            return $login['web'];
    }
}// class
