<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Assetor {

    private $_css_folder;
    private $_css_min_folder;
    private $_js_folder;
    private $_js_min_folder;
    private $_version = '';
    private $_styles = array();
    private $_modified_styles = array();
    private $_gcc = FALSE;
    private $_gcc_level = 'WHITESPACE_ONLY';
    protected $_CI;

    function __construct()
    {
        $this->_CI =& get_instance();
        $this->_CI->config->load('assetor',TRUE);
        $this->_gcc = $this->_CI->config->item('gcc','assetor');
        $this->_gcc_level = $this->_CI->config->item('gcc_level','assetor');
        $this->_css_folder = $this->_CI->config->item('css_folder', 'assetor');
        if($this->_CI->config->item('css_min_folder', 'assetor'))
        {
            $this->_css_min_folder =  $this->_CI->config->item('css_min_folder', 'assetor');
        }
        else
        {
            $this->_css_min_folder =  $this->_css_folder;
        }
        $this->_js_folder = $this->_CI->config->item('js_folder', 'assetor');
        if($this->_CI->config->item('js_min_folder', 'assetor'))
        {
            $this->_js_min_folder =  $this->_CI->config->item('js_min_folder', 'assetor');
        }
        else
        {
            $this->_js_min_folder =  $this->_js_folder;
        }
        $this->_version = $this->_CI->config->item('version','assetor');
    }

    /**
     * clear()
     * 
     * Clears the variables of the Assetor class
     */
    public function clear()
    {
        $this->_styles = array();
        $this->_modified_styles = array();
    }
	
    /**
     * load($filename, group = 'main')
     * 
     * Loads a style/script to a group of assets
     * 
     * @param string $filename - the filename, including its extension
     * @param string $group (optional) - the group of assets that the file will be added to. Defaults to 'main'
     * 
     * @return  void
     * 
     */
    public function load($filename, $group = 'main')
    {
        $allowed_ext = array('css','js');
        $ext = substr(strrchr($filename, "."), 1);
        if(!in_array($ext, $allowed_ext))
        {
            show_error('Assetor: Couldn\'t load file <strong>'.$filename.'</strong>. The file must have <strong>.css</strong> extension. <strong>'.$ext.'</strong> given.',500);
        }
        if(substr($filename,0,2)!="//")
        {
            switch ($ext) {
                case 'css':
                $loc = $this->_css_folder;
                break;

                case 'js':
                $loc = $this->_js_folder;				
                break;
            }
            if(!read_file($loc.$filename))
            {
                show_error('Assetor: The file <strong>'.$filename.'</strong> doesn\'t seem to exist in '.$loc.' or is empty. Please verify its presence and check the config file of assetor.',500);
            }
        }
        $this->_styles[$group][$ext][] = $filename;
    }
	
    /**
     * version($ver)
     * 
     * Sets a version name/value for the assets
     * 
     * @param string $ver (optional) - the version name/value that you want appended to the files if you want a forced reload from browser. Defaults to time() if called without param
     * 
     * @return void
     */
    public function version($ver = NULL)
    {
        if(!isset($ver))
        {
            $ver = time();
        }
        $this->_version = $ver;
    }
	
	/**
	 * merge($forced = FALSE)
	 * 
	 * Merges all the files of same group in one/two files that has the name as the group name. Example: main.css + main.js.
	 * 
	 * @param bool $forced (optional) - force a rewrite if there are existing files. Defaults to false;
	 * 
	 * @return file(s)
	 */
    public function merge($forced = FALSE)
    {
        if(empty($this->_styles))
        {
            show_error('Assetor: There are no assets to join. Please make sure you loaded them.');
        }
        foreach($this->_styles as $groupname => $group)
        {
            if(empty($group))
            {
                show_error('Assetor: There are no assets in group <strong>'.$group.'</strong>. Please remove it or fill it with assets.');
            }
            foreach($group as $filetype=>$files)
            {
                switch ($filetype) {
                    case 'css':
                        $exist_file = $this->_css_min_folder.$groupname.'.css';
                        break;

                    case 'js':
                        $exist_file = $this->_js_min_folder.$groupname.'.js';
                        break;
                }
                if($forced || !read_file($exist_file))
                {
                    {
                        $this->_join_files($groupname, $filetype, $files);
                    }
                    if(!empty($this->_modified_styles))
                    {
                        foreach($this->_modified_styles as $group=>$filetypes)
                        {
                            foreach($filetypes as $filetype=>$lines)
                            {
                                $this->_write_file($filetype,$lines,$group);
                            }
                        }
                    }
                }
                else
                {
                    show_error('Assetor: The merged files already exist. Can\'t overwrite them unless specifically asked for. Try $this->assetor->merge(TRUE)');
                    return FALSE;					
                }
            }
        }
    }
	
    /**
     * _write_file($filetype, $lines, $filename)
     * 
     * Writes files and returns true or error in case of error
     * 
     * @param string $filetype('css'|'js') - type of file (extension)
     * @param string $lines - lines of code to be written inside the file
     * @param string $filename - name of file without extension
     * 
     * @return bool
     */
    private function _write_file($filetype, $lines,$filename)
    {
        switch ($filetype) {
            case 'css':
                $loc = $this->_css_min_folder;
                break;

            case 'js':
                $loc = $this->_js_min_folder;				
                break;
        }
        $file = $loc.$filename.'.'.$filetype;
        if (!write_file($file, $lines))
        {
            show_error('Assetor: Unable to write the merged files. Make sure the folder exists and the folder and file are writable');
        }
        else
        {
            return true;
        }
    }
	
    /**
     * minify($forced = FALSE)
     * 
     * Minifies the files that are loaded inside the groups of assets
     * 
     * @param bool $forced (optional) - force a rewrite if there are existing files. Defaults to false;
     * 
     * @return file(s)
     * 
     */
    public function minify($forced = FALSE)
    {
        if(empty($this->_modified_styles))
        {
            $this->merge($forced);
        }
        if(!empty($this->_modified_styles))
        {
            foreach($this->_modified_styles as $groupname=>$group)
            {
                foreach($group as $filetype=>$lines)
                {
                    switch ($filetype)
                    {
                        case 'js':
                            if($this->_gcc)
                            {
                                $url = 'http://closure-compiler.appspot.com/compile';
                                $fields_string = 'output_info=compiled_code&output_format=text&compilation_level='.$this->_gcc_level.'&js_code='.urlencode($lines);
                                //open connection
                                $ch = curl_init($url);
                                //set the url, number of POST vars, POST data
                                curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
                                curl_setopt($ch,CURLOPT_POST, 1);
                                curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
                                //curl_setopt($ch, CURLOPT_PROXY, 'xxx.xxx.xxx.xxx:8080');
                                //execute post
                                $compressed_js = curl_exec($ch);
                                echo $compressed_js;
                                //close connection
                                curl_close($ch);
                                echo $compressed_js;
                                exit();
                                if($compressed_js)
                                {
                                    $lines = $compressed_js;
                                }
                            }
                            else
                            {
                                // Remove comments
                                $lines = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $lines);
                                $lines = preg_replace('!\/\/.*!','',$lines);

                                // Remove space after colons
                                $lines = str_replace(': ', ':', $lines);

                                // Remove new lines, tabs
                                $lines = str_replace(array("\r\n", "\r", "\n", "\t"), '', $lines);
                            }
                            break;

                            case 'css':
                                // Remove comments
                                $lines = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $lines);

                                // Remove space after colons
                                $lines = str_replace(': ', ':', $lines);

                                // Remove new lines, tabs
                                $lines = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $lines);
                                //Remove last semicolon before closing bracket
                                $lines = str_replace(';}','}',$lines);
                            break;
                        }					
                    $this->_modified_styles[$groupname][$filetype] = $lines;					
                    $this->_write_file($filetype,$lines,$groupname);
                }
            }
        }
        else
        {
            show_error('Assetor: Nothing to minify.');
        }
    }

    /**
     * _join_files($groupname, $filetype, $files)
     * 
     * Joins files that are part of the same group and of the same type (extension)
     * 
     * @param string $groupname - the name of the group of assets
     * @param string $filetype - the type (extension) of the files
     * @param array $files - array of files
     * 
     * @return void
     */
    private function _join_files($groupname,$filetype, $files)
    {
        if(in_array($filetype, array('css','js')))
        {
            $lines = '';
            foreach($files as $file)
            {
                switch ($filetype) {
                    case 'css':
                        $loc = $this->_css_folder;
                        break;

                    case 'js':
                        $loc = $this->_js_folder;				
                        break;
                }
                $lines .= read_file($loc.$file);
            }
            $this->_modified_styles[$groupname][$filetype] = $lines;
        }
    }
	
    /**
     * generate($group = 'main')
     * 
     * Generates the html for importing the external assets
     * 
     * @param string $group - group name. Defaults to 'main'
     * 
     * @return string
     */
    public function generate($group = 'main')
    {
        $assets = '';
        if(read_file($this->_css_min_folder.$group.'.css') || read_file($this->_js_min_folder.$group.'.js'))
        {
            if(read_file($this->_css_min_folder.$group.'.css'))
            {
                $assets .='<link rel="stylesheet" href="'.site_url($this->_css_min_folder.$group.'.css?v='.$this->_version).'" />';
            }
            if(read_file($this->_js_min_folder.$group.'.js'))
            {
                $assets .='<script type="text/javascript" src="'.site_url($this->_js_min_folder.$group.'.js?v='.$this->_version).'"></script>';
            }
        }
        else
        {
            ksort($this->_styles[$group]);
            foreach($this->_styles[$group] as $filetype=>$files)
            {
                foreach($files as $file)
                {
                    switch ($filetype) {
                        case 'css':
                            if(substr($file,0,2)=="//")
                            {
                            $assets .='<link rel="stylesheet" href="'.$file.'?v='.$this->_version.'" />';
                            }
                            else
                            {
                            $assets .='<link rel="stylesheet" href="'.site_url($this->_css_folder.$file.'?v='.$this->_version).'" />';
                            }
                        break;
                        case 'js':
                            if(substr($file,0,2)=="//")
                            {
                            $assets .='<script type="text/javascript" src="'.$file.'?v='.$this->_version.'"></script>';
                            }
                            else
                            {
                            $assets .='<script type="text/javascript" src="'.site_url($this->_js_folder.$file.'?v='.$this->_version).'"></script>';
                            }
                        break;
                    }
                }
            }
        }
        return $assets;
    }
}
