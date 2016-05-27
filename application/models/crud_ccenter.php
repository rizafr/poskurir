<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of orderModel
 *
 * @author Temmy Rustandi Hidayat
 */
class Crud_ccenter extends CI_Model
{

	function __construct()
    {
      parent::__construct();
	  
    }

	function read($table)
	{
		$get = $this->db->get($table);
		return $get->result();
	}
	
	function create($table,$data)
	{
		$this->db->insert($table,$data);
	}
	
	function look($post,$triger)
	{
		$this->db->where($triger,$post);
		$get = $this->db->get('mypos.t_master_kurir');
		
		return $get->num_rows();
	}
	
	function look2($id,$post,$triger)
	{
		$this->db->where($triger,$post);
		$this->db->where_not_in('courier_id',$id);
		$get = $this->db->get('mypos.t_master_kurir');
		
		return $get->num_rows();
	}
	
	function get_courier($id,$triger,$table)
	{
		$this->db->where($triger,$id);
		$get = $this->db->get($table);
		
		return $get->result();
	}
	
	function update($id,$triger,$data,$table)
	{
		$this->db->where($triger,$id);
		$this->db->update($table,$data);
	}
	
	function delete($id,$triger,$table)
	{
		$this->db->where($triger,$id);
		$this->db->delete($table);
	}
	
	function get_data()
	{
		$this->db->select('mypos.t_transaksi_order.status_delv_id,order_logs.timestamp,mypos.t_transaksi_order.order_id,mypos.t_pelanggan.nama,mypos.t_transaksi_order.tgl_kirim,mypos.t_transaksi_order.detail_barang,tarif.layanan,mypos.t_transaksi_order.courier_id')
				 ->from('mypos.t_transaksi_order')
				 ->join('mypos.t_pelanggan','mypos.t_pelanggan.mypos.t_pelanggan_id = mypos.t_transaksi_order.mypos.t_pelanggan_id')
				 ->join('tarif','tarif.tarif_id = mypos.t_transaksi_order.tarif_id')
				 ->join('(SELECT MAX(timestamp) AS timestamp,order_id
						FROM order_logs
						GROUP BY order_id) order_logs','order_logs.order_id = mypos.t_transaksi_order.order_id')
				 ->order_by('order_logs.timestamp','desc');
		$get = $this->db->get();
		
		return $get;
	}
	
	function get_src($data)
	{
		$this->db->select('mypos.t_transaksi_order.status_delv_id,order_logs.timestamp,mypos.t_transaksi_order.order_id,mypos.t_pelanggan.nama,mypos.t_transaksi_order.tgl_kirim,mypos.t_transaksi_order.detail_barang,tarif.layanan,mypos.t_transaksi_order.courier_id')
				 ->from('mypos.t_transaksi_order')
				 ->join('mypos.t_pelanggan','mypos.t_pelanggan.mypos.t_pelanggan_id = mypos.t_transaksi_order.mypos.t_pelanggan_id')
				 ->join('tarif','tarif.tarif_id = mypos.t_transaksi_order.tarif_id')
				 ->join('(SELECT MAX(timestamp) AS timestamp,order_id
						FROM order_logs
						GROUP BY order_id) order_logs','order_logs.order_id = mypos.t_transaksi_order.order_id')
				 ->where('mypos.t_transaksi_order.status_delv_id',$data)
				 ->order_by('order_logs.timestamp','desc');
		$get = $this->db->get();
		
		return $get;
	}
	
	function get_longlat()
	{
		$this->db->select('mypos.t_transaksi_order.*,max(order_logs.timestamp) as timestamp')
				 ->from('mypos.t_transaksi_order')
				 ->join('order_logs','order_logs.order_id = mypos.t_transaksi_order.order_id');
		$get = $this->db->get();
		
		return $get->result();
	}
	
	function longlat_pickup()
	{
		/*$get = $this->db->query('select b.order_id, b.mypos.t_pelanggan_id, b.longlat_pickup, b.longlat_delivery, max(b.date) from (SELECT `mypos.t_transaksi_order`.*, max(order_logs.`timestamp`) as `date` 
FROM (`mypos.t_transaksi_order`)
JOIN order_logs on order_logs.order_id = mypos.t_transaksi_order.order_id
GROUP BY order_id) as b');*/

		$get = $this->db->query('select * from mypos.t_master_kurir ORDER BY courier_id ASC limit 0,1');
		
		if($get->num_rows() > 0)
		{
			return $get->result();
		}
		else
		{
			return 0;
		}
	}
	
	function get_mypos.t_transaksi_order()
	{
		$this->db->select('mypos.t_transaksi_order.*,mypos.t_pelanggan.nama as pickup_name')
				 ->from('mypos.t_transaksi_order')
				 ->where('mypos.t_transaksi_order.status_delv_id','0')
				 ->join('mypos.t_pelanggan','mypos.t_pelanggan.telp = mypos.t_transaksi_order.telp_pickup');
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
	
	function get_mypos.t_master_kurir($id = '')
	{
		if($id == '')
		{
			$this->db->where('login_state','1');
			$get = $this->db->get('mypos.t_master_kurir');
		}
		else
		{
			$this->db->where('login_state','1')
					 ->where_not_in('courier_id',$id);
			$get = $this->db->get('mypos.t_master_kurir');
		}
			
		return $get->result();
	}
	
	function get_kurir()
	{
		$this->db->select('mypos.t_transaksi_order.status_delv_id, mypos.t_transaksi_order.order_id, mypos.t_transaksi_order.status_assign, mypos.t_master_kurir.*')
				 ->from('mypos.t_master_kurir')
				 ->where('login_state','1')
				 ->join('(SELECT status_delv_id, order_id, courier_id, status_assign
FROM mypos.t_transaksi_order
WHERE tgl_kirim
IN (SELECT MAX( tgl_kirim ) AS DATE
FROM mypos.t_transaksi_order
GROUP BY courier_id
) group by courier_id) as mypos.t_transaksi_order','mypos.t_transaksi_order.courier_id = mypos.t_master_kurir.courier_id','left');
		
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
	
	function order_detail($id)
	{
		$this->db->select('mypos.t_transaksi_order.*,mypos.t_pelanggan.nama as cust_name, mypos.t_master_kurir.nama as curs_name, tarif.layanan, tarif.harga')
				 ->from('mypos.t_transaksi_order')
				 ->where('mypos.t_transaksi_order.order_id',$id)
				 ->join('mypos.t_pelanggan','mypos.t_pelanggan.mypos.t_pelanggan_id = mypos.t_transaksi_order.mypos.t_pelanggan_id')
				 ->join('mypos.t_master_kurir','mypos.t_master_kurir.courier_id = mypos.t_transaksi_order.courier_id')
				 ->join('tarif','tarif.tarif_id = mypos.t_transaksi_order.tarif_id');
		
		$get = $this->db->get();
		
		return $get->result();
	}
	
	function get_delivery($data)
	{
		$this->db->select('*')
				 ->from('mypos.t_pelanggan')
				 ->where('email',$data);
		
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
	
	function get_email($id)
	{
		$this->db->select('*')
				 ->from('mypos.t_master_kurir')
				 ->where('courier_id',$id);
		
		$get = $this->db->get();
		
		return $get->result();
	}
	
	function logs_mypos.t_pelanggan()
	{
		$this->db->select('mypos.t_pelanggan.nama, mypos.t_pelanggan.email, mypos.t_transaksi_order.*, order_logs.timestamp')
				 ->from('mypos.t_transaksi_order')
				 ->join('mypos.t_pelanggan','mypos.t_pelanggan.mypos.t_pelanggan_id = mypos.t_transaksi_order.mypos.t_pelanggan_id')
				 ->join('order_logs','order_logs.order_id = mypos.t_transaksi_order.order_id')
				 ->group_by('mypos.t_transaksi_order.order_id')
				 ->order_by('order_logs.timestamp','desc');
		
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
	
	function logs_mypos.t_master_kurir()
	{
		$this->db->select('mypos.t_master_kurir.nama, mypos.t_master_kurir.email, mypos.t_transaksi_order.*, order_logs.timestamp')
				 ->from('mypos.t_transaksi_order')
				 ->join('mypos.t_master_kurir','mypos.t_master_kurir.courier_id = mypos.t_transaksi_order.courier_id')
				 ->join('order_logs','order_logs.order_id = mypos.t_transaksi_order.order_id')
				 ->group_by('mypos.t_transaksi_order.order_id')
				 ->order_by('order_logs.timestamp','desc');
		
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
	
	function detail_logs($id)
	{
		$this->db->select('mypos.t_pelanggan.nama as cust_name, customer1.nama as pickup_name, mypos.t_master_kurir.nama as curs_name, customer2.nama as delv_name, order_logs.*, mypos.t_transaksi_order.detail_barang')
				 ->from('mypos.t_transaksi_order')
				 ->join('mypos.t_pelanggan','mypos.t_pelanggan.mypos.t_pelanggan_id = mypos.t_transaksi_order.mypos.t_pelanggan_id')
				 ->join('order_logs','order_logs.order_id = mypos.t_transaksi_order.order_id')
				 ->join('mypos.t_master_kurir','mypos.t_master_kurir.courier_id = mypos.t_transaksi_order.courier_id','left')
				 ->join('mypos.t_pelanggan as customer1','customer1.email = mypos.t_transaksi_order.email_pickup')
				 ->join('mypos.t_pelanggan as customer2','customer2.email = mypos.t_transaksi_order.email_delivery')
				 ->where('mypos.t_transaksi_order.order_id',$id);
		
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

}