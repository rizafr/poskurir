<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of loginModel
 *
 * @author Temmy Rustandi Hidayat
 */
class Login extends CI_Model{

	function __construct()
    {
      parent::__construct();

    }

    function login($user,$pass)
    {
		if(filter_var($user,FILTER_VALIDATE_EMAIL) == FALSE)
		{
			$this->db->select('*')
					 ->from('users')
					 ->where('password',$pass)
					 ->where('username',$user);
		}
		else
		{
			$this->db->select('*')
					 ->from('users')
					 ->where('password',$pass)
					 ->where('email',$user);
		}
				 
        $get = $this->db->get();

        $result = array(
            'row' => $get->num_rows(),
            'result' => current($get->result())
        );

        return $result;
    }
	
	function signup($data)
	{
		$this->db->insert('users',$data);
	}
	
	function activate($status,$code)
	{
		$this->db->where('md5(email)',$code);
		$this->db->update('customers',$status);
	}
}