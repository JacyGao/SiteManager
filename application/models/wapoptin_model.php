<?php
    /**
     * Created by John Huseinovic
     * Date: 15/11/12
     * Time: 5:07 PM
     */
class WapOptin_model extends MY_Model
{
    var $Higate_User_Key;
    var $Higate_Header_Image;
    var $Higate_Helpline;
    var $Subscribe_To_PSS = array(0=>'No', 1=>'Yes');
    var $Redirect_On_Success;

    function getHigateProduct($shortcode, $keyword)
    {
	$query = "SELECT * FROM pss_higate_products WHERE shortcode={$shortcode} and FIND_IN_SET('{$keyword}', keywords)";
        $results = $this->db->query($query);

        if($results->num_rows() == 0)
            return null;

        return $results->row();
    }

    function saveVisitor($ip, $subid, $date)
    {
        $query = "INSERT INTO wapdoi_tracking(ip, subid, time) VALUES ('".$ip."', '".$subid."', '".$date."')";
        $this->db->query($query);
    }

    function checkVisitor($ip)
    {
        $query = "SELECT subid FROM wapdoi_tracking WHERE ip = '".$ip."'";
        $result = $this->db->query($query);
        if ($result->num_rows() > 0)
        {
            $row = $result->row();
            return $row->subid;
        }
        else
        {
            return NULL;
        }
    }
}
