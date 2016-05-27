<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Command Center Controller
 *
 * @author Okyza Maherdy Prabowo
 */
class Customer extends CI_Controller{

	function __construct()
    {
      parent::__construct();
      $this->load->library('email');
      $this->load->model('crud_customer');
	  $this->load->library('RC4');
    }
    
    function register()
    {
        header("Access-Control-Allow-Origin: *");
        
        $key = pack("H*", "560d679e9b4db1121a54f3a16009f33a");
        $iv =  pack("H*", "75a74a0cfa1e56edcdc18bb605ed1b6a");

        //Now we receive the encrypted from the post, we should decode it from base64,
        $encrypted = base64_decode(file_get_contents("php://input"));
        $datas = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC, $iv);

        $clean = preg_replace('/[^\PC\s]/u', '', $datas);
        
        /*
        $clean = preg_replace(
                array(
                    '/\x00/', '/\x01/', '/\x02/', '/\x03/', '/\x04/',
                    '/\x05/', '/\x06/', '/\x07/', '/\x08/', '/\x09/', '/\x0A/',
                    '/\x0B/','/\x0C/','/\x0D/', '/\x0E/', '/\x0F/', '/\x10/', '/\x11/',
                    '/\x12/','/\x13/','/\x14/','/\x15/', '/\x16/', '/\x17/', '/\x18/',
                    '/\x19/','/\x1A/','/\x1B/','/\x1C/','/\x1D/', '/\x1E/', '/\x1F/'
                ),
                
                array(
                    "\\u0000", "\\u0001", "\\u0002", "\\u0003", "\\u0004",
                    "\\u0005", "\\u0006", "\\u0007", "\\u0008", "\\u0009", "\\u000A",
                    "\\u000B", "\u000C", "\\u000D", "\\u000E", "\\u000F", "\\u0010", "\\u0011",
                    "\\u0012", "\u0013", "\\u0014", "\\u0015", "\\u0016", "\\u0017", "\\u0018",
                    "\\u0019", "\\u001A", "\\u001B", "\\u001C", "\\u001D", "\\u001E", "\\u001F"
                ),
                $datas
        );
        */
        
        $data = json_decode($clean);
        
        //echo $data->email;
        
        $insertdata = array(
			'email' => $data->email,
			'password' => md5($data->password)
		);
        
        $email_reg = $data->email;
        
        $num_row = $this->crud_customer->look_email($email_reg);
        
        if($num_row <= 0)
        {
            if(!$this->crud_customer->create('customers',$insertdata))
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
        
        else 
        {   
            echo "Email sudah terdaftar";
        }
    }
    
    
    function login()
    {
        header("Access-Control-Allow-Origin: *");
        $data = json_decode(file_get_contents("php://input"));
       
        //ada email
        //sudah aktivasi
        //$this->crud_customer->get_login(
        //semua True return seluruh profile
        $post_data = array(
          'id' => '12345',
          'name' => 'Jacky M',
          'email' => 'mail@mail.com',
          'homeAddress' => 'Cibiru Bandung',
          'officeAddress' => 'Tegal Lega Bandung',
          'telephone' => '085624236111'
        );

        echo json_encode($post_data);
    }
    
    function test()
    {
        echo "Hello";
    }
    
    function activate($code)
	{
        $status = $this->crud_customer->getstatus($code);
		if ($status == 0)
        {
            $activated = 1;
            if(!$this->crud_customer->activate($code))
            {   
                //echo "Aktivasi berhasil";
                echo '<script>alert("Aktivasi berhasil, silakan login dengan email dan password, serta isi profile Anda");</script>';
                echo '<script>window.close();</script>';
            }
        }
        elseif($status == 1)
		{
			echo '<script>alert("Aktivasi gagal, anda sudah pernah melakukan aktivasi");</script>';
            echo '<script>window.close();</script>';
		}
		else
        {
            echo '<script>alert("Aktivasi gagal");</script>';
            echo '<script>window.close();</script>';
        }
        
	}
    
    function updateprofile()
    {
        header("Access-Control-Allow-Origin: *");
        echo True;
    }
	
	function index()
	{
		$data['cust'] = $this->crud_customer->read_cust();
		$data['param'] = 'customers/show';
		$this->load->view('home',$data);
	}
	
	function search()
	{
		if($this->input->post('status') != ' ')
		{
			$data['cust'] = $this->crud_customer->src_cust($this->input->post('status'));
			$data['param'] = 'customers/show';
			$data['stat'] = $this->input->post('status');
			$this->load->view('home',$data);
		}
		else
		{
			redirect("customer");
		}
	}
	
	function edit($id)
	{
		$data['cust'] = $this->crud_customer->get_cust($id);
		$data['param'] = 'customers/form';
		$data['edit'] = 1;
		$this->load->view('home',$data);
	}
	
	function update()
	{
		$data = array(
			'nama' => $this->input->post('name'),
			'username' => $this->input->post('user'),
			'password' => md5($this->input->post('pass1')),
			'email' => $this->input->post('email'),
			'alamat_rumah' => $this->input->post('home'),
			'alamat_kantor' => $this->input->post('office'),
			'telp' => $this->input->post('phone'),
		);
		
		if($this->input->post('pass1') == '')
		{
			unset($data['password']);
		}
		
		$user = $this->crud_customer->look($this->input->post('user'),$this->input->post('id'),'username','customers_id','customers');
		$email = $this->crud_customer->look($this->input->post('email'),$this->input->post('id'),'email','customers_id','customers');
		$telp = $this->crud_customer->look($this->input->post('phone'),$this->input->post('id'),'telp','customers_id','customers');
		
		if($email > 0)
		{
			$msg = array(
				'status' => 0,
				'title' => 'Same Email',
				'msg' => "<strong>Oh Snap !!!</strong> you insert email which is available, please insert the other one.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("customer/edit/$this->input->post('id')");
		}
		elseif($telp > 0)
		{
			$msg = array(
				'status' => 0,
				'title' => 'Same Phone Number',
				'msg' => "<strong>Oh Snap !!!</strong> you insert phone number which is available, please insert the other one.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("customer/edit/$this->input->post('id')");
		}
		elseif($user > 0)
		{
			$msg = array(
				'status' => 0,
				'title' => 'Same Username',
				'msg' => "<strong>Oh Snap !!!</strong> you insert username which is available, please insert the other one.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("customer/edit/$this->input->post('id')");
		}
		else
		{
			if(!$this->crud_customer->update('customers',$this->input->post('id'),$data,'customers_id'))
			{
				$msg = array(
					'status' => 1,
					'title' => 'Success',
					'msg' => '<strong>Well Done !!!</strong> you success update the data.',
				);
				$this->session->set_flashdata('alert',$msg);
				redirect("customer");
			}
			else
			{
				$msg = array(
					'status' => 0,
					'title' => 'Failed',
					'msg' => "<strong>Oh Snap !!!</strong> you failed update the data.",
				);
				$this->session->set_flashdata('alert',$msg);
				redirect("customer/edit/$this->input->post('id')");
			}
		}
	}
	
	function delete($id)
	{
		if(!$this->crud_customer->del('customers',$id,'customers_id'))
		{
			$msg = array(
				'status' => 1,
				'title' => 'Success',
				'msg' => '<strong>Well Done !!!</strong> you success delete the data.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("customer");
		}
		else
		{
			$msg = array(
				'status' => 0,
				'title' => 'Failed',
				'msg' => "<strong>Oh Snap !!!</strong> you failed delete the data.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("customer");
		}
	}
	
	function deactive($id)
	{
		if(!$this->crud_customer->non_aktif($id))
		{
			$msg = array(
				'status' => 1,
				'title' => 'Berhasil',
				'msg' => '<strong>Selamat !!!</strong> anda berhasil menonaktifkan user.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("customer");
		}
		else
		{
			$msg = array(
				'status' => 0,
				'title' => 'Gagal',
				'msg' => "<strong>Oh tidak !!!</strong> anda gagal menonaktifkan user.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("customer");
		}
		
	}
	
	function active($id)
	{
		if(!$this->crud_customer->aktif($id))
		{
			$msg = array(
				'status' => 1,
				'title' => 'Berhasil',
				'msg' => '<strong>Selamat !!!</strong> anda berhasil mengaktifkan user.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("customer");
		}
		else
		{
			$msg = array(
				'status' => 0,
				'title' => 'Gagal',
				'msg' => "<strong>Oh tidak !!!</strong> anda gagal mengaktifkan user.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("customer");
		}
		
	}
	
	//LEAD CUSTOMERS
	function lead()
	{
		$data['lead'] = $this->crud_customer->get_lead();
		$data['param'] = 'leads/show';
		$this->load->view('home',$data);
	}
	
	function detail($id)
	{
		$data['detail'] = $this->crud_customer->get_detail($id);
		$data['param'] = 'customers/detail';
		$this->load->view('home',$data);
	}
    
}