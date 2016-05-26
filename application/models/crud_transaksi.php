<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of crudtransaksiModel
 *
 * @author Temmy Rustandi Hidayat
 */
class Crud_transaksi extends CI_Model
{
	
	function __construct()
    {
      parent::__construct();
    }
	
	function read_cust()
	{
		$this->db->select('orders.order_id,tarif.harga,count(couriers.courier_id) as transaksi,couriers.courier_id,sum(`tarif`.`harga`) as harga, customers.nama as cust_name, couriers.nama as curs_name, customers.email as cust_email, couriers.email as curs_email, order_logs.timestamp as date')
			 ->from('orders')
			 ->join('order_logs','order_logs.order_id = orders.order_id')
			 ->join('customers','customers.customers_id = orders.customers_id')
			 ->join('couriers','couriers.courier_id = orders.courier_id')
			 ->join('tarif','tarif.tarif_id = orders.tarif_id')
			 //->where_in('order_logs.status_delv_id',array('10','7','8'))
			 ->where_in('order_logs.status_delv_id','10')
			 ->group_by('couriers.courier_id');
		$get = $this->db->get();
		
		return $get;
	}
	
	function read_cust2()
	{
		$this->db->select('orders.order_id,tarif.harga,count(couriers.courier_id) as transaksi,couriers.courier_id,sum(`tarif`.`harga`) as harga, customers.nama as cust_name, couriers.nama as curs_name, customers.email as cust_email, couriers.email as curs_email, order_logs.timestamp as date')
			 ->from('orders')
			 ->join('order_logs','order_logs.order_id = orders.order_id')
			 ->join('customers','customers.customers_id = orders.customers_id')
			 ->join('couriers','couriers.courier_id = orders.courier_id')
			 ->join('tarif','tarif.tarif_id = orders.tarif_id')
			 //->where_in('order_logs.status_delv_id',array('10','7','8'))
			 ->where_in('order_logs.status_delv_id',array('4','5','6','7','8'))
			 ->group_by('couriers.courier_id');
		$get = $this->db->get();
		
		return $get;
	}
	
	function get_post($trig,$cust,$from,$till)
	{
		$this->db->select('orders.order_id,tarif.harga,customers.nama as cust_name, couriers.nama as curs_name, customers.email as cust_email, couriers.email as curs_email, order_logs.timestamp as date')
			 ->from('orders')
			 ->join('order_logs','order_logs.order_id = orders.order_id')
			 ->join('customers','customers.customers_id = orders.customers_id')
			 ->join('couriers','couriers.courier_id = orders.courier_id')
			 ->join('tarif','tarif.tarif_id = orders.tarif_id')
			 ->where($trig,$cust)
			 ->where('order_logs.timestamp >=', $from)
			 ->where('order_logs.timestamp <=', $till)
			 ->where('order_logs.status_delv_id','10')
			 ->group_by('order_logs.order_id');
		$get = $this->db->get();
		
		return $get;
	}
	
	function get_transaksi($from,$till)
	{
		$this->db->select('orders.order_id,tarif.harga,count(couriers.courier_id) as transaksi,couriers.courier_id,sum(`tarif`.`harga`) as harga, customers.nama as cust_name, couriers.nama as curs_name, customers.email as cust_email, couriers.email as curs_email, order_logs.timestamp as date')
			 ->from('orders')
			 ->join('order_logs','order_logs.order_id = orders.order_id')
			 ->join('customers','customers.customers_id = orders.customers_id')
			 ->join('couriers','couriers.courier_id = orders.courier_id')
			 ->join('tarif','tarif.tarif_id = orders.tarif_id')
			 ->where('order_logs.timestamp >=', $from)
			 ->where('order_logs.timestamp <=', $till)
			 //->where_in('order_logs.status_delv_id',array('10','7','8'))
             ->where('order_logs.status_delv_id','10')
			 ->group_by('couriers.courier_id');
		$get = $this->db->get();
		
		return $get;
	}
	
	function get_trans($from,$till)
	{
		/*contoh 1
		$this->db->select('transaksi.courier_id,couriers.nama as curs_name, sum(tarif.harga) as harga, count(transaksi.courier_id) as transaksi')
				 ->from('transaksi')
				 ->join('orders','orders.order_id = transaksi.order_id')
				 ->join('order_logs','order_logs.order_id = transaksi.order_id')
				 ->join('couriers','couriers.courier_id = transaksi.courier_id')
				 ->join('tarif','tarif.tarif_id = transaksi.tarif_id')
				 ->where('transaksi.status_bayar','1')
				 ->where('order_logs.timestamp >=', $from)
				 ->where('order_logs.timestamp <=', $till)
				 ->group_by('transaksi.courier_id');
			 
		$get = $this->db->get();
		
		return $get;
		*/
		
		$this->db->select('count(transaksi.courier_id) as transaksi,couriers.nama as curs_name, sum(tarif.harga) as harga')
				 ->from('transaksi')
				 ->join('orders','orders.order_id = transaksi.order_id')
				 ->join('couriers','couriers.courier_id = transaksi.courier_id')
				 ->join('tarif','tarif.tarif_id = transaksi.tarif_id')
				 ->join('order_logs','order_logs.order_id = transaksi.order_id')
				 ->where('transaksi.status_bayar','1')
				 ->where('order_logs.status_delv_id','10')
				 ->where('order_logs.timestamp >=', $from)
				 ->where('order_logs.timestamp <=', $till)
				 ->group_by('transaksi.courier_id');
			 
		$get = $this->db->get();
		
		return $get;
	}
	
	function get_trans2()
	{
		$this->db->select('count(transaksi.courier_id) as transaksi,couriers.nama as curs_name, sum(tarif.harga) as harga')
				 ->from('transaksi')
				 ->join('orders','orders.order_id = transaksi.order_id')
				 ->join('couriers','couriers.courier_id = transaksi.courier_id')
				 ->join('tarif','tarif.tarif_id = transaksi.tarif_id')
				 ->where('transaksi.status_bayar','1')
				 ->group_by('transaksi.courier_id');
			 
		$get = $this->db->get();
		
		return $get;
	}
	
	function get_transaksi2($from,$till)
	{
		$this->db->select('orders.order_id,tarif.harga,count(couriers.courier_id) as transaksi,couriers.courier_id,sum(`tarif`.`harga`) as harga, customers.nama as cust_name, couriers.nama as curs_name, customers.email as cust_email, couriers.email as curs_email, order_logs.timestamp as date')
			 ->from('orders')
			 ->join('order_logs','order_logs.order_id = orders.order_id')
			 ->join('customers','customers.customers_id = orders.customers_id')
			 ->join('couriers','couriers.courier_id = orders.courier_id')
			 ->join('tarif','tarif.tarif_id = orders.tarif_id')
			 ->where('order_logs.timestamp >=', $from)
			 ->where('order_logs.timestamp <=', $till)
			 //->where_in('order_logs.status_delv_id',array('10','7','8'))
             ->where_in('order_logs.status_delv_id',array('4','5','6','7','8'))
			 ->group_by('couriers.courier_id');
		$get = $this->db->get();
		
		return $get;
	}
	
	function get_date($from,$till)
	{
		$this->db->select('orders.order_id,tarif.harga,customers.nama as cust_name, couriers.nama as curs_name, customers.email as cust_email, couriers.email as curs_email, order_logs.timestamp as date')
			 ->from('orders')
			 ->join('order_logs','order_logs.order_id = orders.order_id')
			 ->join('customers','customers.customers_id = orders.customers_id')
			 ->join('couriers','couriers.courier_id = orders.courier_id')
			 ->join('tarif','tarif.tarif_id = orders.tarif_id')
			 ->where('order_logs.timestamp >=', $from)
			 ->where('order_logs.timestamp <=', $till)
			 ->where('order_logs.status_delv_id','10')
			 ->group_by('order_logs.order_id');
		$get = $this->db->get();
		
		return $get;
	}
	
	function get_kurir($id)
	{
		$this->db->where('courier_id',$id);
		$get = $this->db->get('couriers');
		
		return current($get->result());
	}
	
	function read_bill($id)
	{
		$this->db->select('orders.order_id,tarif.harga,tarif.layanan,tarif.tarif_id,customers.nama as cust_name, couriers.nama as curs_name, couriers.courier_id, customers.email as cust_email, couriers.email as curs_email, orders.tarif_id, order_logs.timestamp as date')
				 ->from('orders')
				 ->join('order_logs','order_logs.order_id = orders.order_id')
				 ->join('customers','customers.customers_id = orders.customers_id')
				 ->join('couriers','couriers.courier_id = orders.courier_id')
			     ->join('tarif','tarif.tarif_id = orders.tarif_id')
				 ->where_in('orders.status_delv_id',array('3','4','5','6','7','8'))
				 ->where('orders.courier_id',$id)
				 ->group_by('order_logs.order_id');
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
	
	function get_data($table)
	{
		$get = $this->db->get($table);
		
		return $get->result();
	}
	
	function update($id,$trig,$data,$table)
	{
		$this->db->where($trig,$id);
		$this->db->update($table,$data);
	}
	
	function insert($data,$table)
	{
		$this->db->insert($table,$data);
	}
	
}