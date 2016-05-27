<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of primaryController
 *
 * @author Temmy Rustandi Hidayat
 */
class Primary extends CI_Controller{

	function __construct()
    {
      parent::__construct();
	  $this->load->model('login');
	  $this->load->library('email');
    }

    function index()
    {
	
		$this->load->view('home');
		
    }
	
	function login()
    {
		
		$this->load->view('login');
		
    }

    function home()
    {
    	$user = $this->input->post('user');
    	$pass = md5($this->input->post('pass'));

    	$data = $this->login->login($user,$pass);

    	if($data['row'] > 0)
    	{
			if($data['result']->status == '0')
			{
				$msg = array(
					'status' => 0,
					'title' => 'Gagal',
					'msg' => '<strong>Maaf !!!</strong> akun anda tidak aktif, hubungi Super Admin untuk mengaktifkan akun anda kembali.',
				);
				$this->session->set_flashdata('alert',$msg);
				redirect("primary/login");
			}
			else
            {
                $session = array(
                    'username' => $data['result']->username,
                    'password' => $data['result']->password,
                    'email' => $data['result']->email,
                    'nama' => $data['result']->nama,
                    'role' => $data['result']->role_id,
                    'status' => $data['result']->status,
                   // 'id' => $data['result']->id,
                );

                $this->session->set_userdata($session);
                
                $this->load->view('home');
            }
    	}
    	else
    	{
    		$msg = array(
				'status' => 0,
				'title' => 'Gagal',
				'msg' => '<strong>Maaf !!!</strong> username atau password salah.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("primary/login");
    	}
    }
	
	function signup()
	{
		$this->load->view('signup');
	}
	
	function signup_process()
	{
		$data = array(
			'nama' => $this->input->post('name'),
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password')),
			'email' => $this->input->post('email'),
			'alamat_rumah' => $this->input->post('home'),
			'alamat_kantor' => $this->input->post('office'),
			'telp' => $this->input->post('mobile'),
		);
		
		$this->db->signup($data);
		
		$activation = md5($data['email']);
		
		if(!$this->login->signup($data1,$data2))
		{
			$msg = "<p>Hi <b>".$data2['nama']."</b>, please click this url bellow to activate your account<br><br>".base_url()."primary/activate/".$activation."</p>";
			
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
			$this->email->to($this->input->post('email'));
			$this->email->bcc('pos.smtp@gmail.com'); 
			$this->email->subject('POS || Account Activation');  
			$this->email->message($msg);  
			$this->email->send();
			
			echo "Signup success, check your email to activate your account";
		}
		else
		{
			echo "Signup failed, please try again latter";
		}
	}
	
	function success()
	{
		$this->load->view('success');
	}
	
	function activate($code)
	{
		$status['status'] = 1;
		$this->login->activate($status,$code);
		
		
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect("primary");
	}
	
	function get_field($data)
	{

		header("Access-Control-Allow-Origin: *");
		$data = json_decode(file_get_contents("$data"));

		print_r($data);
		
		if(isset($data))
		{
			echo "succes";
		}
		
	}
	
	function coba()
	{
		$string = "temmy";
		$data = strpos($string,"@");
		
		//filter_var($string,FILTER_VALIDATE_EMAIL) -> email
		$this->load->view('home');
	}

}