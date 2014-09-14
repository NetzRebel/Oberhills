<?php

class Login extends MY_Model
{
    public function validate()
    {
        $post_data = $this->input->post();
        $account = $this->getAccount($post_data['login_email']);
        if(count($account)==0)
        {
            throw new Exception(lang('auth_login_unknown_email_password'));
        }
        $this->load->model('auth/password', 'Password');
        if(!$this->Password->verify($account['password'], $post_data['login_password']))
        {
            throw new Exception(lang('auth_login_unknown_email_password'));
        }
        $this->Visitor->set('isLoggedIn', true);
    }
    
    public function getAccount($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('userAccount');
        return $query->row_array();
    }
}