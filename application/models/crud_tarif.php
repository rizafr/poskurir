<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of crud_tarifModel
 *
 * @author Temmy Rustandi Hidayat
 */
class Crud_tarif extends CI_Model
{

	function __construct()
    {
      parent::__construct();
    }
	
	function read($db)
	{
		$get = $this->db->get($db);
		
		return $get;
	}
	
	function get_data($id,$trig,$tbl)
	{
		$this->db->where($trig,$id);
		$get = $this->db->get($tbl);
		
		return $get->result();
	}
	
	function get_kota()
	{
		$this->db->where('lokasi_propinsi','32');
		$this->db->where('lokasi_kecamatan','0');
		$this->db->where('lokasi_kelurahan','0');
		$this->db->where_not_in('lokasi_kabupatenkota',array(0));
		$get = $this->db->get('inf_lokasi');
		
		if($get->num_rows() > 0)
		{
			return $get->result();
		}
		else
		{
			return array();
		}
	}
	
	function insert($db,$data)
	{
		$this->db->insert($db,$data);
	}
	
	function update($id,$trig,$data,$tabel)
	{
		$this->db->where($trig,$id);
		$this->db->update($tabel,$data);
	}
	
	function delete($id,$trig,$tbl)
	{
		$this->db->where($trig,$id);
		$this->db->delete($tbl);
	}
	
	function get_status($id)
	{
		$this->db->select('status_delv_id')
				 ->from('mypos.t_transaksi_order')
				 ->where('order_id',$id);
		$get = $this->db->get();
		
		if($get->num_rows() > 0)
		{
			$data = current($get->result());
			return $data;
		}
		else
		{
			return '000';
		}
	}
	
	function change_stat($id)
	{	
		$data = array(
			'status_delv_id' => 0,
			'status_assign' => 0,
		);
		
		$this->db->where('courier_id',$id)
				 ->where('status_delv_id','1')
				 ->update('mypos.t_transaksi_order',$data);
		
	}
	
	function get_stat($id)
	{
		$this->db->select('*')
				 ->from('mypos.t_transaksi_order')
				 ->where('courier_id',$id)
				 ->where('status_delv_id',0)
				 ->where('status_assign',0);
		
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
	
	function cek_order($id)
	{
		$this->db->select('*')
				 ->from('mypos.t_transaksi_order')
				 ->where('order_id',$id);
		$get = $this->db->get();

		if($get->num_rows > 0)
		{
			return $get->num_rows();
		}
		else
		{
			return 0;
		}
	}

}