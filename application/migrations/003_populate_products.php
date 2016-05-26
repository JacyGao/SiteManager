<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Populate_products extends CI_Migration
{

    public function up()
    {
        $this->config->load('products');

        $products = $this->config->item('products');

        foreach( $products as $path=>$rs )
        {
            $data = array();
            $data['name'] = $rs['name'];
            $data['path'] = $path;
            $this->db->insert('products', $data);


        }
    }

    public function down()
    {
        $this->db->truncate('products');
    }

}