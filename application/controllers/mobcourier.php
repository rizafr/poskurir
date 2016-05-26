<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Mobile Courier Controller
 *
 * @author PT. Pos Indonesia
 */
class Mobcourier extends CI_Controller{

	function __construct()
    {
      parent::__construct();
      $this->load->library('email');
      $this->load->model('mcrud_courier');
    }
    
    //untuk login
    function login()//done and tested
    {
        $data = $this->getdatafrommobile();
        
        $email = $data->email;
        $password = $data->password;
        
        //echo 2;
        //$email = "syukuri@posindonesia.co.id";
        //$password = "123456";
        
        //$this->mcrud_courier->create('user_roles',array('rolename' => $email));
        
        //cek email sm password
        $cek_login  = $this->mcrud_courier->look_email($email);
        
        //echo $cek_login;
        
        //login benar
        if ($cek_login == 1)
        {
            $cek_password = $this->mcrud_courier->look_password($email,$password);
            //$cek_password = $this->mcrud_customer->look_email($email);
            
            if($cek_password == 1)
            {
                
                //cek aktivasi email berdasarkan email
                $status = $this->mcrud_courier->get_login($email);
                
                //telah aktivasi
                if ($status == 1)
                {
                    //echo 3;
                    //logged in
                    $this->mcrud_courier->logged_in($email);
                    //retrieve data to device
                    $data_cust = $this->mcrud_courier->get_data_courier($email);
                    
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
		//*/
    }
	
	function updateprofile()//done plis kirim customer id dari device
	{
		//blok ambil data dari devices
        $data = $this->getdatafrommobile();
        
        $courier_id = $data->courier_id;
        $nama = $data->nama;
        //$password = $data->password;
        $email = $data->email;
        $alamat = $data->alamat;
        $no_hp_courier = $data->no_hp_courier;
        $longlat = $data->longlat;
        
        
        /*
        $courier_id = "1";
        $nama = "Jonathan Candra";
        $password = "123456";
        $email = "okyzaprabowo@yahoo.com";
        $alamat = "Jalan Gagak No 5";
        $no_hp_courier = "085220802180";
        $longlat = "(-6.911526, 107.629826)";
        */
        
        
        $insertdata = array(
			'nama' => $nama,
			//'password' => md5($password),
            'email' => $email,
            'alamat' => $alamat,
            'no_hp_courier' => $no_hp_courier,
            'longlat' => $longlat
		);
		
		$email = $this->mcrud_courier->look($email,$courier_id,'email','courier_id','couriers');
        //echo $email;
		$telp = $this->mcrud_courier->look($no_hp_courier,$courier_id,'no_hp_courier','courier_id','couriers');
        //echo $telp;
        
        if($email > 0)//email sudah ada
		{
			echo "Email sudah ada";
		}
		elseif($telp > 0)//sudah ada telepon
		{
			echo "telepon sudah ada";
		}
		else //bisa update
		{
			if(!$this->mcrud_courier->update('couriers',$courier_id,$insertdata,'courier_id'))
			{
				echo True;
			}
			else
			{
				echo False;
			}
		}
	}
    
    //untuk ambil service update longlat dari kurir setiap jam
    function get_courier_location()
    {
        $data = $this->getdatafrommobile();
        
        
        $courier_id = $data->courier_id;
        $longlat = $data->longlat;
        
        /*
        echo $courier_id;
        echo "<br>";
        echo $longlat;
        */
        
        
        $insertdata = array(
            'longlat' => $longlat
		);
        
        if(!$this->mcrud_courier->update('couriers',$courier_id,$insertdata,'courier_id'))
		{
			echo True;
		}
		else
		{
			echo False;
		}
        
    }
    
    function logout()//done
    {
        //blok ambil data email dari mobile
        
        $email = "okyzaprabowo@yahoo.com";
        if(!$this->mcrud_courier->logged_out($email))
        {
            echo "Anda berhasil logout";
        }
        else 
        {
            echo "Gagal logout";
        }
        
    }
    
    function senddatatomobile($message)
    {
        //header("Access-Control-Allow-Origin: *");
        
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");
        
        $datas = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $message, MCRYPT_MODE_CBC, $iv);
        $endatas = base64_encode($datas);
        return $endatas;
    }
    
    function getdatafrommobile()//tested
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
    
    function mdecrypt($ciphertext)//not tested
    {
        //header("Access-Control-Allow-Origin: *");
        
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");

        //Now we receive the encrypted from the post, we should decode it from base64,
        $encrypted = base64_decode($ciphertext);
        $datas = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv);

        //$data = json_encode($datas);
        
        return $datas;
    }
	
	/*
	function test()
	{
		$a = $this->mcrud_courier->get_data_courier('syukuri@posindonesia.co.id');
		print_r($a);
	}
	*/
}