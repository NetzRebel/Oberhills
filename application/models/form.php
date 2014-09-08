<?php

class Form extends MY_Model
{
    public $FormName = false;
    public $FormConfig;
    public $PostData;
    
    public function __construct()
    {
        parent::__construct();
        // prepare the form stuff
        $this->load->helper('form');
        $this->load->helper($this->config->item('default_template'));
        $this->lang->load('form', $this->Visitor->get('language'));
    }
    
    public function getHTML()
    {
        if(!$this->FormName) throw new Exception ("No form loaded");
        $html = render_form($this->FormConfig);
        return $html;
    }
    
    public function load($form_name)
    {
        $this->FormName = "forms/$form_name";
        $this->config->load($this->FormName, true);
        $this->FormConfig = $this->config->item('form', $this->FormName);
    }
    
    public function validate()
    {
        $this->load->library('form_validation');
        
        $config = array();
        foreach($this->FormConfig['inputs'] as $name => $input_data)
        {
            if(isset($input_data["validation"]))
            {
                $config[] = array(
                    'field' => $name,
                    'label' => lang($name.'_form_label'),
                    'rules' => $input_data["validation"]
                );
            }
        }
        $this->form_validation->set_rules($config);
        
        $this->form_validation->set_message('required', lang('form_validation_required_message'));
        
        $this->form_validation->set_error_delimiters('', '');
        
        if($this->form_validation->run() == false)
        {
            throw new Exception(lang('Invalid_form_values_on_submit_message'));
        }
    }
    
    public function submitted()
    {
        $this->PostData = $this->input->post();
        return (bool)$this->PostData;
    }
}