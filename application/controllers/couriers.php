<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of couriersController
 *
 * @author Temmy Rustandi Hidayat
 */
class Couriers extends CI_Controller
{

	function __construct()
    {
      parent::__construct();
	  $this->load->model('crud_courier');
    }

	function index()
	{
		$data['couriers'] = $this->crud_courier->read('couriers');
		$data['param'] = 'couriers/show';
		$this->load->view('home',$data);
	}
	
	function add_courier()
	{
		$data['param'] = 'couriers/form';
		$this->load->view('home',$data);
	}
		
	function create()
	{
		$data = array(
			'courier_id' => $this->input->post('nip'),
			'nama' => $this->input->post('name'),
            'password' => md5($this->input->post('pass1')),
			'alamat' => $this->input->post('address'),
			'email' => $this->input->post('email'),
			'no_hp_courier' => $this->input->post('phone'),
			//'login_state' => '1',
		);
		
		$email = $this->crud_courier->look($this->input->post('email'),'email');
		$nip = $this->crud_courier->look($this->input->post('nip'),'courier_id');
		$phone = $this->crud_courier->look($this->input->post('phone'),'no_hp_courier');
		
		if($email > 0)
		{
			$msg = array(
				'status' => 0,
				'title' => 'Email Sama',
				'msg' => "<strong>Maaf !!!</strong> anda memasukan Email yang sudah ada, tolong masukan Email yang lain.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("couriers/add_courier");
		}
		elseif($nip > 0)
		{
			$msg = array(
				'status' => 0,
				'title' => 'ID Pengantar Sama',
				'msg' => "<strong>Maaf !!!</strong> anda memasukan ID Pengantar yang sudah ada, tolong masukan ID Pengantar yang lain.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("couriers/add_courier");
		}
		elseif($phone > 0)
		{
			$msg = array(
				'status' => 0,
				'title' => 'No Telp Sama',
				'msg' => "<strong>Maaf !!!</strong> anda memasukan No Telp yang sudah ada, tolong masukan No Telp yang lain.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("couriers/add_courier");
		}
		else
		{
			if(!$this->crud_courier->create('couriers',$data))
			{
				$msg = array(
					'status' => 1,
					'title' => 'Success',
					'msg' => '<strong>Selamat !!!</strong> anda berhasil memasukan data.',
				);
				$this->session->set_flashdata('alert',$msg);
				redirect("couriers");
			}
			else
			{
				$msg = array(
					'status' => 0,
					'title' => 'Failed',
					'msg' => "<strong>Maaf !!!</strong> anda gagal memasukan data.",
				);
				$this->session->set_flashdata('alert',$msg);
				redirect("couriers/add_courier");
			}
		}
	}
	
	function edit($id)
	{
		$data['courier'] = $this->crud_courier->get_courier($id,'courier_id','couriers');
		$data['param'] = 'couriers/form';
		$data['edit'] = 1;
		$this->load->view('home',$data);
	}
	
	function update()
	{
		$data = array(
			//'courier_id' => $this->input->post('nip'),
			'nama' => $this->input->post('name'),
			'alamat' => $this->input->post('address'),
            'password' => md5($this->input->post('pass1')),
			'email' => $this->input->post('email'),
			'no_hp_courier' => $this->input->post('phone'),
		);
		
		$id = $this->input->post('id');
		$email = $this->crud_courier->look2($id,$this->input->post('email'),'email');
		$nip = $this->crud_courier->look2($id,$this->input->post('nip'),'courier_id');
		$phone = $this->crud_courier->look2($id,$this->input->post('phone'),'no_hp_courier');
		
		if($email > 0)
		{
			$msg = array(
				'status' => 0,
				'title' => 'Email Sama',
				'msg' => "<strong>Maaf !!!</strong> anda memasukan Email yang sudah ada, tolong masukan Email yang lain.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("couriers/edit/$id");
		}
		elseif($nip > 0)
		{
			$msg = array(
				'status' => 0,
				'title' => 'ID Pengantar Sama',
				'msg' => "<strong>Maaf !!!</strong> anda memasukan ID Pengantar yang sudah ada, tolong masukan ID Pengantar yang lain.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("couriers/edit/$id");
		}
		elseif($phone > 0)
		{
			$msg = array(
				'status' => 0,
				'title' => 'No Telp Sama',
				'msg' => "<strong>Maaf !!!</strong> anda memasukan No Telp yang sudah ada, tolong masukan No Telp yang lain.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("couriers/edit/$id");
		}
		else
		{
			if(!$this->crud_courier->update($id,'courier_id',$data,'couriers'))
			{
				$msg = array(
					'status' => 1,
					'title' => 'Success',
					'msg' => '<strong>Selamat !!!</strong> anda berhasil mengubah data.',
				);
				$this->session->set_flashdata('alert',$msg);
				redirect("couriers");
			}
			else
			{
				$msg = array(
					'status' => 0,
					'title' => 'Failed',
					'msg' => "<strong>Maaf !!!</strong> anda gagal mengubah data.",
				);
				$this->session->set_flashdata('alert',$msg);
				redirect("couriers/edit/$id");
			}
		}
		
	}
	
	function delete($id)
	{
		if(!$this->crud_courier->delete($id,'courier_id','couriers'))
		{
			$msg = array(
				'status' => 1,
				'title' => 'Berhasil',
				'msg' => '<strong>Selamat !!!</strong> anda berhasil menghapus data.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("couriers");
		}
		else
		{
			$msg = array(
				'status' => 0,
				'title' => 'Gagal',
				'msg' => "<strong>Maaf !!!</strong> anda gagal menghapus data.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("couriers");
		}
	}
	
	function deactive($id)
	{
		//$data['password'] = md5(0);
		$data['login_state'] = 0;
		
		if(!$this->crud_courier->non_aktif($id,$data))
		{
			$msg = array(
				'status' => 1,
				'title' => 'Berhasil',
				'msg' => '<strong>Selamat !!!</strong> anda berhasil me-non aktifkan pengantar.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("couriers");
		}
		else
		{
			$msg = array(
				'status' => 0,
				'title' => 'Gagal',
				'msg' => "<strong>Maaf !!!</strong> anda gagal me-non aktifkan pengantar.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("couriers");
		}
	}
	
	function active($id)
	{
		//$data['password'] = md5($id);
		$data['login_state'] = 1;
		if(!$this->crud_courier->aktif($id,$data))
		{
			$msg = array(
				'status' => 1,
				'title' => 'Berhasil',
				'msg' => '<strong>Selamat !!!</strong> anda berhasil mengaktifkan pengantar.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("couriers");
		}
		else
		{
			$msg = array(
				'status' => 0,
				'title' => 'Gagal',
				'msg' => "<strong>Maaf !!!</strong> anda gagal mengaktifkan pengantar.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("couriers");
		}
	}
	
	function search()
	{
		if($this->input->post('status') != ' ')
		{
			$data['couriers'] = $this->crud_courier->get_src($this->input->post('status'));
			$data['stat'] = $this->input->post('status');
			$data['param'] = 'couriers/show';
			$this->load->view('home',$data);
		}
		else
		{
			redirect("couriers");
		}
	}
	
	function upload1($gbr)
	{
		$this->load->library('upload');
		$nmfile = "file_".time(); //nama file saya beri nama langsung dan diikuti fungsi time
		$config['upload_path'] = './assets/images/uploads/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
		$config['max_size'] = '2048'; //maksimum besar file 2M
		$config['max_width']  = '1288'; //lebar maksimum 1288 px
		$config['max_height']  = '768'; //tinggi maksimu 768 px
		$config['file_name'] = $nmfile; //nama yang terupload nantinya
 
		$this->upload->initialize($config);
		 
		if ( ! $this->upload->do_upload($gbr))
		{
			echo 0;
		}
		else
		{
			$dataupload = $this->upload->data();
			return $dataupload['file_name'];
		}
	}
	
	function uploadgambar()
	{
		header("Access-Control-Allow-Origin: *");

		$data = json_decode(file_get_contents("php://input"));
		$latlong = $data->latlong;
		$picture = $data->picture;
		
		$gbr = $this->upload1($picture);
		
		$data = array(
			'courier_id' => 'cur'.time(),
			'nama' => 'contoh',
			'password' => md5(123456),
			'alamat' => 'rancabolang',
			'email' => 'haha@haha.lol',
			'no_hp_courier' => '0000000000',
			'foto' => $gbr,
			'longlat' => $latlong,
			//'login_state' => '1',
		);
		
		if(!$this->crud_courier->create('couriers',$data))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}

}