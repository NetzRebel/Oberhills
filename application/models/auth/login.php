<?php

class Login extends MY_Model
{
    public function __construct()
    {
        $post_data = $this->input->post();
        echo "<pre>";
        var_dump($post_data);
        die();
        throw new Exception("System Error");
    }
}