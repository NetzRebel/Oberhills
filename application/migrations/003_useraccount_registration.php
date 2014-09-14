<?php

class Migration_Useraccount_registration extends CI_Migration
{
    public function up()
    {   
        $fields = array(
            'verified' => array(
                'type' =>'TINYINT',
                'constraint' => 1,
                'null' => FALSE,
                'default' => '0'
            )
        );
        $this->dbforge->add_column('userAccount', $fields);
    }
    
    public function down()
    {
        $this->dbforge->drop_column('userAccount', 'verified');
    }
}