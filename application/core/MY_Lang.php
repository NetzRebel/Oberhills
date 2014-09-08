<?php

class MY_Lang extends CI_Lang
{
    public function line($line = '')
    {
        $value = parent::line($line);
        if($value)
        {
            return $value;
        }
        else
        {
            return $line;
        }
    }
}