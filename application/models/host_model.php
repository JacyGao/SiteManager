<?php
/**
 * Created by John Huseinovic
 * Date: 7/11/12
 * Time: 12:31 PM
 */
class Host_model extends CI_Model
{
    var $hostname = "";
    var $sitename = "";
    var $homepage = "";


    function load($hostname)
    {
        $this->db->select('*');
        $this->db->from('hosts');
        $this->db->where('hostname',$hostname);
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
            $this->db->update('hosts', $this, array('id'=>$this->id));
        }
        else
        {
            $this->db->insert('hosts', $this);
        }
    }

    function getAll()
    {
        $this->db->select('*');
        $this->db->from('hosts');
        $this->db->order_by('hostname');
        $query = $this->db->get();
        return $query->result_array();
    }

    function update($id, $key, $value)
    {
        $this->db->update('hosts', array($key=>$value), array('id'=>$id));
    }

}
