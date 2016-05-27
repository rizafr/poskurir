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
        $sql = "select status from mypos.t_pelanggan where email = '".$email."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        //echo $row['status'];
        return $row['status'];
    }
    
    function set_assign($courier_id)
    {
        $sql = "update mypos.t_master_kurir set assign = '0' where courier_id = '".$courier_id."'";
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
		$get = $this->db->get('mypos.t_transaksi_order');
        
		return $get->result();     
    }
    
    function getOrderDetail($courier_id)
    {
        $sql = "SELECT mypos.t_transaksi_order.*, (SELECT mypos.t_pelanggan.nama FROM mypos.t_pelanggan WHERE mypos.t_pelanggan.mypos.t_pelanggan_id = mypos.t_transaksi_order.mypos.t_pelanggan_id) as cust_name,(SELECT mypos.t_pelanggan.nama FROM mypos.t_pelanggan WHERE telp = mypos.t_transaksi_order.telp_pickup) as nama_pengirim,(SELECT mypos.t_pelanggan.nama FROM mypos.t_pelanggan WHERE telp = mypos.t_transaksi_order.telp_delivery) as nama_penerima, (SELECT mypos.t_pelanggan.telp FROM mypos.t_pelanggan WHERE telp = mypos.t_transaksi_order.telp_pickup) as telp_pickup, (SELECT mypos.t_pelanggan.telp FROM mypos.t_pelanggan WHERE telp = mypos.t_transaksi_order.telp_delivery) as telp_delivery, (SELECT tarif.harga FROM tarif WHERE tarif.tarif_id = mypos.t_transaksi_order.tarif_id) as harga FROM mypos.t_transaksi_order 
                WHERE mypos.t_transaksi_order.courier_id = '".$courier_id."' AND ((mypos.t_transaksi_order.status_delv_id > 1 AND mypos.t_transaksi_order.status_delv_id < 4) OR mypos.t_transaksi_order.status_delv_id = 5 OR mypos.t_transaksi_order.status_delv_id = 6)";
        $query = $this->db->query($sql);
        return $query->result(); 
    }
    
    function getDetailFrom($order_id)
    {
        $this->db->select('*')
				 ->from('mypos.t_transaksi_order')
				 ->where('order_id',$order_id);
		$get = $this->db->get();
		
		return $get->result();
    }
    
    function detail_logs($id)
	{
		$this->db->select('mypos.t_pelanggan.nama as cust_name, customer1.nama as pickup_name, mypos.t_master_kurir.nama as curs_name, customer2.nama as delv_name, order_logs.*, mypos.t_transaksi_order.detail_barang')
				 ->distinct()
				 ->from('mypos.t_transaksi_order')
				 ->join('mypos.t_pelanggan','mypos.t_pelanggan.mypos.t_pelanggan_id = mypos.t_transaksi_order.mypos.t_pelanggan_id')
				 ->join('order_logs','order_logs.order_id = mypos.t_transaksi_order.order_id')
				 ->join('mypos.t_master_kurir','mypos.t_master_kurir.courier_id = mypos.t_transaksi_order.courier_id','left')
				 ->join('mypos.t_pelanggan as customer1','customer1.email = mypos.t_transaksi_order.email_pickup')
				 ->join('mypos.t_pelanggan as customer2','customer2.email = mypos.t_transaksi_order.email_delivery')
				 ->where('mypos.t_transaksi_order.order_id',$id)
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
        $sql = "select courier_id from mypos.t_transaksi_order where order_id = '".$order_id."'";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        return $row['courier_id'];
    }
    
    function get_detail($id)
	{
		$this->db->select('mypos.t_transaksi_order.*,mypos.t_pelanggan.nama as cust_name,tarif.layanan, tarif.harga')
				 ->from('mypos.t_transaksi_order')
				 ->where('mypos.t_transaksi_order.order_id',$id)
				 ->join('mypos.t_pelanggan','mypos.t_pelanggan.mypos.t_pelanggan_id = mypos.t_transaksi_order.mypos.t_pelanggan_id')
				 ->join('tarif','tarif.tarif_id = mypos.t_transaksi_order.tarif_id');
		
		$get = $this->db->get();
		
		return $get->result();
	}
    
    function get_delivery($data)
	{
		$this->db->select('*')
				 ->from('mypos.t_pelanggan')
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
				 ->from('mypos.t_master_kurir')
				 ->where('courier_id',$id);
		
		$get = $this->db->get();
		
		return $get->result();
	}
}