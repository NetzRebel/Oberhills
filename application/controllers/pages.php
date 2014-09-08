<?php

class Pages extends MY_Controller
{
    public function index()
    {
        return $this->lander();
    }
    
    public function lander()
    {
        $this->display('pages/welcome');
    }
}