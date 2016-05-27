<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of transaksiController
 *
 * @author Temmy Rustandi Hidayat
 */
class Transaksi extends CI_Controller
{
	
	function __construct()
    {
      parent::__construct();
	  $this->load->model('crud_transaksi');
    }
	
	function customers()
	{
		if(!isset($this->input->post))
		{
			$data['customers'] = array(
				'cust' => $this->input->post('cust'),
				'from' => $this->input->post('from'),
				'till' => $this->input->post('till'),
			);
			$data['data'] = $this->crud_transaksi->get_post('customers.customers_id',$this->input->post('cust'),$this->input->post('from'),$this->input->post('till'));
		}
		else
		{
			$data['data'] = $this->crud_transaksi->read_cust();
		}
		
		$data['cust'] = $this->crud_transaksi->get_data('customers');
		$data['param'] = 'trans/show_cust';
		$this->load->view('home',$data);
	}
	
	function couriers()
	{
		if($this->input->post())
		{
			$date1 = current(explode(" ",$this->input->post('from')));
			$date2 = current(explode(" ",$this->input->post('till')));
			
			if(empty($date1))
			{
				$from = date("Y/m/d").' 00:00:00';
			}
			else
			{
				$from = $date1.' 00:00:00';
			}
			
			if(empty($date2))
			{
				$till = date("Y/m/d").' 23:59:59';
			}
			else
			{
				$till = $date2.' 23:59:59';
			}
			
			$data['customers'] = array(
				'cust' => $this->input->post('cust'),
				'from' => $from,
				'till' => $till,
			);
			
			$data['data'] = $this->crud_transaksi->get_trans($from,$till);
			$data['post'] = '1';
		}
		else
		{
			$data['post'] = '0';
			$data['data'] = $this->crud_transaksi->get_trans2();
		}
		//print_r($this->db->last_query());
		$data['cust'] = $this->crud_transaksi->get_data('couriers');
		$data['param'] = 'trans/show_curs';
		
		/*
		echo "<pre>";
		print_r($this->crud_transaksi->get_trans2()->result());
		echo "</pre>";
		print_r($this->db->last_query());
		*/
		
		$this->load->view('home',$data);
	}
	
	function day()
	{
		if($this->input->post())
		{
			$date = current(explode(" ",$this->input->post('from')));
			
			if(empty($date))
			{
				$from = date("Y/m/d").' 00:00:00';
				$till = date("Y/m/d").' 23:59:59';
			}
			else
			{
				$from = $date.' 00:00:00';
				$till = $date.' 23:59:59';
			}
			
			$data['from'] = $from;
			
			$data['data'] = $this->crud_transaksi->get_date($from,$till);
		}
		else
		{
			$from = date("Y/m/d").' 00:00:00';
			$till = date("Y/m/d").' 23:59:59';
			$data['data'] = $this->crud_transaksi->get_date($from,$till);
		}
		
		$data['param'] = 'trans/show_day';
		$this->load->view('home',$data);
	}
	
	function month()
	{
		if($this->input->post())
		{
			$date = $this->input->post('year').'/'.$this->input->post('month');
			
			if(empty($date))
			{
				$from = date("Y/m").'/01 00:00:00';
				$till = date("Y/m").'/31 23:59:59';
			}
			else
			{
				$from = $date.'/01 00:00:00';
				$till = $date.'/31 23:59:59';
			}
			
			$data['from'] = $from;
			
			$data['data'] = $this->crud_transaksi->get_date($from,$till);
		}
		else
		{
			$from = date("Y/m").'/01 00:00:00';
			$till = date("Y/m").'/31 23:59:59';
			$data['data'] = $this->crud_transaksi->get_date($from,$till);
		}
		
		$data['param'] = 'trans/show_month';
		$this->load->view('home',$data);
	}
	
	
	function year()
	{
		if($this->input->post())
		{
			$date = $this->input->post('year');
			
			if(empty($date))
			{
				$from = date("Y").'/01/01 00:00:00';
				$till = date("Y").'/12/31 23:59:59';
			}
			else
			{
				$from = $date.'/01/01 00:00:00';
				$till = $date.'/12/31 23:59:59';
			}
			
			$data['from'] = $this->input->post('year');
			
			$data['data'] = $this->crud_transaksi->get_date($from,$till);
		}
		else
		{
			$from = date("Y").'/01/01 00:00:00';
			$till = date("Y").'/12/31 23:59:59';
			$data['data'] = $this->crud_transaksi->get_date($from,$till);
		}
		
		$data['param'] = 'trans/show_year';
		$this->load->view('home',$data);
	}
	
	function bills()
	{
		$data['param'] = "trans/form";
		//print_r($this->input->post());
		$this->load->view('home',$data);
	}
	
	function show_bills()
	{
		$nip = trim($this->input->post('nip'));
		$data['bills'] = $this->crud_transaksi->read_bill($nip);
		$data['kurir'] = $this->crud_transaksi->read_bill($nip);
		$data['curs'] = $this->crud_transaksi->get_kurir($nip);
		$data['param'] = 'trans/bills';
        $data['nip'] = trim($this->input->post('nip'));
		
		$this->load->view('home',$data);
	}
	
	function process()
	{
        if(is_array($this->input->post('order')) == 1)
        {
            foreach($this->input->post('order') as $key1 => $data1)
            {
                //echo "start update ".$key1."<br><br>";
                $this->crud_transaksi->update($key1,'order_id',array('status_delv_id' => 10),'orders');
                //echo "end ".$key1."<br><br>";
            }
            
            foreach($this->input->post('order') as $key2 => $data2)
            {
                //echo "start insert ".$key2."<br><br>";
                $this->crud_transaksi->insert(array('order_id' => $key2, 'status_delv_id' => 10),'order_logs');
                //echo "end ".$key2."<br><br>";
            }
			
			//Transaksi
			foreach($this->input->post('order') as $key3 => $data3)
            {
                //echo "start insert ".$key3."<br><br>";
                $this->crud_transaksi->insert(array('order_id' => $key3, 'status_bayar' => 1,'courier_id' => $this->input->post('nip'),'tarif_id' => $this->input->post('tarif')[$key3],'user_id' => $this->session->userdata('id')),'transaksi');
                //echo "end ".$key3."<br><br>";
            }
			
			/*
			//Transaksi
			foreach($this->input->post('order') as $key3 => $data3)
            {
                //echo "start update ".$key1."<br><br>";
                $this->crud_transaksi->update($key3,'order_id',array('status_bayar' => 1,'user_id' => $this->session->userdata('id')),'transaksi');
                //echo "end ".$key1."<br><br>";
            }
			*/
            
            $msg = array(
                'status' => 1,
                'title' => 'Success',
                'msg' => '<strong>Selamat !!!</strong> anda sudah menerima tagihan dari pengantar.',
            );
            $this->session->set_flashdata('alert',$msg);
            
            redirect("transaksi/bills");
        }
        else
        {
           // echo $this->input->post('nip');
            
            $msg = array(
                'status' => 0,
                'title' => 'Gagal Menerima Tagihan',
                'msg' => '<strong>Gagal !!!</strong> anda tidak menerima tagihan dari pengantar, mohon centang chekbox yang tersedia.',
            );
            $this->session->set_flashdata('alert',$msg);
            
            redirect("transaksi/bills");
        }
	}
	
	function not_receive_yet()
	{
		if($this->input->post())
		{
			$date1 = current(explode(" ",$this->input->post('from')));
			$date2 = current(explode(" ",$this->input->post('till')));
			
			if(empty($date1))
			{
				$from = date("Y/m/d").' 00:00:00';
			}
			else
			{
				$from = $date1.' 00:00:00';
			}
			
			if(empty($date2))
			{
				$till = date("Y/m/d").' 23:59:59';
			}
			else
			{
				$till = $date2.' 23:59:59';
			}
			
			$data['customers'] = array(
				'cust' => $this->input->post('cust'),
				'from' => $from,
				'till' => $till,
			);
			
			$data['data'] = $this->crud_transaksi->get_transaksi2($from,$till);
		}
		else
		{
			$data['data'] = $this->crud_transaksi->read_cust2();
		}
		//print_r($this->db->last_query());
		$data['cust'] = $this->crud_transaksi->get_data('couriers');
		$data['param'] = 'trans/belum_terima';
		$this->load->view('home',$data);
	}
	
}