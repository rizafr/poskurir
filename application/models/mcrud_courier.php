<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mobile Courier Model
 *
 * @author Sumapala Technologies
 */
class Mcrud_courier extends CI_Model
{

	function __construct()
    {
      parent::__construct();
    }
  
	
	function create($table,$data)
	{
		$this->db->insert($table,$data);
	}
    
    function get_login($email)//done
    {
        $sql = "select login_state from mypos.t_master_kurir where email = '".$email."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        //echo $row['status'];
        return $row['login_state'];
    }
    
    function logged_out($email)//done
    {
        $sql = "UPDATE mypos.t_master_kurir SET login_state = '0' WHERE email = '".$email."'";
        $this->db->query($sql);
    }
    
    function logged_in($email)//done
    {
        $sql = "UPDATE mypos.t_master_kurir SET login_state = '1' WHERE email = '".$email."'";
        $this->db->query($sql);
    }
	
	function get_data($id,$table,$triger)
	{
		$this->db->where($triger,$id);
		$get = $this->db->get($table);
		
		return $get->result();
	}
    
    function look($id1,$id2,$triger1,$triger2,$table)
	{
		$this->db->where($triger1,$id1);
		$this->db->where_not_in($triger2,$id2);
		$get = $this->db->get($table);
		
		return $get->num_rows();
	}
	
	function update($table,$id,$data,$triger)
	{
		$this->db->where($triger,$id);
		$this->db->update($table,$data);
	}
	
    function login($user,$pass)//done
    {
		if(filter_var($user,FILTER_VALIDATE_EMAIL) == FALSE)
		{
			$this->db->select('*')
					 ->from('mypos.t_master_kurir')
					 ->where('password',md5($pass))
					 ->where('username',$user);
		}
		else
		{
			$this->db->select('*')
					 ->from('mypos.t_master_kurir')
					 ->where('password',md5($pass))
					 ->where('email',$user);
		}
				 
        $get = $this->db->get();

        $result = array(
            'row' => $get->num_rows(),
            'result' => current($get->result())
        );

        return $result;
    }
	
	function get_data_courier($email)//done
	{
		$this->db->select('*')
				 ->from('mypos.t_master_kurir')
				 ->where('email',$email);
		$get = $this->db->get();
		return $get->row();
	}
    
    //crud login mobile kurir
    function look_email($email)
	{
		$this->db->where('email',$email);
		$get = $this->db->get('mypos.t_master_kurir');
		
		return $get->num_rows();
	}
    
    function look_password($email,$password)
	{
		$this->db->where('password',md5($password))
                 ->where('email', $email);
		$get = $this->db->get('mypos.t_master_kurir');
		
		return $get->num_rows();
	}
}