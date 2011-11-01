<?php

/**
 * Class for call Query json api in CPANEL
 * 
 */
class Cpanel_Api_Query{
    private $host;
    private $port;
    private $username;
    private $password;
    private $api;
    private $ssl;
    private $hash;
    
    
    function __construct($param=array()) {
        $this->hash     = base64_encode($param['username'] . ':' . $param['password']);
        $this->host     = $param['host'];
        $this->port     = intval($param['port']);
        $this->ssl      = $param['ssl'] ? 'https://' : 'http://';
        $this->password = $param['password'];
        $this->username = $param['username'];
        $this->api      = 'json-api/cpanel?';
    }

    /**
     *
     * @param type $query
     * @return type 
     */
    public function query($query){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0); 	
        curl_setopt($curl, CURLOPT_HEADER,0);			
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);	
        $header[0] = "Authorization:  Basic " . $this->hash . "\n\r";
        curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
        curl_setopt($curl, CURLOPT_URL, $query);
        $result = curl_exec($curl);
        if ($result == false) {
            error_log("curl_exec threw error \"" . curl_error($curl) . "\" for $query");
        }
        curl_close($curl);

        return $result;
    }
    
    /**
     *
     * @param type $param
     * @return type 
     */
    public function build_query($param=array()){
        $base=$this->ssl.$this->host.':'.$this->port.'/'.$this->api;
        $build=$this->__build($param);
        return $base.$build;
    }
    
    /**
     *
     * @param type $param
     * @return string 
     */
    public function __build($param=array()){
        $check=count($param);
        $out='';
        if ($check==2){
            $out='cpanel_jsonapi_module='.$param['module'].'&';
            $out.='cpanel_jsonapi_func='.$param['function'];
        } else {
            $out='cpanel_jsonapi_module='.$param['module'].'&';
            $out.='cpanel_jsonapi_func='.$param['function'].'&';
        }
        
        $a=1;
        foreach ($param as $key => $val){
           if (($key!='function')&&($key!='module')){
               if ($a<=$check-2){
                   $out.=$key.'='.$val.'&';
               } else {
                    $out.=$key.'='.$val;
               }
           }
           $a++;
        }
        return $out;
    }
}
