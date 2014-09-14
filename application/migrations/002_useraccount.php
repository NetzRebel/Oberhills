<?php

class Migration_Useraccount extends CI_Migration
{
    public function up()
    {   
        $fields = array(
            'firstName' => array(
                'type' =>'VARCHAR',
                'constraint' => 40,
                'null' => FALSE,
                'default' => ''
            ),
            'lastName' => array(
                'type' =>'VARCHAR',
                'constraint' => 40,
                'null' => FALSE,
                'default' => ''
            ),
            'birthday' => array(
                'type' =>'DATE',
                'null' => FALSE,
                'default' => '0000-00-00'
            )
        );
        $this->dbforge->add_column('userAccount', $fields);
    }
    
    public function down()
    {
        $this->dbforge->drop_column('userAccount', 'birthday');
        $this->dbforge->drop_column('userAccount', 'lastName');
        $this->dbforge->drop_column('userAccount', 'firstName');
    }
}