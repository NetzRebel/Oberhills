<?php

define('SALT_LENGTH', 9);

class Password extends MY_Model
{
    public function encrypt($password, $salt = null)
    {
        if ($salt === null)
        {
            $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
        }
        else
        {
            $salt = substr($salt, 0, SALT_LENGTH);
        }

        return $salt . sha1($salt . $password);
    }
    
    public function verify($stored, $input)
    {
        $salt = substr($stored, 0, SALT_LENGTH);
        $stored_password = substr($stored, SALT_LENGTH);
        return (sha1($salt . $input) == $stored_password);
    }
}