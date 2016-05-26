<?php
class Chat_model extends MY_Model
{
    var $Logo_Image = "";
    var $Show_About = 1;


    function getProfiles()
    {
        $this->load->database();
        $query = $this->db->query('SELECT * FROM chat_profiles');
        $rows = array();
        foreach ($query->result_array() as $row)
        {
            array_push($rows, $row);
        }

        return $rows;
    }

    function getProfile($id)
    {
        $this->load->database();
        $query = $this->db->query('SELECT * FROM chat_profiles WHERE ID = '.$id);
        $row = $query->row_array();

        return $row;
    }

    function search($gender, $country, $city, $age_from, $age_to)
    {
        $this->load->database();
        $query = $this->db->query("SELECT * FROM chat_profiles WHERE gender = '".$gender."'
        AND country LIKE '%".$country."%'
        AND city LIKE '%".$city."%'
        AND age BETWEEN ".$age_from." AND ".$age_to);
        $rows = array();
        foreach ($query->result_array() as $row)
        {
            array_push($rows, $row);
        }

        return $rows;
    }

    function addMember($usr, $pass, $email)
    {
        $this->load->database();
        $this->db->query("INSERT INTO chat_members set username='{$usr}', password='{$pass}', email='{$email}'");
    }

    function getMember($usr,$pass)
    {
        $query = $this->db->query("SELECT * FROM chat_members WHERE username='{$usr}' AND password='{$pass}'");
        if ($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}