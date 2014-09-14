<?php

class Migration_Userdata extends CI_Migration
{
    public function up()
    {
        // table for user session dada
        $this->dbforge->add_field(array(
            'session_id' => array(
                'type' =>'VARCHAR',
                'constraint' => 40,
                'default' => 0,
                'null' => FALSE
            ),
                'ip_address' => array(
                'type' =>'VARCHAR',
                'constraint' => 16,
                'default' => 0
            ),
                'user_agent' => array(
                'type' =>'VARCHAR',
                'constraint' => 120
            ),
                'last_activity' => array(
                'type' =>'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'default' => 0
            ),
                'user_data' => array(
                'type' =>'text'
            )
        ));

        $this->dbforge->add_key('session_id', TRUE); // primary key
        $this->dbforge->add_key('last_activity');
        
        $this->dbforge->create_table('userData');
        
        // table for user accounts
        $this->dbforge->add_field("id int(11) unsigned NOT NULL AUTO_INCREMENT");
        $this->dbforge->add_field("email varchar(255) NOT NULL");
        $this->dbforge->add_field("password varchar(255) NOT NULL");
 
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->add_key('email');
        
        $this->dbforge->create_table('userAccount', TRUE);
    }
    
    public function down()
    {
        $this->dbforge->drop_table('userAccount');
        $this->dbforge->drop_table('userData');
    }
}