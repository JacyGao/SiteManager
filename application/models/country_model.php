<?php
/**
 * Created by John Huseinovic
 * Date: 7/11/12
 * Time: 12:31 PM
 */
class Country_model extends CI_Model
{

    var $id = 0;
    var $name = "Undefined";
    var $prefix;
    var $example;
    var $minlength;
    var $maxlength;
    var $placeholder;
    var $selectnetwork = 0;

    function load($iso)
    {
        $this->db->select('*');
        $this->db->from('countries');
        $this->db->where('iso',$iso);
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
            $this->db->update('countries', $this, array('id'=>$this->id));
        }
        else
        {
            $this->db->insert('countries', $this);
        }
    }

    function update($id, $key, $value)
    {
        $this->db->update('countries', array($key=>$value), array('id'=>$id));
    }


    function getAll()
    {
        $this->db->select('*');
        $this->db->from('countries');
        $this->db->order_by('name');
        $query = $this->db->get();
        return $query->result_array();
    }

}
