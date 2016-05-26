<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of orderModel
 *
 * @author PT. Pos Indonesia
 */
class Mcrud_order extends CI_Model
{

	function __construct()
    {
      parent::__construct();
	  
    }
	
	function create($table,$data)
	{
		$this->db->insert($table,$data);
	}
    
    function createlog($table,$data)
	{
		$this->db->insert($table,$data);
	}
    
    function get_order_id($email)
    {
        $sql = "select status from customers where email = '".$email."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        //echo $row['status'];
        return $row['status'];
    }
    
    function set_assign($courier_id)
    {
        $sql = "update couriers set assign = '0' where courier_id = '".$courier_id."'";
        $this->db->query($sql);
    }
	
	function update($id,$triger,$data,$table)
	{
		$this->db->where($triger,$id);
		$this->db->update($table,$data);
	}
    
    function getOrderByCourier($courier_id)
    {   
		$this->db->where('courier_id',$courier_id);
		$get = $this->db->get('orders');
        
		return $get->result();     
    }
    
    function getOrderDetail($courier_id)
    {
        $sql = "SELECT orders.*, (SELECT customers.nama FROM customers WHERE customers.customers_id = orders.customers_id) as cust_name,(SELECT customers.nama FROM customers WHERE telp = orders.telp_pickup) as nama_pengirim,(SELECT customers.nama FROM customers WHERE telp = orders.telp_delivery) as nama_penerima, (SELECT customers.telp FROM customers WHERE telp = orders.telp_pickup) as telp_pickup, (SELECT customers.telp FROM customers WHERE telp = orders.telp_delivery) as telp_delivery, (SELECT tarif.harga FROM tarif WHERE tarif.tarif_id = orders.tarif_id) as harga FROM orders 
                WHERE orders.courier_id = '".$courier_id."' AND ((orders.status_delv_id > 1 AND orders.status_delv_id < 4) OR orders.status_delv_id = 5 OR orders.status_delv_id = 6)";
        $query = $this->db->query($sql);
        return $query->result(); 
    }
    
    function getDetailFrom($order_id)
    {
        $this->db->select('*')
				 ->from('orders')
				 ->where('order_id',$order_id);
		$get = $this->db->get();
		
		return $get->result();
    }
    
    function detail_logs($id)
	{
		$this->db->select('customers.nama as cust_name, customer1.nama as pickup_name, couriers.nama as curs_name, customer2.nama as delv_name, order_logs.*, orders.detail_barang')
				 ->distinct()
				 ->from('orders')
				 ->join('customers','customers.customers_id = orders.customers_id')
				 ->join('order_logs','order_logs.order_id = orders.order_id')
				 ->join('couriers','couriers.courier_id = orders.courier_id','left')
				 ->join('customers as customer1','customer1.email = orders.email_pickup')
				 ->join('customers as customer2','customer2.email = orders.email_delivery')
				 ->where('orders.order_id',$id)
                 ->group_by('order_logs.status_delv_id');
		
		$get = $this->db->get();
		
		if($get->num_rows() > 0)
		{
			return $get->result();
		}
		else
		{
			return 0;
		}
	}
    
    function getCourierByOrder($order_id)
    {
        $sql = "select courier_id from orders where order_id = '".$order_id."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['courier_id'];
    }
    
    function get_detail($id)
	{
		$this->db->select('orders.*,customers.nama as cust_name,tarif.layanan, tarif.harga')
				 ->from('orders')
				 ->where('orders.order_id',$id)
				 ->join('customers','customers.customers_id = orders.customers_id')
				 ->join('tarif','tarif.tarif_id = orders.tarif_id');
		
		$get = $this->db->get();
		
		return $get->result();
	}
    
    function get_delivery($data)
	{
		$this->db->select('*')
				 ->from('customers')
				 ->where('telp',$data);
		
		$get = $this->db->get();
		
		if($get->num_rows() > 0)
		{
			return current($get->result());
		}
		else
		{
			return FALSE;
		}
	}
    
    function get_email($id)
	{
		$this->db->select('*')
				 ->from('couriers')
				 ->where('courier_id',$id);
		
		$get = $this->db->get();
		
		return $get->result();
	}
}