<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mobile Courier Controller
 *
 * @author PT. Pos Indonesia
 */
class Mobtest extends CI_Controller{

	function __construct()
    {
      parent::__construct();
      $url = 'iot.eclipse.org';
      $port = 1883;
      $label = 'poskurir';
      $this->load->library('phpmqtt',$url, $port, $label);
    }
    
    function login()
    {
        echo "prom mqtt";
    }
}