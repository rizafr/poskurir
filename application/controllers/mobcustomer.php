<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mobile Customer Controller
 *
 * @author PT. Pos Indonesia
 */
class Mobcustomer extends CI_Controller{

	function __construct()
    {
      parent::__construct();
      $this->load->library('email');
      $this->load->model('mcrud_customer');
    }
    
    function register()//done and tested
    {
        header("Access-Control-Allow-Origin: *");
        
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");

        $encrypted = base64_decode(file_get_contents("php://input"));
        //$datas = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv);

        $clean = preg_replace('/[^\PC\s]/u', '', $encrypted);
        // $clean = preg_replace('/[^\PC\s]/u', '', $datas);
        $data = json_decode($clean);
        
        //generate custid
        $custid = 'custid-'.$this->getToken(10);
        
        $insertdata = array(
            'customers_id' => $custid,
			'email' => $data->email,
			'password' => md5($data->password)
		);
        
        $email_reg = $data->email;
        
        $num_row = $this->mcrud_customer->look_email($email_reg);
        
        if($num_row <= 0)
        {
            if(!$this->mcrud_customer->create('customers',$insertdata))
			{
                try
                {
                    echo True;
                    $activation = md5($data->email);
                    
                    $msg = "<p>Hai <b>".$data->email."</b>, silakan klik tautan berikut ini untuk aktivasi akun <br><br>".base_url()."customer/activate/".$activation."</p>";
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
                    $this->email->to($data->email);
                    $this->email->bcc('pos.smtp@gmail.com'); 
                    $this->email->subject('POS || Account Activation');  
                    $this->email->message($msg);  
                    $this->email->send();
                    
                    
                    
                }
                catch (Exception $e)
                {
                    echo False;
                }
			}
        }
        
        else 
        {   
            //sudah pernah jadi pick up data delivery
            //echo "Email sudah terdaftar";
            
            $updatedata = array(
                'password' => md5($data->password)
            );
            
            if(!$this->mcrud_customer->update('customers',$email_reg, $updatedata, 'email'))
			{
                try
                {
                    $activation = md5($data->email);
                    
                    $msg = "<p>Hai <b>".$data->email."</b>, silakan klik tautan berikut ini untuk aktivasi akun <br><br>".base_url()."customer/activate/".$activation."</p>";
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
                    $this->email->to($data->email);
                    $this->email->bcc('pos.smtp@gmail.com'); 
                    $this->email->subject('POS || Account Activation');  
                    $this->email->message($msg);  
                    $this->email->send();
                    
                    
                    echo True;
                }
                catch (Exception $e)
                {
                    echo False;
                }
			}
        }
    }
    
    
    function login()//done and tested
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
        
        $email = $data->email;
        $password = $data->password;
        
        
        //echo 2;
        //$email = "okyzaprabowo@yahoo.com";
        //$password = "123456";
        //cek email sm password
        $cek_login  = $this->mcrud_customer->look_email($email);
        
        //echo $cek_login;
        
        //login benar
        if ($cek_login == 1)
        {
            $cek_password = $this->mcrud_customer->look_password($email,$password);
            //$cek_password = $this->mcrud_customer->look_email($email);
            
            if($cek_password == 1)
            {
                
                //cek aktivasi email berdasarkan email
                $status = $this->mcrud_customer->get_login($email);
                
                //telah aktivasi
                if ($status == 1)
                {
                    //echo 3;
                    //logged in
                    $this->mcrud_customer->logged_in($email);
                    //retrieve data to device
                    $data_cust = $this->mcrud_customer->get_data_customer($email);
                    
                    //echo $this->senddatatomobileI(json_encode($data_cust));
                    echo json_encode($data_cust);
                }
                
                //belum aktivasi
                else 
                {
                    echo 3;
                } 
            }
            else 
            {
                echo 2;
            }
        }
        //login salah
        else 
        {
            echo 1;
        }
        
    }
    
    function activate($code)//done and tested
	{
        $status = $this->mcrud_customer->getstatus($code);
		if ($status == 0)
        {
            $activated = 1;
            if(!$this->mcrud_customer->activate($code))
            {   
                //echo "Aktivasi berhasil";
                echo '<script>alert("Aktivasi berhasil");</script>';
                echo '<script>window.close();</script>';
            }
        }
        else
        {
            echo '<script>alert("Aktivasi gagal");</script>';
            echo '<script>window.close();</script>';
        }
        
	}
	
	function updateprofile()//done pand tested
	{
		//blok ambil data dari devices
        
        header("Access-Control-Allow-Origin: *");
        
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");

        //Now we receive the encrypted from the post, we should decode it from base64,
        $encrypted = base64_decode(file_get_contents("php://input"));
        //$datas = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv);

        $clean = preg_replace('/[^\PC\s]/u', '', $encrypted);
        //$clean = preg_replace('/[^\PC\s]/u', '', $datas);
        $data = json_decode($clean);
        
        //echo json_encode($data);
        
        $customers_id = $data->customers_id;
        $nama = $data->nama;
        $password = $data->password;
        $email = $data->email;
        $alamat_rumah = $data->alamat_rumah;
        $alamat_kantor = $data->alamat_kantor;
        $telp = $data->telp;
        //$longlat_cust = $data->longlat_cust;
        
        /*
        $customers_id = "15";
        $nama = "Hoka Hoka Bento";
        $password = "123456";
        $email = "okyzaprabowo@gmail.com";
        $alamat_rumah = "Jalan Gagak No 5";
        $alamat_kantor = "Jalan Banda No 5";
        $telp = "000000000";
        $longlat_cust = "(-6.911526, 107.629826)";
        */
        
        
        $insertdata = array(
			'nama' => $nama,
			//'password' => md5($password),
            'email' => $email,
            'alamat_rumah' => $alamat_rumah,
            'alamat_kantor' => $alamat_kantor,
            'telp' => $telp,
            //'longlat_cust' => $longlat_cust
		);
		
		$email = $this->mcrud_customer->look($email,$customers_id,'email','customers_id','customers');
		$telp = $this->mcrud_customer->look($telp,$customers_id,'telp','customers_id','customers');
        
        if($telp > 0)//email sudah ada
		{
			echo "Telepon sudah ada";
		}
		//elseif($telp > 0)//sudah ada telepon
		//{
		//	echo "telepon sudah ada";
		//}
		else //bisa update
		{
			if(!$this->mcrud_customer->update('customers',$customers_id,$insertdata,'customers_id'))
			{
				echo True;
			}
			else
			{
				echo False;
			}
		}
        
        
	}
    
    function logout()//done
    {
        //blok ambil data email dari mobile
        
        $email = "okyzaprabowo@yahoo.com";
        if(!$this->mcrud_customer->logged_out($email))
        {
            echo "Anda berhasil logout";
        }
        else 
        {
            echo "Gagal logout";
        }
        
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
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[$this->crypto_rand_secure(0, $max)];
        }
        return $token;
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
    
    function getdatafrommobile()//not tested
    {
        header("Access-Control-Allow-Origin: *");
        
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");
        
        //Now we receive the encrypted from the post, we should decode it from base64,
        $encrypted = base64_decode(file_get_contents("php://input"));
        $datas = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv);

        $clean = preg_replace('/[^\PC\s]/u', '', $datas);
        $data = json_decode($clean);
        
        return $data;
    }
}