<?php

class Auth extends MY_Controller
{
    public function index()
    {
        $this->login();
    }
    
    public function login()
    {
        // no need to login twice
        if($this->Visitor->isLoggedIn())
        {
            redirect('/', 'refresh');
        }
        
        // load form data
        $this->load->model('Form');
        $this->Form->load('login_form');
        
        // post submitted?
        if($this->Form->submitted())
        {
            try
            {
                $this->Form->validate();
                $this->Visitor->login();
                redirect('/', 'refresh');
            }
            catch (Exception $ex)
            {
                // login failed
                $this->Visitor->sendMessage($ex->getMessage(),'danger');
            }
        }
        
        // display login form
        $view_data = array(
            'Form' => $this->Form->getHTML()
        );
        $this->display('auth/login', $view_data);
    }
    
    public function signup()
    {
        // no need to login twice
        if($this->Visitor->isLoggedIn())
        {
            redirect('/', 'refresh');
        }
        
        // load form data
        $this->load->model('Form');
        $this->Form->load('signup_form');
        
        // post submitted?
        if($this->Form->submitted())
        {
            try
            {
                $this->Form->validate();
                $this->Visitor->register();
                redirect('/', 'refresh');
            }
            catch (Exception $ex)
            {
                // login failed
                $this->Visitor->sendMessage($ex->getMessage(),'danger');
            }
        }
        
        // display login form
        $view_data = array(
            'Form' => $this->Form->getHTML()
        );
        $this->display('auth/signup', $view_data);
    }
        
}