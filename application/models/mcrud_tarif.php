<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of crud_tarifModel
 *
 * @author Temmy Rustandi Hidayat
 */
class Mcrud_tarif extends CI_Model
{

	function __construct()
    {
      parent::__construct();
    }
	
	function get_tarif()
    {
        $this->db->select('*')
                 ->from('tarif');
        $get = $this->db->get();
        
        return $get->result();
    
    }

}