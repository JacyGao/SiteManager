<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Populate_countries extends CI_Migration
{

    public function up()
    {
        $this->config->load('countries');

        $countries = $this->config->item('countries');

        foreach( $countries as $iso=>$rs )
        {
            $data = array();
            $data['iso'] = $iso;
            $data['name'] = $rs['name'];
            $data['currency'] = $rs['currency'];
            $data['prefix'] = $rs['prefix'];
            $data['minlength'] = $rs['min-length'];
            $data['maxlength'] = $rs['max-length'];
            $data['placeholder'] = $rs['placeholder'];
            $data['example'] = $rs['example'];
            $this->db->insert('countries', $data);


        }
    }

    public function down()
    {
        $this->db->truncate('countries');
    }

}