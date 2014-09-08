<?php

class Doc extends MY_Model
{
    public $Meta;
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('html/meta', 'MetaModel');
        $this->Meta = $this->MetaModel;
    }
}