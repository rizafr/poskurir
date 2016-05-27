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
class Crud_customer extends CI_Model
{

	function __construct()
    {
      parent::__construct();
    }
    
	function read()
	{
		$this->db->select('mypos.t_user.*, mypos.t_user_roles.rolename')
				 ->from('mypos.t_user')
				 ->join('mypos.t_user_roles','mypos.t_user_roles.role_id = mypos.t_user.role_id');
		$get = $this->db->get();
		
		return $get->result();
	}
	
    /*
	function get_login($email, $password)
	{
		$this->db->select('*')
				 ->from('mypos.t_pelanggan')
                 ->where('email', $email)
                 ->where('password', md5($password));
		$get = $this->db->get();
		
		return $get->result();
	}
    */
    
    function activate($hash)
    {
        $sql = "UPDATE mypos.t_pelanggan SET status = '1' WHERE MD5( email ) = '".$hash."'";
        $this->db->query($sql);
    }
	
	function create($table,$data)
	{
		$this->db->insert($table,$data);
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
		$this->db->where('email',$email);
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
	
	function look_name2($id,$name)
	{
		$this->db->where('rolename',$name);
		$this->db->where_not_in('role_id',$id);
		$get = $this->db->get('mypos.t_user_roles')->num_rows();
		
		return $get;
	}
	
	function read_cust()
	{
		$this->db->where('password !=', '');
				 //->where('login_state','1');
		$get = $this->db->get('mypos.t_pelanggan');
		
		return $get->result();
	}
	
	function src_cust($id)
	{
		//$this->db->where('hasBusiness','0');
		$this->db->where('status',$id);
				 //->where('login_state','1');
		$get = $this->db->get('mypos.t_pelanggan');
		
		return $get->result();
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
		print_r ($get);
		return $get->row();
	}
	
	function non_aktif($id)
	{
		$data['status'] = 0;
		$this->db->where('mypos.t_pelanggan_id',$id);
		$this->db->update('mypos.t_pelanggan',$data);
	}
	
	function aktif($id)
	{
		$data['status'] = 1;
		$this->db->where('mypos.t_pelanggan_id',$id);
		$this->db->update('mypos.t_pelanggan',$data);
	}
	
	//LEAD CUSTOMERS
	function get_lead()
	{
		$this->db->select('mypos.t_pelanggan.nama as cust_name, person_pickup.nama as pickup_name, person_pickup.alamat as almt_pickup, person_delivery.nama as name_dlv, person_delivery.alamat as almt_dlv, person_pickup.no_hp as phone1, person_delivery.no_hp as phone2,mypos.t_transaksi_order.order_id,mypos.t_pelanggan.mypos.t_pelanggan_id')
				 ->from('mypos.t_pelanggan')
				 ->join('mypos.t_transaksi_order','mypos.t_transaksi_order.mypos.t_pelanggan_id = mypos.t_pelanggan.mypos.t_pelanggan_id')
				 ->join('person_pickup','person_pickup.email_pickup = mypos.t_transaksi_order.email_pickup')
				 ->join('person_delivery','person_delivery.email_delivery = mypos.t_transaksi_order.email_delivery');
		$get = $this->db->get();
		
		return $get;
	}
	
	function get_detail($id)
	{
		$this->db->where('mypos.t_pelanggan_id',$id);
		$get = $this->db->get('mypos.t_pelanggan');
		
		if($get->num_rows() > 0)
		{
			return $get->result();
		}
		else
		{
			return 0;
		}
	}
}