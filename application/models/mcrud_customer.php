<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mypos.t_userModel
 *
 * @author Sumapala Technologies
 */
class Mcrud_customer extends CI_Model
{

	function __construct()
    {
      parent::__construct();
    }
  
    function activate($hash)
    {
        $sql = "UPDATE mypos.t_pelanggan SET status = '1' WHERE MD5( email ) = '".$hash."'";
        $this->db->query($sql);
    }
	
	function create($table,$data)
	{
        try
        {
            $this->db->insert($table,$data);
        }
        catch(Exception $e) 
        {
            echo 'Duplicate';
        }
	}
    
    function getstatus($hash)
    {
        $sql = "select status from mypos.t_pelanggan where MD5(email) = '".$hash."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        //echo $row['status'];
        return $row['status'];
    }
    
    function get_login($email)
    {
        $sql = "select status from mypos.t_pelanggan where email = '".$email."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        //echo $row['status'];
        return $row['status'];
    }
    
    function logged_out($email)
    {
        $sql = "UPDATE mypos.t_pelanggan SET login_state = '0' WHERE email = '".$email."'";
        $this->db->query($sql);
    }
    
    function logged_in($email)
    {
        $sql = "UPDATE mypos.t_pelanggan SET login_state = '1' WHERE email = '".$email."'";
        $this->db->query($sql);
    }
	
	function get_data($id,$table,$triger)
	{
		$this->db->where($triger,$id);
		$get = $this->db->get($table);
		
		return $get->result();
	}
	
	function update($table,$id,$data,$triger)
	{
		$this->db->where($triger,$id);
		$this->db->update($table,$data);
	}
	
	function look_user($user)
	{
		$this->db->where('username',$user);
		$get = $this->db->get('mypos.t_user');
		
		return $get->num_rows();
	}
	
	function look_user2($id,$user)
	{
		$this->db->where('username',$user);
		$this->db->where_not_in('id',$id);
		$get = $this->db->get('mypos.t_user');
		
		return $get->num_rows();
	}
	
	function look_email($email)
	{
		$this->db->where('email',$email)
				 ->where('password !=','');
		$get = $this->db->get('mypos.t_pelanggan');
		
		return $get->num_rows();
	}
    
    function look_password($email,$password)
	{
		$this->db->where('password',md5($password))
                 ->where('email', $email);
		$get = $this->db->get('mypos.t_pelanggan');
		
		return $get->num_rows();
	}
    
    
    
    function look_phone($telp)
	{
		$this->db->where('telp',$telp);
		$get = $this->db->get('mypos.t_pelanggan');
		
		return $get->num_rows();
	}
	
	function look_email2($id,$email)
	{
		$this->db->where('email',$email);
		$this->db->where_not_in('id',$id);
		$get = $this->db->get('mypos.t_user');
		
		return $get->num_rows();
	}
	
	function del($table,$id,$triger)
	{
		$this->db->where($triger,$id);
		$this->db->delete($table);
	}
	
	function look_name($name)
	{
		$this->db->where('rolename',$name);
		$get = $this->db->get('mypos.t_user_roles')->num_rows();
		
		return $get;
	}
	
    function login($user,$pass)
    {
		if(filter_var($user,FILTER_VALIDATE_EMAIL) == FALSE)
		{
			$this->db->select('*')
					 ->from('mypos.t_pelanggan')
					 ->where('password',md5($pass))
					 ->where('username',$user);
		}
		else
		{
			$this->db->select('*')
					 ->from('mypos.t_pelanggan')
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
	
	function get_cust($id)
	{
		$this->db->where('mypos.t_pelanggan_id',$id);
		$get = $this->db->get('mypos.t_pelanggan');
		
		return $get->result();
	}
	
	function look($id1,$id2,$triger1,$triger2,$table)
	{
		$this->db->where($triger1,$id1);
		$this->db->where_not_in($triger2,$id2);
		$get = $this->db->get($table);
		
		return $get->num_rows();
	}
    
	
	function get_data_customer($email)
	{
		$this->db->select('*')
				 ->from('mypos.t_pelanggan')
				 ->where('email',$email);
		$get = $this->db->get();
		return $get->row();
	}
}