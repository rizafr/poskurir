<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Order Controller
 *
 * @author Okyza Maherdy Prabowo
 */
class Sent extends CI_Controller{

	function __construct()
    {
      parent::__construct();
	  $this->load->model('crud_tarif');
	  $this->load->model('crud_order');
	  $this->load->library('encrypt');
	  $this->load->library('email');
    }
	
	function reject($id)
	{
		$key = 'POSkurir@email123';
		
		$url_param = $id . str_repeat('=', strlen($id) % 4);
		$url = base64_decode($url_param);
		
		$code = explode("/",$this->encrypt->decode($url, $key));
		
		$order_id = $code[1];
		
		$status = $this->crud_tarif->get_status($order_id);
		$blank = $this->crud_order->cek_stat($code[1],$code[0]);
		$blang = $this->crud_order->cek_stat2($code[1],$code[0]);
		$cek_order = $this->crud_tarif->cek_order($order_id);
		
		if($cek_order > 0)
		{
			
			if($status->status_delv_id == 0 or $status->status_delv_id == 1)
			{
				if($blank == '0' and $blang == '1')
				{
					$data1['courier_id'] = $code[0];
					$data1['status_delv_id'] = 0;
					$data1['status_assign'] = 2;
					$this->crud_order->update($order_id,'order_id',$data1,'orders');
					
					
					echo '<script>alert("Order sudah ditolak");</script>';
					echo '<script>window.close();</script>';
				}
				else
				{
					echo '<script>alert("Anda sudah pernah menolak order ini");</script>';
					echo '<script>window.close();</script>';
				}
			}
			else
			{
					echo '<script>alert("Order dalam proses atau sudah selesai");</script>';
					echo '<script>window.close();</script>';
			}
		
		}
		else
		{
			echo '<script>alert("Order ini sudah dihapus");</script>';
			echo '<script>window.close();</script>';
		}
	}
	
	function receive($id)
	{
		$key = 'POSkurir@email123';
		
		$url_param = $id . str_repeat('=', strlen($id) % 4);
		$url = base64_decode($url_param);
		
		$code = explode("/",$this->encrypt->decode($url, $key));
		
		$order_id = $code[1];
		
		$status = $this->crud_tarif->get_status($order_id);
		
		$kur = $this->crud_order->take_kurir($code[0],$code[1]);
		$blank = $this->crud_order->cek_stat($code[1],$code[0]);
		$blang = $this->crud_order->cek_stat2($code[1],$code[0]);
		$cek_order = $this->crud_tarif->cek_order($order_id);
		
		if($cek_order > 0)
		{
			
			if($status->status_delv_id == 0 or $status->status_delv_id == 1)
			{
				$get_stat = $this->crud_tarif->get_stat($code[0]);
				
				if($blank == 0 and $blang == 1)
				{
					if($get_stat == 0)
					{
						$data['status_delv_id'] = 2;
						$data['order_id'] = $order_id;
						$this->crud_order->create('order_logs',$data);
						
						$data1['courier_id'] = $code[0];
						$data1['status_delv_id'] = 2;
						$data1['status_assign'] = 0;
						$this->crud_order->update($order_id,'order_id',$data1,'orders');
						
						$order = current($this->crud_order->get_detail($order_id));
						$delv = $this->crud_order->get_delivery($order->telp_delivery);
						$pick = $this->crud_order->get_delivery($order->telp_pickup);
						$get = current($this->crud_order->get_email($code[0]));
						
						$this->crud_tarif->change_stat($code[0]);
						
						//CUSTOMERS
						
						$msg2  = "<p>Ini adalah detail pengiriman barang dari POS KURIR, <br><br>";
						$msg2 .= "<table border='0'>";
						$msg2 .= "<tr>";
						$msg2 .= "<td>Nama Kurir</td> <td>:</td> <td><b>".$get->nama."</b></td>";
						$msg2 .= "</tr><tr>";
						$msg2 .= "<td>Nama Customer</td> <td>:</td> <td><b>".$order->cust_name."</b></td>";
						$msg2 .= "</tr><tr>";
						$msg2 .= "<td>Nama Pengirim</td> <td>:</td> <td><b>".$pick->nama."</b></td>";
						$msg2 .= "</tr><tr>";
						$msg2 .= "<td>Nama Penerima</td> <td>:</td> <td><b>".$delv->nama."</b></td>";
						$msg2 .= "</tr><tr>";
						$msg2 .= "<td>Alamat PickUp</td> <td>:</td> <td>".$order->alamat_pickup."</td>";
						$msg2 .= "</tr><tr>";
						$msg2 .= "<td>Alamat Delivery</td> <td>:</td> <td>".$order->alamat_delivery."</td>";
						$msg2 .= "</tr><tr>";
						$msg2 .= "<td>Detail Barang</td> <td>:</td> <td>".$order->detail_barang."</td>";
						$msg2 .= "</tr><tr>";
						$msg2 .= "<td>Status</td> <td>:</td> <td>".$this->status($order->status_delv_id)."</td>";
						$msg2 .= "</tr><tr>";
						$msg2 .= "<td>Harga</td> <td>:</td> <td>Rp. ".number_format($order->harga,2,",",".")."</td>";
						$msg2 .= "</tr>";
						$msg2 .= "</table><br><br>";
						$msg2 .= "Terimakasih, telah menggunakan jasa POS Kurir Indonesia.";
						
						$config2 = array();
						 
						$config['charset'] = 'utf-8';
						$config['useragent'] = 'Codeigniter';
						$config['protocol']= "smtp";
						$config['mailtype']= "html";
						$config['smtp_host']= "ssl://smtp.gmail.com";
						$config['smtp_port']= "465";
						$config['smtp_timeout']= "5";
						$config['smtp_user']= "pos.smtp@gmail.com";
						$config['smtp_pass']= "sumapala";
						$config['crlf']="\r\n"; 
						$config['newline']="\r\n"; 
								
						$this->email->initialize($config);
						$this->email->from('pos.smtp@gmail.com','PT POS INDONESIA');  
						$this->email->to($order->email_pickup);
						$this->email->cc($order->email_delivery);
						$this->email->bcc('pos.smtp@gmail.com'); 
						$this->email->subject('POS Kurir');  
						$this->email->message($msg2);  
						$this->email->send();
						
						echo '<script>alert("Order sudah diterima");</script>';
						echo '<script>window.close();</script>';
					}
					else
					{
						if($kur->status_delv_id == 0 or $kur->status_delv_id == 4 or $kur->status_delv_id == 7 or $kur->status_delv_id == 8 or $kur->status_delv_id == 9 or $kur->status_delv_id == 10)
						{
							$data['status_delv_id'] = 2;
							$data['order_id'] = $order_id;
							$this->crud_order->create('order_logs',$data);
							
							$data1['courier_id'] = $code[0];
							$data1['status_delv_id'] = 2;
							$data1['status_assign'] = 0;
							$this->crud_order->update($order_id,'order_id',$data1,'orders');
							
							$order = current($this->crud_order->get_detail($order_id));
							$delv = $this->crud_order->get_delivery($order->telp_delivery);
							$pick = $this->crud_order->get_delivery($order->telp_pickup);
							$get = current($this->crud_order->get_email($code[0]));
							
							$this->crud_tarif->change_stat($code[0]);
							
							//CUSTOMERS
							
							$msg2  = "<p>Ini adalah detail pengiriman barang dari POS KURIR, <br><br>";
							$msg2 .= "<table border='0'>";
							$msg2 .= "<tr>";
							$msg2 .= "<td>Nama Kurir</td> <td>:</td> <td><b>".$get->nama."</b></td>";
							$msg2 .= "</tr><tr>";
							$msg2 .= "<td>Nama Customer</td> <td>:</td> <td><b>".$order->cust_name."</b></td>";
							$msg2 .= "</tr><tr>";
							$msg2 .= "<td>Nama Pengirim</td> <td>:</td> <td><b>".$pick->nama."</b></td>";
							$msg2 .= "</tr><tr>";
							$msg2 .= "<td>Nama Penerima</td> <td>:</td> <td><b>".$delv->nama."</b></td>";
							$msg2 .= "</tr><tr>";
							$msg2 .= "<td>Alamat PickUp</td> <td>:</td> <td>".$order->alamat_pickup."</td>";
							$msg2 .= "</tr><tr>";
							$msg2 .= "<td>Alamat Delivery</td> <td>:</td> <td>".$order->alamat_delivery."</td>";
							$msg2 .= "</tr><tr>";
							$msg2 .= "<td>Detail Barang</td> <td>:</td> <td>".$order->detail_barang."</td>";
							$msg2 .= "</tr><tr>";
							$msg2 .= "<td>Status</td> <td>:</td> <td>".$this->status($order->status_delv_id)."</td>";
							$msg2 .= "</tr><tr>";
							$msg2 .= "<td>Harga</td> <td>:</td> <td>Rp. ".number_format($order->harga,2,",",".")."</td>";
							$msg2 .= "</tr>";
							$msg2 .= "</table><br><br>";
							$msg2 .= "Terimakasih, telah menggunakan jasa POS Kurir Indonesia.";
							
							$config2 = array();
							 
							$config['charset'] = 'utf-8';
							$config['useragent'] = 'Codeigniter';
							$config['protocol']= "smtp";
							$config['mailtype']= "html";
							$config['smtp_host']= "ssl://smtp.gmail.com";
							$config['smtp_port']= "465";
							$config['smtp_timeout']= "5";
							$config['smtp_user']= "pos.smtp@gmail.com";
							$config['smtp_pass']= "sumapala";
							$config['crlf']="\r\n"; 
							$config['newline']="\r\n"; 
									
							$this->email->initialize($config);
							$this->email->from('pos.smtp@gmail.com','PT POS INDONESIA');  
							$this->email->to($order->email_pickup);
							$this->email->cc($order->email_delivery);
							$this->email->bcc('pos.smtp@gmail.com'); 
							$this->email->subject('POS Kurir');  
							$this->email->message($msg2);  
							$this->email->send();
							
							echo '<script>alert("Order sudah diterima");</script>';
							echo '<script>window.close();</script>';
						}
						else
						{
							echo '<script>alert("Anda sedang dalam tugas");</script>';
							echo '<script>window.close();</script>';
						}
					}
				}
				else
				{
					echo '<script>alert("Anda baru saja menolak order ini, tunggu assignment ulang untuk menerima order ini, atau hubungi admin");</script>';
					echo '<script>window.close();</script>';
				}
			}
			else
			{
				echo '<script>alert("Order dalam proses atau sudah selesai");</script>';
				echo '<script>window.close();</script>';
			}
		
		}
		else
		{
			echo '<script>alert("Order ini sudah dihapus");</script>';
			echo '<script>window.close();</script>';
		}
	}
    
    function status($id)
	{
		switch($id)
		{
			case '0';
			$a = 'Request';
			break;
			
			case '1';
			$a = 'On Assignment';
			break;
			
			case '2';
			$a = 'On Waitting';
			break;
			
			case '3';
			$a = 'Pick Up';
			break;
			
			case '4';
			$a = 'Delivered';
			break;
			
			case '5';
			$a = 'Rejected';
			break;
			
			case '6';
			$a = 'Return';
			break;
			
			case '7';
			$a = 'Return Delivered';
			break;
			
			case '8';
			$a = 'Rejected Delivered';
			break;
			
			case '9';
			$a = 'Financial Acceptance';
			break;
			
			case '10';
			$a = 'Completed';
			break;
		}
		
		return $a;
	}
}