<?php

class Visitor extends MY_Model
{
    protected $Messages;
    protected $UserData;
    
    public function __construct()
    {
        parent::__construct();
        
        // no session without this
        $this->load->library('session');
        
        // load userdata
        $this->load();
        
        // get existing system messages or create array for them
        $this->Messages = $this->session->userdata('SystemMessages');
        if(!$this->Messages)
        {
            $this->Messages = array();
        }
    }
    
    /* 
     * Message stuff for telling the visitor stories
     */
    public function getMessages()
    {
        $this->session->set_userdata('SystemMessages', array());
        $messages = $this->Messages;
        $this->Messages = array();
        return $messages;
    }
    
    public function sendMessage($message, $type = 'info')  // success, info, warning or danger
    {
        $this->Messages[$type][] = $message;
        $this->session->set_userdata('SystemMessages', $this->Messages);
    }
    
    /*
     * Login stuff
     */
    public function isLoggedIn()
    {
        if(isset($this->UserData['isLoggedIn']))
        {
            if($this->UserData['isLoggedIn'])
            {
                return true;
            }
        }
        return false;
    }
    
    public function login()
    {
        $this->load->model('auth/Login');
        $this->Login->validate();
    }
    
    public function register()
    {
        $this->load->model('auth/Registration');
        $this->Registration->create();
    }
    
    /*
     * get, set, delete, and load userdata
     */
    public function get($key)
    {
        if(array_key_exists($key,$this->UserData))
        {
            return $this->UserData[$key];
        }
        else
        {
            throw new Exception("Invalid Visitor data key ".$key);
        }
    }
    
    public function set($key, $value)
    {
        $this->UserData[$key] = $value;
        $this->update();
    }
    
    public function delete($key)
    {
        if(array_key_exists($key,$this->UserData))
        {
            unset($this->UserData[$key]);
            $this->update();
        }
        else
        {
            throw new Exception("Invalid Visitor data key ".$key);
        }   
    }
    
    public function load()
    {   
        $this->UserData = $this->session->userdata('UserData');
        if(!$this->UserData)
        {
            // generate user data and update session storage
            $this->UserData = array(
                'language' => 'english'
            );
            $this->update();
        }
    }
    
    public function logout()
    {
        $this->session->unset_userdata('UserData');
    }

    public function update()
    {
        $this->session->set_userdata('UserData', $this->UserData);
    }
}