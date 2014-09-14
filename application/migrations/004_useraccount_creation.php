<?php

class Migration_Useraccount_creation extends CI_Migration
{
    public function up()
    {   
        $fields = array(
            'createdOn' => array(
                'type' =>'DATETIME',
                'null' => FALSE,
                'default' => '0000-00-00'
            )
        );
        $this->dbforge->add_column('userAccount', $fields);
    }
    
    public function down()
    {
        $this->dbforge->drop_column('userAccount', 'createdOn');
    }
}