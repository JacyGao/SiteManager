<?php
/**
 * Created by John Huseinovic
 * Date: 7/11/12
 * Time: 12:31 PM
 */
class Products_model extends CI_Model
{

    function load($path)
    {

        $this->db->select('*');
        $this->db->from('products');
        $this->db->where('path',$path);
        $query = $this->db->get();

        if( $query->num_rows() == 0) return false;

        $rs = $query->row(0);

        foreach($rs as $key=>$val)
        {
            $this->$key = $val;
        }
        return true;
    }

    function update($id, $key, $value)
    {
        $this->db->update('products', array($key=>$value), array('id'=>$id));
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
            $this->db->update('products', $this, array('id'=>$this->id));
        }
        else
        {
            $this->db->insert('products', $this);
        }
    }

    function getAll()
    {
        $this->db->select('*');
        $this->db->from('products');
        $this->db->order_by('name');
        $query = $this->db->get();
        return $query->result_array();
    }

    function getHostProducts($hostid)
    {
        $this->db->select('DISTINCT name, path');
        $this->db->from('products');
        $this->db->join('hosts_products', 'hosts_products.pid = products.path');
        $this->db->where('hid',$hostid);
        $this->db->order_by('name');

        $query = $this->db->get();
        return $query->result_array();
    }
}
