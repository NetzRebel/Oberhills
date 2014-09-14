<?php

class Registration extends MY_Model
{
    protected $form_data;
    
    public function prepare()
    {
        // check if registration is enabled
        $this->config->load('registration', true, true);
        if(!$this->config->item('registrations_accepted', 'registration'))
        {
            throw new Exception(lang('signup_registration_registration_disabled'));
        }
        
        // make business logic checks
        $this->form_data = $this->input->post();
        unset($this->form_data['signup_email_repeat']);
        unset($this->form_data['signup_password_repeat']);
        $this->checkEmail();
        $this->validateNames();
        //$this->checkAge();
    }
    
    public function checkAge()
    {
        $min_age = $this->config->item('registrations_min_age', 'registration');
        if($min_age)
        {
            $now = new DateTime();
            $now->sub(new DateInterval('P'.$min_age.'Y'));
            $birthday = new DateTime($this->form_data['signup_birthday']);
            $age_diff = $now->diff($birthday);
        }
    }
    
    public function checkEmail()
    {
        $this->db->where('email', $this->form_data['signup_email']);
        $query = $this->db->get('userAccount');
        if($query->num_rows()>0)
        {
            throw new Exception(lang('signup_registration_email_already_used'));
        }
    }
    
    public function validateNames()
    {
        if(!preg_match("/^[a-zA-Z\s,.'-\pL]+$/u", $this->form_data['signup_first_name']))
        {
            throw new Exception(lang("signup_registration_invalid_firstname"));
        }
        if(!preg_match("/^[a-zA-Z\s,.'-\pL]+$/u", $this->form_data['signup_last_name']))
        {
            throw new Exception(lang("signup_registration_invalid_lastname"));
        }
    }
    
    public function create()
    {
        $this->prepare();
        $this->load->model('auth/password', 'Password');
        $password = $this->Password->encrypt($this->form_data['signup_password']);
        $createdOn = date('Y-m-d H:i:s');
        $registration = array(
            'email'     => $this->form_data['signup_email'],
            'password'  => $password,
            'lastName'  => $this->form_data['signup_last_name'],
            'firstName' => $this->form_data['signup_first_name'],
            'birthday'  => $this->form_data['signup_birthday'],
            'createdOn' => $createdOn
        );
        $this->db->insert(
            'userAccount',
            $registration
        );
    }
}