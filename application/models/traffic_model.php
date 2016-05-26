<?php
/**
 * Created by John Huseinovic
 * Date: 8/01/13
 * Time: 1:52 PM
 */
class Traffic_model extends CI_Model
{
    var $configid;
    var $keyword;
 #   var $pixel;

    function load($configid, $keyword)
    {
        $this->db->select('*');
        $this->db->from('traffic');
        $this->db->where('configid',$configid);
        $this->db->where('keyword',$keyword);
        $query = $this->db->get();

        if( $query->num_rows() == 0)
        {
            $this->configid = $configid;
            $this->keyword = $keyword;
            log_message('error',"Traffic Config Not found ({$configid},{$keyword})");
            return false;
        }

        $rs = $query->row(0);

        foreach($rs as $key=>$val)
        {
            $this->$key = $val;
        }
        log_message('debug',"Traffic Config found ({$configid},{$keyword}) @ #{$this->id}");
        return $this;
    }

    function update($id, $key, $value)
    {
        $this->db->update('traffic', array($key=>$value), array('id'=>$id));
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

        foreach($this as $key=>$val)
        {
            $this->db->set($key,$val);
        }

        if( isset($this->id) )
        {
            $this->db->where('id', $this->id);
            $this->db->update('traffic');
        }
        else
        {
            $this->db->insert('traffic');
            $this->id = $this->db->insert_id();
        }
    }

    function getAll($configid)
    {
        $this->db->select('*');
        $this->db->from('traffic');
        $this->db->where('configid', $configid);
        $query = $this->db->get();
        return $query->result_array();
    }

    function getKeywords($configid)
    {
        $results = $this->getAll($configid);
        $out = array();
        foreach($results as $rs)
        {
            $out[] = $rs['keyword'];
        }
        return $out;
    }

    function increment($fields)
    {
        # If Keyword doesn't exist (ie. No ID) then Auto-Create one right now!
        if(!isset($this->id))
        {
            $this->save();
        }

        if(is_array($fields))
        {
            foreach($fields as $field)
            {
                $this->db->set($field, "{$field}+1", false);
                $this->db->set("{$field}_total", "{$field}_total+1", false);
            }
        }
        else
        {
            $this->db->set($fields, "{$fields}+1", false);
            $this->db->set("{$fields}_total", "{$fields}_total+1", false);
        }

        $this->db->where('id', $this->id );
        $this->db->update('traffic');
        return true;
    }


}
