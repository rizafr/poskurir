<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usersModel
 *
 * @author Temmy Rustandi Hidayat
 */
class Crud_user extends CI_Model
{

	function __construct()
    {
      parent::__construct();
    }
	
	function read()
	{
		$this->db->select('users.*, user_roles.rolename')
				 ->from('users')
				 ->join('user_roles','user_roles.role_id = users.role_id');
		$get = $this->db->get();
		
		return $get->result();
	}
	
	function get_roles()
	{
		$this->db->select('*')
				 ->from('user_roles');
		$get = $this->db->get();
		
		return $get->result();
	}
	
	function create($table,$data)
	{
		$this->db->insert($table,$data);
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
		$get = $this->db->get('users');
		
		return $get->num_rows();
	}
	
	function look_user2($id,$user)
	{
		$this->db->where('username',$user);
		$this->db->where_not_in('id',$id);
		$get = $this->db->get('users');
		
		return $get->num_rows();
	}
	
	function look_email($email)
	{
		$this->db->where('email',$email);
		$get = $this->db->get('users');
		
		return $get->num_rows();
	}
	
	function look_email2($id,$email)
	{
		$this->db->where('email',$email);
		$this->db->where_not_in('id',$id);
		$get = $this->db->get('users');
		
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
		$get = $this->db->get('user_roles')->num_rows();
		
		return $get;
	}
	
	function look_name2($id,$name)
	{
		$this->db->where('rolename',$name);
		$this->db->where_not_in('role_id',$id);
		$get = $this->db->get('user_roles')->num_rows();
		
		return $get;
	}
    
    function aktif($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('users',$data);
    }
    
    function non_aktif($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('users',$data);
    }
}