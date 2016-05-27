<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mypos.t_userModel
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
		$this->db->select('*, mypos.tr_user_roles.rolename, (select nama_grup from mypos.tr_grup where id_grup = mypos.t_user.role_id) as nama_grup')
				 ->from('mypos.t_user')
				 ->join('mypos.tr_user_roles','mypos.tr_user_roles.role_id = mypos.t_user.role_id');
		$get = $this->db->get();
		
		return $get->result();
	}
	
	function get_roles()
	{
		$this->db->select('*')
				 ->from('mypos.tr_user_roles');
		$get = $this->db->get();
		
		return $get->result();
	}

	function get_cabang()
	{
		$this->db->select('*')
				 ->from('mypos.tr_grup');
		$get = $this->db->get();
		
		return $get->result();
	}

	function src_cabang($id)
	{
		//$this->db->where('hasBusiness','0');
		$this->db->where('id_grup',$id);
				 //->where('login_state','1');
		$get = $this->db->get('mypos.tr_grup');
		
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
		$this->db->where('email',$email);
		$get = $this->db->get('mypos.t_user');
		
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
		$get = $this->db->get('mypos.tr_user_roles')->num_rows();
		
		return $get;
	}
	
	function look_name2($id,$name)
	{
		$this->db->where('rolename',$name);
		$this->db->where_not_in('role_id',$id);
		$get = $this->db->get('mypos.tr_user_roles')->num_rows();
		
		return $get;
	}
    
    function aktif($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('mypos.t_user',$data);
    }
    
    function non_aktif($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update('mypos.t_user',$data);
    }
}