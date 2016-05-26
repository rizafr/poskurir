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
class Crud_order extends CI_Model
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
		$get = $this->db->get('couriers');
		
		return $get->num_rows();
	}
	
	function look2($id,$post,$triger)
	{
		$this->db->where($triger,$post);
		$this->db->where_not_in('courier_id',$id);
		$get = $this->db->get('couriers');
		
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
		$this->db->select('orders.status_delv_id,couriers.nama as nama_kurir,order_logs.timestamp,orders.order_id,customers.nama,order_logs.timestamp as tgl_kirim,orders.detail_barang,tarif.layanan,orders.courier_id')
				 ->from('orders')
				 ->join('customers','customers.customers_id = orders.customers_id')
				 ->join('tarif','tarif.tarif_id = orders.tarif_id')
				 ->join('couriers','couriers.courier_id = orders.courier_id','left')
				 ->join('(SELECT MAX(timestamp) AS timestamp,order_id
						FROM order_logs
						GROUP BY order_id) order_logs','order_logs.order_id = orders.order_id')
				 ->order_by('order_logs.timestamp','desc');
		$get = $this->db->get();
		
		return $get;
	}
	
	function get_src($data)
	{
		$this->db->select('orders.status_delv_id,couriers.nama as nama_kurir,order_logs.timestamp,orders.order_id,customers.nama,orders.tgl_kirim,orders.detail_barang,tarif.layanan,orders.courier_id')
				 ->from('orders')
				 ->join('customers','customers.customers_id = orders.customers_id')
				 ->join('tarif','tarif.tarif_id = orders.tarif_id')
				 ->join('couriers','couriers.courier_id = orders.courier_id','left')
				 ->join('(SELECT MAX(timestamp) AS timestamp,order_id
						FROM order_logs
						GROUP BY order_id) order_logs','order_logs.order_id = orders.order_id')
				 ->where('orders.status_delv_id',$data)
				 ->order_by('order_logs.timestamp','desc');
		$get = $this->db->get();
		
		return $get;
	}
	
	function get_longlat($id)
	{
		$this->db->select('orders.*,customers.nama')
				 ->from('orders')
				 ->join('customers','customers.customers_id = orders.customers_id')
				 ->where('order_id',$id);
		$get = $this->db->get();
		
		return $get->result();
	}
	
	function get_orders()
	{
		$this->db->select('orders.*,customers.nama as pickup_name')
				 ->distinct()
				 ->from('orders')
				 ->where('orders.status_delv_id','0')
				 ->join('customers','customers.telp = orders.telp_pickup')
				 ->group_by('orders.order_id');
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
	
	function get_kurir($id)
	{
		$this->db->where('courier_id',$id);
		$get = $this->db->get('couriers');
		
		if($get->num_rows() > 0)
		{
			return $get->result();
		}
		else
		{
			return 0;
		}
	}
	
	function get_couriers($id = '')
	{
		if($id == '')
		{
			$this->db->where('login_state','1');
			$get = $this->db->get('couriers');
		}
		else
		{
			$this->db->where('login_state','1')
					 ->where_not_in('courier_id',$id);
			$get = $this->db->get('couriers');
		}
			
		return $get->result();
	}
	
	function ambil_kurir($id = '')
	{
		if($id == '')
		{
		$this->db->select('orders.status_delv_id, orders.order_id, orders.status_assign, couriers.*')
				 ->from('couriers')
				 ->where('login_state','1')
				 ->join('(SELECT status_delv_id, order_id, courier_id, status_assign
FROM orders
WHERE tgl_kirim
IN (SELECT MAX( tgl_kirim ) AS DATE
FROM orders
GROUP BY courier_id
) group by courier_id) as orders','orders.courier_id = couriers.courier_id','left');
		
		$get = $this->db->get();
		}
		else
		{
		$this->db->select('orders.status_delv_id, orders.order_id, orders.status_assign, couriers.*')
				 ->from('couriers')
				 ->where('login_state','1')
				 //->where_not_in('couriers.courier_id',$id)
				 ->join('(SELECT status_delv_id, order_id, courier_id, status_assign
FROM orders
WHERE tgl_kirim
IN (SELECT MAX( tgl_kirim ) AS DATE
FROM orders
GROUP BY courier_id
) group by courier_id) as orders','orders.courier_id = couriers.courier_id','left');
		
		$get = $this->db->get();
		}
		
		if($get->num_rows() > 0)
		{
			return $get->result();
		}
		else
		{
			return 0;
		}
	}
	
	function take_kurir($id,$order_id)
	{
		$this->db->select('orders.status_delv_id, orders.order_id, orders.status_assign, couriers.*')
				 ->from('couriers')
				 ->where('login_state','1')
				 ->where('couriers.courier_id',$id)
				 ->where_not_in('orders.order_id',$order_id)
				 ->join('(SELECT status_delv_id, order_id, courier_id, status_assign
FROM orders
WHERE tgl_kirim
IN (SELECT MAX( tgl_kirim ) AS DATE
FROM orders
GROUP BY courier_id
) group by courier_id) as orders','orders.courier_id = couriers.courier_id','left');
		
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
		$this->db->select('orders.*,customers.nama as cust_name, couriers.nama as curs_name, tarif.layanan, tarif.harga')
				 ->from('orders')
				 ->where('orders.order_id',$id)
				 ->join('customers','customers.customers_id = orders.customers_id')
				 ->join('couriers','couriers.courier_id = orders.courier_id')
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
	
	function get_email($id)
	{
		$this->db->select('*')
				 ->from('couriers')
				 ->where('courier_id',$id);
		
		$get = $this->db->get();
		
		return $get->result();
	}
	
	function logs_customers()
	{
		$this->db->select('customers.nama, customers.email, orders.*, order_logs.timestamp')
				 ->from('orders')
				 ->join('customers','customers.customers_id = orders.customers_id')
				 ->join('order_logs','order_logs.order_id = orders.order_id')
				 ->group_by('orders.order_id')
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
	
	function logs_couriers()
	{
		$this->db->select('couriers.nama, couriers.email, orders.*, order_logs.timestamp')
				 ->from('orders')
				 ->join('couriers','couriers.courier_id = orders.courier_id')
				 ->join('order_logs','order_logs.order_id = orders.order_id')
				 ->group_by('orders.order_id')
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
		$this->db->select('customers.nama as cust_name, customer1.nama as pickup_name, couriers.nama as curs_name, customer2.nama as delv_name, `order_logs`.status_delv_id, 
`order_logs`.timestamp,
`order_logs`.order_id, orders.detail_barang')
				 ->distinct()
				 ->from('orders')
				 ->join('customers','customers.customers_id = orders.customers_id')
				 ->join('order_logs','order_logs.order_id = orders.order_id')
				 ->join('couriers','couriers.courier_id = orders.courier_id','left')
				 ->join('customers as customer1','customer1.telp = orders.telp_pickup')
				 ->join('customers as customer2','customer2.telp = orders.telp_delivery')
				 ->where('orders.order_id',$id)
				 ->group_by('order_logs.status_delv_id')
				 ->order_by('order_logs.status_delv_id','asc');
		
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
	
	function cek_stat($order_id,$kurir_id)
	{
		$this->db->select('*')
				 ->from('orders')
				 ->where('courier_id',$kurir_id)
				 ->where('order_id',$order_id)
				 ->where('status_assign','2');
		
		$get = $this->db->get();
		
		if($get->num_rows() > 0)
		{
			return $get->num_rows();
		}
		else
		{
			return 0;
		}
	}
	
	function cek_stat2($order_id,$kurir_id)
	{
		$this->db->select('*')
				 ->from('orders')
				 ->where('courier_id',$kurir_id)
				 ->where('order_id',$order_id)
				 ->where('status_assign','1');
		
		$get = $this->db->get();
		
		if($get->num_rows() > 0)
		{
			return $get->num_rows();
		}
		else
		{
			return 0;
		}
	}
    
    function cek_status_terus($id)
    {
        $query = "select count(x.status_delv_id) as contoh
                    from
                    (select a.status_delv_id, b.nama
                    from orders a right join couriers b
                    on a.courier_id = b.courier_id
                    where a.courier_id = '".$id."'
                    and a.status_delv_id IN (1,2,3,5,6)) x";

        $get = $this->db->query($query);
        $row = $get->row_array();
        //echo $row['status'];
        return $row['contoh'];
    }

}