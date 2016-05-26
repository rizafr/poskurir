<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mobile Order Controller
 *
 * @author PT. Pos Indonesia
 */
class Moborder extends CI_Controller{

	function __construct()
    {
      parent::__construct();
      $this->load->library('email');
	  $this->load->model('mcrud_tarif');
      $this->load->model('mcrud_order');
      $this->load->model('mcrud_customer');
      $this->load->model('mcrud_courier');
    }
    
    function buatorder()
    {
        //echo "Hallo";
        
        header("Access-Control-Allow-Origin: *");
        
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");

        //Now we receive the encrypted from the post, we should decode it from base64,
        $encrypted = base64_decode(file_get_contents("php://input"));
        //$datas = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv);

        $clean = preg_replace('/[^\PC\s]/u', '', $encrypted);
        //$clean = preg_replace('/[^\PC\s]/u', '', $datas);
        
        $data = json_decode($clean);
        
        //print_r($data);
        
        
        //order tabel
        $customers_id = $data->personPickup->customers_id;
        $namapickup = $data->personPickup->nama; //diambil jika email pickup tidak ada di customer
        $email_pickup = $data->personPickup->email;
        $alamat_pickup = $data->personPickup->alamat_rumah." dengan detail alamat: ".$data->personPickup->addressDetail;
        $longlat_pickup = $data->personPickup->latlong;
        $telp_pickup = $data->personPickup->telp;
        
        $namadelivery = $data->personDelivery->nama;
        $email_delivery = $data->personDelivery->email;
        $alamat_delivery = $data->personDelivery->alamat_rumah." dengan detail alamat: ".$data->personDelivery->addressDetail;
        $longlat_delivery = $data->personDelivery->latlong;
        $telp_delivery = $data->personDelivery->telp;
        
        $tarif_id = $data->orderInfo->priceId;
        $detail_barang = $data->orderInfo->item; 
        $berita_order = '';
        
        
        
        /*
        //order tabel
        $customers_id = 'custid-cK8jZD0z2i';
        $namapickup = 'Okyza'; //diambil jika email pickup tidak ada di customer
        $email_pickup = 'okyzaprabowo@gmail.com';
        $alamat_pickup = 'Jalan Ayunda 1';
        $longlat_pickup = '-6.911526, 107.629826';
        $telp_pickup = '021333333';
        
        $namadelivery = 'Diansyah';
        $email_delivery = 'diansyahmaulana@gmail.com';
        $alamat_delivery = 'Jalan Hebat 13';
        $longlat_delivery = '-6.911526, 107.629826';
        $telp_delivery = '02211111111';
        
        $tarif_id = '1';
        $detail_barang = 'Ijazah'; 
        $berita_order = '';
        */
		
        
        //generate ID order
        $order_id = 'orid-'.$this->getToken(10);
        $pickid = 'custid-'.$this->getToken(10);
        $deliverid = 'custid-'.$this->getToken(10);
        
        
        //echo $order_id." ". $pickid." ".$deliverid;
        
        
        //simpan data ke array
        $dataorder = array(
            'order_id' => $order_id,
			'customers_id' => $customers_id,
			'email_pickup' => $email_pickup,
            'email_delivery' => $email_delivery,
            'telp_pickup' => $telp_pickup,
            'telp_delivery' => $telp_delivery,
            'tarif_id' => $tarif_id,
            'alamat_pickup' => $alamat_pickup,
            'alamat_delivery' => $alamat_delivery,
            'detail_barang' => $detail_barang,
            'longlat_pickup' => $longlat_pickup,
            'longlat_delivery' => $longlat_delivery
		);
        
        //simpan datalog
        $datalog = array(
            'order_id' => $order_id,
            'status_delv_id' => 0
        );
        
        
        //simpan pick up cust
        $datacustpick = array(
            'customers_id' => $pickid,
            'email' => $email_pickup,
            'nama' => $namapickup,
            'alamat_rumah' => $alamat_pickup,
            'telp' => $telp_pickup,
            'longlat_cust' => $longlat_pickup
        );
        
        
        //simpan deliver cust
        $datacustdeliver = array(
            'customers_id' => $deliverid,
            'email' => $email_delivery,
            'nama' => $namadelivery,
            'alamat_rumah' => $alamat_delivery,
            'telp' => $telp_delivery,
            'longlat_cust' => $longlat_delivery
        );
        
        //Proses cek pick up dan delivery untuk menjadi customer
        $isPickupCust = $this->mcrud_customer->look_phone($telp_pickup);
        $isDeliverCust = $this->mcrud_customer->look_phone($telp_delivery);
        
        //diperbolehkan email sama untuk beberapa customer
        if($isPickupCust == 0) 
        {
            //echo "Pick berhasil ditambah";
            $this->mcrud_customer->create('customers',$datacustpick);
        }
        else
        {
            //echo "Pick sudah customer";
            //echo False;
        }
        
        if($isDeliverCust == 0)
        {
            //echo "Delivered berhasil ditambah";
            $this->mcrud_customer->create('customers',$datacustdeliver);
        }
        else
        {
            //echo "Delivered sudah customer";
            //echo False;
        }
        
        //Proses Order
        if(!$this->mcrud_order->create('orders',$dataorder))
        {
            //insert order logs
            $this->mcrud_order->createlog('order_logs',$datalog);
            try
                {         
                    echo True;
                    /*
                    $msg = "<p>Hai <b>".$namapickup."</b>, order dengan informasi berikut <br>
                            Nama Penerima : ".$namadelivery."<br>
                            Alamat Penerima : ".$alamat_delivery."<br>
                            Detail Barang : ".$detail_barang."<br>
                            Dalam Status : Request<br>
                            Terima Kasih";
                    */
                    //echo $msg;

                    $order = current($this->mcrud_order->get_detail($order_id));
                    //print_r($order)
                    $delv = $this->mcrud_order->get_delivery($order->telp_delivery);
                    $pick = $this->mcrud_order->get_delivery($order->telp_pickup);
                    $get = current($this->mcrud_order->get_email($order->courier_id));
                    
                    $msg2  = "<p>Ini adalah detail pengiriman barang dari POS KURIR, <br>";
					$msg2 .= "<table border='0'>";
                    $msg2 .= "<tr><td>Nama Pelanggan</td> <td>:</td> <td><b>".$order->cust_name."</b></td></tr>";
                    $msg2 .= "<tr><td>Nama Pengirim</td> <td>:</td> <td><b>".$pick->nama."</b></td></tr>";
                    $msg2 .= "<tr><td>Nama Penerima</td> <td>:</td> <td><b>".$delv->nama."</b></td></tr>";
                    $msg2 .= "<tr><td>Alamat PickUp</td> <td>:</td> <td>".$order->alamat_pickup."</td></tr>";
                    $msg2 .= "<tr><td>Alamat Delivery</td> <td>:</td> <td>".$order->alamat_delivery."</td></tr>";
                    $msg2 .= "<tr><td>Detail Barang</td> <td>:</td> <td>".$order->detail_barang."</td></tr>";
                    $msg2 .= "<tr><td>Status</td> <td>:</td> <td>"."Request"."</td></tr>";
                    $msg2 .= "</table>";
                    $msg2 .= "Terimakasih, telah menggunakan jasa POS Kurir Indonesia.";
                    
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
                            
                    $this->email->initialize($config);
                    $this->email->from('pos.smtp@gmail.com','PT POS INDONESIA');  
                    $this->email->to($email_pickup);
                    $this->email->bcc('pos.smtp@gmail.com'); 
                    $this->email->subject('Pos Kurir Order Notification ['.$dataorder['order_id'].']');  
                    $this->email->message($msg2);  
                    $this->email->send();
                    
                    
                    
                }
                catch (Exception $e)
                {
                    echo False;
                }
        }
        
    }
    
    //update status log dr device
    function update_status_log()
    {
        
        //header("Access-Control-Allow-Origin: *");
        $data = $this->getdatafrommobilecust();
        
        //print_r($data);
        //echo "Data"
        //echo json_encode($data);
        
        //echo 'Atuh lahh';
        $order_id = $data->order_id;
        $status_delv_id = $data->status_delv_id;
        $berita_order = $data->berita_order;
        $longlat = $data->longlat;
        
        
        /*
        $order_id = 'orid-BcbSXUQuS4';
        $status_delv_id ='2';
        $berita_order = 'Ini update';
        $longlat = '-6.909608839284876, 107.6291822698364';
        */
        
        $insertdata = array(
            'longlat' => $longlat
		);
        
        
        //simpan datalog
        $datalog = array(
            'status_delv_id' => $status_delv_id,
            'berita_order' => $berita_order
        );
        
        $orderslog = array(
            'order_id' => $order_id,
            'status_delv_id' => $status_delv_id,
            'longlat' => $longlat
            
        );
        
        //update longlat ke profile
        $courier_id = $this->mcrud_order->getCourierByOrder($order_id);
        $this->mcrud_courier->update('couriers',$courier_id,$insertdata,'courier_id');
        
        if(!$this->mcrud_order->update($order_id,'order_id',$datalog,'orders'))
        {
            if(!$this->mcrud_order->createlog('order_logs',$orderslog))
            {
                echo True;
                
                $order = current($this->mcrud_order->get_detail($order_id));
                //print_r($order)
                $delv = $this->mcrud_order->get_delivery($order->telp_delivery);
                $pick = $this->mcrud_order->get_delivery($order->telp_pickup);
                $get = current($this->mcrud_order->get_email($order->courier_id));
                
                $msg2  = "<p>Ini adalah detail pengiriman barang dari POS KURIR, <br>";
				$msg2 .= "<table border='0'>";
                $msg2 .= "<tr><td>Nama Pengantar</td> <td>:</td> <td><b>".$get->nama."</b></td></tr>";
                $msg2 .= "<tr><td>Nama Pelanggan</td> <td>:</td> <td><b>".$order->cust_name."</b></td></tr>";
                $msg2 .= "<tr><td>Nama Pengirim</td> <td>:</td> <td><b>".$pick->nama."</b></td></tr>";
                $msg2 .= "<tr><td>Nama Penerima</td> <td>:</td> <td><b>".$delv->nama."</b></td></tr>";
                $msg2 .= "<tr><td>Alamat PickUp</td> <td>:</td> <td>".$order->alamat_pickup."</td></tr>";
                $msg2 .= "<tr><td>Alamat Delivery</td> <td>:</td> <td>".$order->alamat_delivery."</td></tr>";
                $msg2 .= "<tr><td>Detail Barang</td> <td>:</td> <td>".$order->detail_barang."</td></tr>";
                $msg2 .= "<tr><td>Status</td> <td>:</td> <td>".$this->status($order->status_delv_id)."</td></tr>";
				if($order->status_delv_id > 3)
				{
                $msg2 .= "<tr><td>Berita Order</td> <td>:</td> <td>".$order->berita_order."</td></tr>";
				}
				$msg2 .= "</table>";
                $msg2 .= "Terimakasih, telah menggunakan jasa POS Kurir Indonesia.";
                
                $subject = 'Pos Kurir Order '.$order_id;
                //echo $msg2;
                
                
                if ($order->email_pickup != null)
                {
                    $this->sendmail($msg2, $subject, $order->email_pickup);
                }
                if ($order->email_delivery != null)
                {
                    $this->sendmail($msg2, $subject, $order->email_delivery);
                }
                
                
                
            }
            
            else
            {
                echo False;
            }
            
            //echo True;
        }
        else
        {
            echo False;
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
			$a = 'Retour';
			break;
			
			case '8';
			$a = 'Retour Delivered';
			break;
			
			case '7';
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
    
    //ambil pickup tarif
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
        $data = $this->mcrud_tarif->get_tarif();
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
    
    function get_courier_order()
    {
        $data = $this->getdatafrommobilecust();

        $courierId = $data->courier_id;
        //$courierId = '123456789';
        $courierOrder = $this->mcrud_order->getOrderDetail($courierId);
        
        echo json_encode($courierOrder);
        
        //$encrypted = $this->senddatatomobile(json_encode($courierOrder));
    }
    
    function order_log_cust()
	{
		$data = $this->getdatafrommobilecust();
        $order_id = $data->key;
        
        //echo $order_id;
        //$order_id = 'orid-8imHqha0bF';
        //echo strlen($order_id);
        $datas = $this->mcrud_order->detail_logs($order_id);
        
        //print_r($datas);
        
        
        $i = 0;
        $kirim = array();
        if ($this->is_iterable($datas))
        {
            foreach($datas as $data)
            {
                switch($data->status_delv_id)
                {
                    case "0":
                        $a = array('status' => 'Request', 'tanggal' => $data->timestamp);
                        array_push($kirim,$a);
                        break;
                    case "1":
                        $a = array('status' => 'On-Assignment', 'tanggal' => $data->timestamp);
                        array_push($kirim,$a);
                        break;
                    case "2":
                        $a = array('status' => 'On-Waiting', 'tanggal' => $data->timestamp);
                        array_push($kirim,$a);
                        break;
                    case "3":
                        $a = array('status' => 'Pick Up', 'tanggal' => $data->timestamp);
                        array_push($kirim,$a);
                        break;
                    case "4":
                        $a = array('status' => 'Delivered', 'tanggal' => $data->timestamp);
                        array_push($kirim,$a);
                        break;
                    case "5":
                       $a = array('status' => 'Rejected', 'tanggal' => $data->timestamp);
                        array_push($kirim,$a);
                        break;
                    case "6":
                        $a = array('status' => 'Retour', 'tanggal' => $data->timestamp);
                        array_push($kirim,$a);
                        break;
                    case "7":
                        $a = array('status' => 'Rejected Delivered', 'tanggal' => $data->timestamp);
                        array_push($kirim,$a);
                        break;
                    case "8":
                        $a = array('status' => 'Retour Delivered', 'tanggal' => $data->timestamp);
                        array_push($kirim,$a);
                        break;
                    case "9":
                        $a = array('status' => 'Financial Acceptance', 'tanggal' => $data->timestamp);
                        array_push($kirim,$a);
                        break;
                    case "10":
                        $a = array('status' => 'Completed', 'tanggal' => $data->timestamp);
                        array_push($kirim,$a);
                        break;
                }
                $i++;
            }
            
            echo json_encode($kirim);
        
        }
        
    }

    function getdatafrommobile()//tested
    {
        header("Access-Control-Allow-Origin: *");
        
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");

        //Now we receive the encrypted from the post, we should decode it from base64,
        $encrypted = base64_decode(file_get_contents("php://input"));
        $datas = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv);

        //$clean = preg_replace('/[^\PC\s]/u', '', $encrypted);
        $clean = preg_replace('/[^\PC\s]/u', '', $datas);
        $data = json_decode($clean);
        
        return $data;
    }
    
    function getdatafrommobilecust()//tested
    {
        header("Access-Control-Allow-Origin: *");
        
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");

        //Now we receive the encrypted from the post, we should decode it from base64,
        $encrypted = base64_decode(file_get_contents("php://input"));
        //$datas = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv);

        $clean = preg_replace('/[^\PC\s]/u', '', $encrypted);
        //$clean = preg_replace('/[^\PC\s]/u', '', $datas);
        $data = json_decode($clean);
        
        return $data;
    }
    
    
    function senddatatomobile($message)
    {
        header("Access-Control-Allow-Origin: *");
        
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");
        
        $datas = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $message, MCRYPT_MODE_CBC, $iv);
        $endatas = base64_encode($datas);
        return $endatas;
    }
    
    
    
    
    function is_iterable($var)
    {
        return $var !== null 
        && (is_array($var) 
            || $var instanceof Traversable 
            || $var instanceof Iterator 
            || $var instanceof IteratorAggregate
            );
    }
    
    
    function crypto_rand_secure($min, $max)
    {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
        $log = ceil(log($range, 2));
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    function getToken($length)
    {
        $token = "";
        //$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        //$codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        //$codeAlphabet.= "0123456789";
        $codeAlphabet= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max)];
        }
        return $token;
    }
    
    
    function sendmail($message, $subject, $destination)
    {
        $msg = $message;
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
                            
        $this->email->initialize($config);
        $this->email->from('pos.smtp@gmail.com','PT POS INDONESIA');  
        $this->email->to($destination);
        $this->email->bcc('pos.smtp@gmail.com'); 
        $this->email->subject($subject);  
        $this->email->message($msg);  
        $this->email->send();
    }
    
}
