<?php

class Pages extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        return $this->lander();
    }
    
    public function lander()
    {
        $this->display('pages/welcome');
    }
    
    public function not_found()
    {
        $this->display('pages/not_found');
    }
}