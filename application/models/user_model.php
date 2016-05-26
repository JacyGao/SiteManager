<?php
/**
 * Created by John Huseinovic
 * Date: 7/11/12
 * Time: 12:31 PM
 */
class User_model extends CI_Model
{

    var $id = 0;
    var $username;
    var $password;

    function load($username)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('username',$username);
        $query = $this->db->get();

        if( $query->num_rows() == 0) return false;

        $rs = $query->row(0);

        foreach($rs as $key=>$val)
        {
            $this->$key = $val;
        }
        return true;
    }

    function create($input)
    {
        unset($this->id);
        foreach($input as $key=>$val)
        {
            $this->$key = $val;
        }

        $this->save();
    }

    function save()
    {
        
        if( isset($this->id) )
        {
            $this->db->update('users', $this, array('id'=>$this->id));
        }
        else
        {
            $this->db->insert('users', $this);
        }
    }

    function update($id, $key, $value)
    {
        $this->db->update('users', array($key=>$value), array('id'=>$id));
    }


    function getAll()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->order_by('username');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getHosts($userID)
    {
        $access = $this->db->get_where("users_hosts", array("userid"=>$userID));
        if( $access->num_rows() == 0 )
            return false;

        return $access->result();

    }

    function grant($userid, $hostid)
    {
        $this->db->insert('users_hosts', array('userid'=>$userid, 'hostid'=>$hostid));
    }

    function revoke($userid, $hostid)
    {
        $this->db->delete('users_hosts', array('userid'=>$userid, 'hostid'=>$hostid));
    }

}
