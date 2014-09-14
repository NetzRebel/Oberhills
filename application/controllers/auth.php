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
    
    public function logout()
    {
        // no need to logout twice
        if(!$this->Visitor->isLoggedIn())
        {
            redirect('/', 'refresh');
        }
        $this->Visitor->logout();
        $this->Visitor->sendMessage(lang('auth_logout_successful'));
        redirect('/', 'refresh');
    }
    
    public function signup()
    {
        // no need to signup twice
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
                $this->display('auth/signup_success');
                return;
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