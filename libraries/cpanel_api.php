<?php
//load parent class
require 'cpanel/cpanel_api_query.php';

//load child class
require 'cpanel/cpanel_api_email.php';
require 'cpanel/cpanel_api_subdomain.php';
require 'cpanel/cpanel_api_statsbar.php';
require 'cpanel/cpanel_api_stats.php';

/**
 * Description of Cpanel_Api
 *
 * @author Lalu Erfandi Maula Yusnu at nunenuh@gmail.com
 * @license LGPL 2
 * @copyright @ 2011
 * @link http://www.vthink.web.id
 * @link http://gen5x4.wordpress.com
 * @name Cpanel_Json
 * @version 1.0.0
 */
class Cpanel_Api {
    private $CI;
    private $param=array();
    private $email;
    
    
    /**
     *
     * @param type $param is an array
     * 
     */
    public function __construct($param=array()){
        $this->CI = & get_instance();
        $param_config=$this->CI->config->item('cpanel');
        
        if (isset($param_config) && is_array($param_config)){
            $this->param = $param_config;
        } else {
             $this->param = $param;
        }
        
        log_message('debug','initalized class cpanel_api');
    }
    
    public function mail(){
	return new Cpanel_Api_Email($this->param);
    }
    
    public function stats_bar(){
        return new Cpanel_Api_Statsbar($this->param);
    }
    
    public function subdomain(){
        return new Cpanel_Api_Subdomain($this->param);
    }
    
    public function stats(){
        return new Cpanel_Api_Stats($this->param);
    }

    public function getConfig(){
        return $this->param;
    }
        
        
}

