<?php
defined('BASEPATH') OR exit('No direct script access allowed'); // alter to adapt to Codeigniter

/**
 * Description of conexaoAPI
 *
 * @author Guilherme
 */
class Conexaoapi extends Routerosapi{
    private $CI;
    
    function __construct() {
       $this->CI =& get_instance();
       $this->CI->load->database();
    }
   
    public function connectAPI($balance=false){
        
        if($balance){
            $balanceHost = $this->CI->Config_model->getDecode('balanceHost');
            $balanceUsername = $this->CI->Config_model->getDecode('balanceUsername');
            $balanceSenha = $this->CI->Config_model->getDecode('balanceSenha');
            return $this->CI->RouterosAPI->connect($balanceHost, $balanceUsername, $balanceSenha);
        }else{
            $concentradorHost = $this->CI->Config_model->getDecode('concentradorHost');
            $concentradorUsername = $this->CI->Config_model->getDecode('concentradorUsername');
            $concentradorSenha = $this->CI->Config_model->getDecode('concentradorSenha');
            return $this->connect($concentradorHost, $concentradorUsername, $concentradorSenha);
        }
        
    }
}
