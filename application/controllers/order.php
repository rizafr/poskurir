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
class Order extends CI_Controller{

	function __construct()
    {
      parent::__construct();
	  $this->load->model('crud_tarif');
	  $this->load->model('crud_order');
	  $this->load->library('encrypt');
	  $this->load->library('email');
    }
    
    function createorder()
    {
        /*
        header("Access-Control-Allow-Origin: *");
        
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");

        //Now we receive the encrypted from the post, we should decode it from base64,
        $encrypted = base64_decode(file_get_contents("php://input"));
        $datas = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv);

        $clean = preg_replace('/[^\PC\s]/u', '', $datas);
        
        $data = json_decode($clean);
        */
        echo True;
        
        /*
        $insertdata = array(
			'personPickup' => $data->email,
			'name' => md5($data->password),
            'email' => md5($data->password),
            'telepon' => md5($data->password),
            'name' => md5($data->password),
            'name' => md5($data->password),
		);
        
        
        if(!$this->crud_order->create('orders',$insertdata))
		{
                
        }
        
        else 
        {   
            echo "Email sudah terdaftar";
        }
        */
    }
    
    function requestpickup()
    {
        header("Access-Control-Allow-Origin: *");
    
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");

        //Now we receive the encrypted from the post, we should decode it from base64,
        $encrypted = base64_decode(file_get_contents("php://input"));
        $datas = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv);

        $clean = preg_replace('/[^\PC\s]/u', '', $datas);
        
        $data = json_decode($clean);
        
        //echo "Sukses Order";
        $data = $this->crud_tarif->get_tarif();
        echo json_encode($data);
        //kirim notif email dan mqtt ke kurir
    }
    
    function get_tarif_order()
    {
        header("Access-Control-Allow-Origin: *");
    
        //echo "Sukses Order";
        $data['tarif'] = $this->crud_tarif->get_tarif();
        echo json_encode($data);
    }
    
    function status_order_by_customer()
    {
    
    }
    
    function status_order()
    {
        header("Access-Control-Allow-Origin: *");
        $data = json_decode(file_get_contents("php://input"));
        $status_delv_id = $data->id;
    
        //update masing masing step status_delv_id
        /*
        0 - Request -> dari user
        1 - On-Waiting -> admin pada saat tunggu respon terima dari kurir
        2 - PickUp -> dari kurir
        3 - Delivered -> dari kurir
        4 - Rejected -> dari kurir
        5 - Retour -> dari kurir
        6 - Retour Delivered -> dari kurir
        7 - Rejected Delivered -> dari kurir
        8 - Financial Acceptance -> admin  
        9 - Completed -> admin
        */
    
    }

	//show order data
	function index()
	{
		$data['order'] = $this->crud_order->get_data();
		$data['param'] = 'orders/show';
		//print_r($this->db->last_query());
		$this->load->view('home',$data);
	}
	
	function proses($order_id)
	{
		if($this->crud_order->get_longlat($order_id) == '0')
		{
			$couriers = $this->crud_order->ambil_kurir();
			$data['kurir'] = $this->crud_order->get_couriers();
		}
		else
		{
			$longlat = current($this->crud_order->get_longlat($order_id));
			if($longlat->courier_id == '0')
			{
				$couriers = $this->crud_order->ambil_kurir();
				//$data['kurir'] = $this->crud_order->get_couriers();
				$data['kurir'] = $this->crud_order->ambil_kurir();
			}
			else
			{
				$couriers = $this->crud_order->ambil_kurir($longlat->courier_id);
				//$data['kurir'] = $this->crud_order->get_couriers($longlat->courier_id);
				$data['kurir'] = $this->crud_order->ambil_kurir($longlat->courier_id);
			}
		}
		
		/*
		echo "<pre>";
		print_r($this->db->last_query());
		echo "</pre>";
        */
		
		
		$this->load->library('googlemaps');
        $config['center'] = $longlat->longlat_pickup;
        $config['zoom'] = '15';
        $this->googlemaps->initialize($config);
		
		$key = 'SumApaLAp05';
		/*
		echo "<pre>";
		print_r($couriers);
		echo "</pre>";
		*/
		if($couriers > 0)
		{
		
			foreach($couriers as $courier)
			{
				$bank = array(
					'order' => $longlat->order_id,
					'courier' => $courier->courier_id
				);
				/*
				$msg  = "<div align='center'><center><b>".ucfirst($courier->nama)."</center><br>";
				if($courier->status_delv_id == 3 or $courier->status_assign == 1 or $courier->status_delv_id == 1)
				{
					$msg .= "<a class='btn btn-primary' href='".base_url()."order/order_detail/$bank[order]'>Detail Order</a></div>";
					$gbr = 'img/courier-2.png';
				}
				elseif($courier->status_delv_id == 2)
				{
					$msg .= "<a class='btn btn-primary' href='".base_url()."order/order_detail/$bank[order]'>Detail Order</a></div>";
					$gbr = 'img/kurir-go.png';
				}
				else
				{
					$msg = "<div align='center'><center><b>".ucfirst($courier->nama)."</center><br><a class='btn btn-primary' href='".base_url()."order/take_curs/$id[order]?courier=$id[courier]'>Assign Me</a></div>";
					$gbr = 'img/kurir.png';
				}

				$marker = array();
				$marker['position'] = $courier->longlat;
				$marker['icon'] = base_url().$gbr;
				$marker['infowindow_content'] = $msg;
				$this->googlemaps->add_marker($marker);
				*/
				
				if($courier->status_delv_id == 0 or $courier->status_delv_id == 4 or $courier->status_delv_id == 7 or $courier->status_delv_id == 8 or $courier->status_delv_id == 9  or $courier->status_delv_id == 10)
				{
					$marker = array();
					$marker['position'] = $courier->longlat;
					$marker['icon'] = base_url().'img/kurir.png';
					$marker['infowindow_content'] = "<div align='center'><center><b>".ucfirst($courier->nama)."</center><br><a class='btn btn-primary' href='".base_url()."order/take_curs/$bank[order]?courier=$bank[courier]'>Assign Me</a></div>";
					$this->googlemaps->add_marker($marker);
				}
			}
		
		}
		
        $marker = array();
        $marker['position'] = $longlat->longlat_pickup;
		$marker['icon'] = base_url()."img/Box-icon.png";
		$marker['infowindow_content'] = $longlat->nama;
        $this->googlemaps->add_marker($marker);
        $data['map'] = $this->googlemaps->create_map();
		//print_r($couriers);
		$data['param'] = 'maps/show';
		//$data['url'] = $id['order'];
		$data['url'] = $order_id;
		$data['akses'] = 'order';
		$data['longlat'] = $longlat->longlat_pickup;
		
        /*echo "<pre>";
		print_r($longlat);
		echo "</pre>";*/
		
		$this->load->view('home', $data);
		
	}
	
	function proses_curs($order_id)
	{
		$longlat = current($this->crud_order->get_kurir($order_id));
		
		$orders = $this->crud_order->get_orders();
		$data['order'] = $this->crud_order->get_orders();
		
		$this->load->library('googlemaps');
        $config['center'] = $longlat->longlat;
        $config['zoom'] = '15';
        $this->googlemaps->initialize($config);
		
		$key = 'SumApaLAp05';
		
		if($orders > 0)
		{
		
		foreach($orders as $order)
		{
			$id = array(
				'order' => $order->order_id,
				'courier' => $longlat->courier_id
			);
			$msg = "<div align='center'><center><b>".ucfirst($order->pickup_name)."</center><br><a class='btn btn-primary' href='".base_url()."order/take_curs/$id[order]?courier=$id[courier]'>Pick Me</a></div>";

			$marker = array();
			$marker['position'] = $order->longlat_pickup;
			$marker['icon'] = base_url()."img/Box-icon.png";
			$marker['infowindow_content'] = $msg;
			$this->googlemaps->add_marker($marker);
		}
		
		}
		
        $marker = array();
        $marker['position'] = $longlat->longlat;
		$marker['icon'] = base_url()."img/kurir.png";
		$marker['infowindow_content'] = '<b>'.$longlat->nama.'<b>';
        $this->googlemaps->add_marker($marker);
        $data['map'] = $this->googlemaps->create_map();
		//print_r($couriers);
		$data['param'] = 'maps/show';
		//$data['url'] = $id['order'];
		$data['url'] = $order_id;
		$data['akses'] = 'kurir';
		$data['longlat'] = $longlat->longlat;
        
		$this->load->view('home', $data);
	}
	
	function take_curs($id)
	{
        if($this->input->post())
        {
            $kuririd = $this->input->post('curs');
        }
        else{
            $kuririd = $this->input->get('courier');
        }
        
        if($this->crud_order->cek_status_terus($kuririd) == 0)
        {
            if($this->input->post())
            {
                $data['courier_id'] =  $this->input->post('curs');
                $data1['courier_id'] =  $this->input->post('curs');
                $kurir = $this->input->post('curs');
            }
            else
            {
                $data['courier_id'] =  $this->input->get('courier');
                $data1['courier_id'] =  $this->input->get('courier');
                $kurir =  $this->input->get('courier');
            }
            $data['id'] = $id;
            
            $data2['status_delv_id'] = 1;
            $data2['order_id'] = $id;
            $this->crud_order->create('order_logs',$data2);
            
            $data1['status_delv_id'] = 1;
            $data1['tgl_kirim'] = date("Y-m-d H:i:s");
            $data1['status_assign'] = 1;
            $data1['user_id'] = $this->session->userdata('id');
            $this->crud_order->update($id,'order_id',$data1,'orders');
            
            $get = current($this->crud_order->get_email($kurir));
            $order = current($this->crud_order->get_detail($id));
            
            $code = implode("/",$data);
            $key = 'POSkurir@email123';

            $string = $this->encrypt->encode($code, $key);
            $url = base64_encode($string);
            $url_param = rtrim($url, '=');
            
            $delv = $this->crud_order->get_delivery($order->telp_delivery);
            $pick = $this->crud_order->get_delivery($order->telp_pickup);
            
            $msg = "<p>Hi <b>".$get->nama."</b>, ada pelanggan yang ingin mengirim dokumen atau barang, <br>";
            
            $msg .= "<table border='0'>";
            $msg .= "<tr><td>Nama Pelanggan</td> <td>:</td> <td><b>".$order->cust_name."</b></td></tr>";
            $msg .= "<tr><td>Nama Pengirim</td> <td>:</td> <td><b>".$pick->nama."</b></td></tr>";
            $msg .= "<tr><td>Nama Penerima</td> <td>:</td> <td><b>".$delv->nama."</b></td></tr>";
            $msg .= "<tr><td>Alamat PickUp</td> <td>:</td> <td>".$order->alamat_pickup."</td></tr>";
            $msg .= "<tr><td>Alamat Delivery</td> <td>:</td> <td>".$order->alamat_delivery."</td></tr>";
            $msg .= "<tr><td>Detail Barang</td> <td>:</td> <td>".$order->detail_barang."</td></tr>";
            $msg .= "</table>";
            $msg .= "<br><br>Tolong,<br>";
            $msg .= "klik ini bila menerima orderan <br> <a href='".base_url()."sent/receive/".$url_param."'><button>Terima</button></a><br><br>";
            $msg .= "klik ini bila menolak orderan <br> <a href='".base_url()."sent/reject/".$url_param."'><button>Tolak</button></a>";
            
            $config = array();
             
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
                    
            /*
            $this->email->initialize($config);
            $this->email->from('pos.kurir@posindonesia.co.id','PT. Pos Indonesia');  
            $this->email->to($get->email);
            $this->email->bcc('pos.smtp@gmail.com'); 
            $this->email->subject('POS Kurir');  
            $this->email->message($msg);  
            $this->email->send();
            */
            
            $subject = "Pos Kurir ".$id;
            
            $this->email->initialize($config);
            $this->email->from('pos.smtp@gmail.com','PT POS INDONESIA');  
            $this->email->to($get->email);
            $this->email->bcc('pos.smtp@gmail.com'); 
            $this->email->subject($subject);  
            $this->email->message($msg);  
            $this->email->send();
            
            //$kurir = $this->input->get('courier');
            
            redirect("order");
            //redirect("order/send_notif/$id?kurir=$kurir");
        }
        else 
        {
            echo '<script>alert("Pengantar sedang dalam tugas");</script>';
            echo '<script>window.history.back();</script>';
        }
		
	}
	
	function take_curs2($id)
	{
		if($this->input->post())
		{
			$data['order_id'] =  $this->input->post('curs');
			$data1['order_id'] =  $this->input->post('curs');
			$kurir = $this->input->post('curs');
		}
		else
		{
			$data['order_id'] =  $this->input->get('courier');
			$data1['order_id'] =  $this->input->get('courier');
			$kurir =  $this->input->get('courier');
		}
		$data['id'] = $id;
		
		$data1['courier_id'] = $id;
		
		$data2['status_delv_id'] = 1;
		$data2['order_id'] = $data['order_id'];
		$this->crud_order->create('order_logs',$data2);
		
		$data1['status_delv_id'] = 1;
		$data1['tgl_kirim'] = date("Y-m-d H:i:s");
		$data1['status_assign'] = 1;
		$data1['user_id'] = $this->session->userdata('id');
		$this->crud_order->update($data['order_id'],'order_id',$data1,'orders');
		
		$get = current($this->crud_order->get_email($kurir));
		$order = current($this->crud_order->get_detail($id));
		
		$code = implode("/",$data);
		$key = 'POSkurir@email123';

		$string = $this->encrypt->encode($code, $key);
		$url = base64_encode($string);
		$url_param = rtrim($url, '=');
		
		$delv = $this->crud_order->get_delivery($order->telp_delivery);
		$pick = $this->crud_order->get_delivery($order->telp_pickup);
		
		$msg = "<p>Hi <b>".$get->nama."</b>, ada pelanggan yang ingin mengirim dokumen atau barang, <br>";
		
		$msg .= "<table border='0'>";
		$msg .= "<tr><td>Nama Pelanggan</td> <td>:</td> <td><b>".$order->cust_name."</b></td></tr>";
		$msg .= "<tr><td>Nama Pengirim</td> <td>:</td> <td><b>".$pick->nama."</b></td></tr>";
		$msg .= "<tr><td>Nama Penerima</td> <td>:</td> <td><b>".$delv->nama."</b></td></tr>";
		$msg .= "<tr><td>Alamat PickUp</td> <td>:</td> <td>".$order->alamat_pickup."</td></tr>";
		$msg .= "<tr><td>Alamat Delivery</td> <td>:</td> <td>".$order->alamat_delivery."</td></tr>";
		$msg .= "<tr><td>Detail Barang</td> <td>:</td> <td>".$order->detail_barang."</td></tr>";
		$msg .= "</table>";
		$msg .= "<br><br>Tolong,<br>";
		$msg .= "klik ini bila menerima orderan <br> <a href='".base_url()."sent/receive/".$url_param."'><button>Terima</button></a><br><br>";
		$msg .= "klik ini bila menolak orderan <br> <a href='".base_url()."sent/reject/".$url_param."'><button>Tolak</button></a>";
		
		$config = array();
		 
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
				
		/*
		$this->email->initialize($config);
		$this->email->from('pos.kurir@posindonesia.co.id','PT. Pos Indonesia');  
		$this->email->to($get->email);
		$this->email->bcc('pos.smtp@gmail.com'); 
		$this->email->subject('POS Kurir');  
		$this->email->message($msg);  
		$this->email->send();
		*/
		
		$subject = "Pos Kurir ".$id;
		
		$this->email->initialize($config);
		$this->email->from('pos.smtp@gmail.com','PT POS INDONESIA');  
		$this->email->to($get->email);
		$this->email->bcc('pos.smtp@gmail.com'); 
		$this->email->subject($subject);  
		$this->email->message($msg);  
		$this->email->send();
		
		//$kurir = $this->input->get('courier');
		
		redirect("order");
		//redirect("order/send_notif/$id?kurir=$kurir");
		
	}
	
	function send_notif($id)
	{
		$order = current($this->crud_order->get_detail($id));
		$delv = $this->crud_order->get_delivery($order->telp_delivery);
		$pick = $this->crud_order->get_delivery($order->telp_pickup);
		$get = current($this->crud_order->get_email($this->input->get('kurir')));
		
		//CUSTOMERS
		
		$msg2  = "<p>Ini adalah detail pengiriman barang dari POS KURIR, <br>";
		$msg2 .= "<table border='0'>";
		$msg2 .= "<tr><td>Nama Pengantar</td> <td>:</td> <td><b>".$get->nama."</b></td></tr>";
		$msg2 .= "<tr><td>Nama Pelanggan</td> <td>:</td> <td><b>".$order->cust_name."</b></td></tr>";
		$msg2 .= "<tr><td>Nama Pengirim</td> <td>:</td> <td><b>".$pick->nama."</b></td></tr>";
		$msg2 .= "<tr><td>Nama Penerima</td> <td>:</td> <td><b>".$delv->nama."</b></td></tr>";
		$msg2 .= "<tr><td>Alamat PickUp</td> <td>:</td> <td>".$order->alamat_pickup."</td></tr>";
		$msg2 .= "<tr><td>Alamat Delivery</td> <td>:</td> <td>".$order->alamat_delivery."</td></tr>";
		$msg2 .= "<tr><td>Detail Barang</td> <td>:</td> <td>".$order->detail_barang."</td></tr>";
		$msg2 .= "<tr><td>Status</td> <td>:</td> <td>".$this->status($order->status_delv_id)."</td></tr></table>";
		$msg2 .= "Terimakasih, telah menggunakan jasa POS Kurir Indonesia.";
		
		$config = array();
		$config2 = array();
		 
		 /*
		$config['charset'] = 'utf-8';
		$config['useragent'] = 'Codeigniter';
		$config['protocol']= "smtp";
		$config['mailtype']= "html";
		$config['smtp_host']= "10.33.41.105";
		$config['smtp_port']= "587";
		$config['smtp_timeout']= "5";
		$config['smtp_user']= "pos.kurir@posindonesia.co.id";
		$config['smtp_pass']= "pk1234";
		$config['crlf']="\r\n"; 
		$config['newline']="\r\n"; 
				
		$this->email->initialize($config);
		$this->email->from('pos.kurir@posindonesia.co.id','PT. Pos Indonesia');  
		$this->email->to($order->email_pickup);
		$this->email->cc($order->email_delivery);
		$this->email->bcc('pos.smtp@gmail.com'); 
		$this->email->subject('POS Kurir');  
		$this->email->message($msg2);  
		$this->email->send();
		*/
		
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
		
		$subject = "Pos Kurir ".$id;
		
		$this->email->initialize($config);
		$this->email->from('pos.smtp@gmail.com','PT. Pos Indonesia');  
		$this->email->to($order->email_pickup);
		$this->email->cc($order->email_delivery);
		$this->email->bcc('pos.smtp@gmail.com'); 
		$this->email->subject($subject);  
		$this->email->message($msg2);  
		$this->email->send();
		
		redirect("order");
		
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
			$a = 'On Waiting';
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
	
	function order_detail($id)
	{
		$kurir = current($this->crud_order->get_detail($id));
		
		if($kurir->courier_id == 0)
		{
			$data['order'] = $this->crud_order->get_detail($id);
			$data['delv'] = $this->crud_order->get_delivery($kurir->telp_delivery);
			$data['pick'] = $this->crud_order->get_delivery($kurir->telp_pickup);
		}
		else
		{
			$data['order'] = $this->crud_order->order_detail($id);
			$data['delv'] = $this->crud_order->get_delivery($kurir->telp_delivery);
			$data['pick'] = $this->crud_order->get_delivery($kurir->telp_pickup);
		}
		/*
		echo "<pre>";
		print_r($data);
		echo "</pre>";
		*/
		$data['param'] = 'orders/details';
		$this->load->view('home',$data);
	}
	
	function search()
	{
		if($this->input->post('status') == ' ')
		{
			redirect("order");
		}
		$data['stat'] = $this->input->post('status');
		$data['order'] = $this->crud_order->get_src($this->input->post('status'));
		$data['param'] = 'orders/show';
		$this->load->view('home',$data);
	}
	
	function reject($id)
	{
		$key = 'POSkurir@email123';
		
		$url_param = $id . str_repeat('=', strlen($id) % 4);
		$url = base64_decode($url_param);
		
		$code = explode("/",$this->encrypt->decode($url, $key));
		
		$order_id = $code[1];
		
		$data1['courier_id'] = $code[0];
		$data1['status_delv_id'] = 0;
		$data1['status_assign'] = 0;
		$this->crud_order->update($order_id,'order_id',$data1,'orders');
		
		
		echo TRUE;
	}
	
	function receive($id)
	{
		$key = 'POSkurir@email123';
		
		$url_param = $id . str_repeat('=', strlen($id) % 4);
		$url = base64_decode($url_param);
		
		$code = explode("/",$this->encrypt->decode($url, $key));
		
		$order_id = $code[1];
		
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
		
		//CUSTOMERS
		
		$msg2  = "<p>Ini adalah detail pengiriman barang dari POS KURIR, <br>";
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
		
		$config = array();
		$config2 = array();
		 
		/*
		$config['charset'] = 'utf-8';
		$config['useragent'] = 'Codeigniter';
		$config['protocol']= "smtp";
		$config['mailtype']= "html";
		$config['smtp_host']= "10.33.41.105";
		$config['smtp_port']= "587";
		$config['smtp_timeout']= "5";
		$config['smtp_user']= "pos.kurir@posindonesia.co.id";
		$config['smtp_pass']= "pk1234";
		$config['crlf']="\r\n"; 
		$config['newline']="\r\n"; 
				
		$this->email->initialize($config);
		$this->email->from('pos.kurir@posindonesia.co.id','PT POS INDONESIA');  
		$this->email->to($order->email_pickup);
		$this->email->cc($order->email_delivery);
		$this->email->bcc('pos.smtp@gmail.com'); 
		$this->email->subject('POS Kurir');  
		$this->email->message($msg2);  
		$this->email->send();
		*/
		
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
		
		$subject = "Pos Kurir ".$order_id;
		
		$this->email->initialize($config);
		$this->email->from('pos.smtp@gmail.com','PT POS INDONESIA');  
		$this->email->to($order->email_pickup);
		$this->email->cc($order->email_delivery);
		$this->email->bcc('pos.smtp@gmail.com'); 
		$this->email->subject($subject);  
		$this->email->message($msg2);  
		$this->email->send();
		
		redirect("order");
		
		echo TRUE;
	}
	
	function logs()
	{
		if($this->input->post())
		{
			if($this->input->post('subjek') == '')
			{
				$data['param'] = 'orders/choose';
				$this->load->view('home',$data);
			}
			elseif($this->input->post('subjek') == 'customers')
			{
				$data['param'] = 'orders/show_logs_customers';
				$data['cust'] = $this->crud_order->logs_customers();
				$data['order'] = $this->crud_order->logs_customers();
				$this->load->view('home',$data);
			}
			elseif($this->input->post('subjek') == 'couriers')
			{
				$data['curs'] = $this->crud_order->logs_couriers();
				$data['order'] = $this->crud_order->logs_couriers();
				$data['param'] = 'orders/show_logs_couriers';
				$this->load->view('home',$data);
			}
		}
		else
		{
			$data['param'] = 'orders/choose';
			$this->load->view('home',$data);
		}
	}
	
	function logs_detail_cust($id)
	{
		$data['logs'] = $this->crud_order->detail_logs($id);
		$data['prof'] = $this->crud_order->detail_logs($id);
		$data['param'] = 'orders/detail_cust';
		$this->load->view('home',$data);
	}
	
	function logs_detail_curs($id)
	{
		$data['logs'] = $this->crud_order->detail_logs($id);
		$data['prof'] = $this->crud_order->detail_logs($id);
		$data['param'] = 'orders/detail_curs';
		$this->load->view('home',$data);
	}
	
	function del_order($id)
	{
		if(!$this->crud_order->delete($id,'order_id','orders'))
		{
			$this->crud_order->delete($id,'order_id','order_logs');
			$msg = array(
				'status' => 1,
				'title' => 'Berhasil',
				'msg' => '<strong>Selamat !!!</strong> anda berhasil menghapus data.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("order");
		}
		else
		{
			$msg = array(
				'status' => 0,
				'title' => 'Gagal',
				'msg' => "<strong>Oh tidak !!!</strong> anda gagal menghapus data.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("order");
		}
	}
}