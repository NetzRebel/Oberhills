<?php

class MY_Controller extends CI_Controller
{
    protected $template;
    
    public function __construct()
    {
        parent::__construct();
        
        // prepare models
        $this->load->model('Visitor');
        $this->load->model('html/doc','HTMLDOC');
        
        // set + load language
        $language = $this->Visitor->get('language');
        $controller = strtolower(get_class($this));
        $this->lang->load($controller, $language);
        
        // load template config
        $this->config->load('template');
        // prepare template
        $this->template = $this->config->item('default_template');
        // prepare assets
        foreach($this->config->item('css_files') as $location => $files)
        {
            foreach($files as $file) $this->assetor->load($file, $location);
        }
        foreach($this->config->item('js_files') as $location => $files)
        {
            foreach($files as $file) $this->assetor->load($file, $location);
        }
    }
    
    public function display($view, $view_data = array())
    {
        $template_data = array(
            'content' => $this->load->view($view, $view_data, true)
        );
        
        $template_data['systemmessages'] = $this->Visitor->getMessages();
        $this->load->view('templates/' . $this->template, $template_data);
    }
}