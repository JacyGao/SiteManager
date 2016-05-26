<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_databases extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'hostid' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'countryid' => array(
                'type' => 'INT',
                'constraint' => 11,
            ),
            'countrynum' => array(
                'type' => 'INT',
                'constraint' => 3,
            ),
            'config' => array(
                'type' => 'BLOB',
            ),
        ));
        $this->dbforge->add_key( array('hostid','countryid','countrynum'), TRUE );
        $this->dbforge->create_table('configs');

        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'iso' => array(
                'type' => 'VARCHAR',
                'constraint' => 2,
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => 15,
            ),
            'currency' => array(
                'type' => 'VARCHAR',
                'constraint' => 10,
            ),
            'prefix' => array(
                'type' => 'INT',
                'constraint' => 5,
            ),
            'minlength' => array(
                'type' => 'INT',
                'constraint' => 2,
            ),
            'maxlength' => array(
                'type' => 'INT',
                'constraint' => 2,
            ),
            'placeholder' => array(
                'type' => 'VARCHAR',
                'constraint' => 5,
            ),
            'example' => array(
                'type' => 'VARCHAR',
                'constraint' => 20,
            ),
        ));
        $this->dbforge->add_key('iso');
        $this->dbforge->create_table('countries');

        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'hostname' => array(
                'type' => 'VARCHAR',
                'constraint' => 30,
            ),
            'sitename' => array(
                'type' => 'VARCHAR',
                'constraint' => 50,
            ),
            'homepage' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
            ),
        ));
        $this->dbforge->add_key('hostname');
        $this->dbforge->create_table('hosts');


        $this->dbforge->add_field('id');
        $this->dbforge->add_field(array(
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => 30,
            ),
            'descr' => array(
                'type' => 'TEXT',
            ),
            'path' => array(
                'type' => 'VARCHAR',
                'constraint' => 15,
            ),
        ));
        $this->dbforge->add_key('path', TRUE);
        $this->dbforge->create_table('products');
    }

    public function down()
    {
        $this->dbforge->drop_table('configs');
        $this->dbforge->drop_table('countries');
        $this->dbforge->drop_table('hosts');
        $this->dbforge->drop_table('products');
    }

}