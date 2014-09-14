<?php

class Meta extends MY_Model
{
    protected $project_name = 'Oberhills';
    protected $title = '';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function getTitle()
    {
        if($this->title!='')
        {
            return $this->project_name
                . ' - '
                . lang($this->title);
        }
        else
        {
            return $this->project_name;
        }
    }
    
    public function getLanguageCode()
    {
        return 'en';
    }
    
    public function getDescription()
    {
        return "website_meta_description";
    }
    
    public function getAuthor()
    {
        return "David Schneider";
    }
}