<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of cabangController
 *
 * @author Temmy Rustandi Hidayat
 */
class Cabang extends CI_Controller
{

	function __construct()
    {
      parent::__construct();
	  $this->load->model('crud_cabang');
    }

	function index()
	{
		$data['cabang'] = $this->crud_cabang->read('mypos.tr_grup');
		$data['param'] = 'cabang/show';
		$this->load->view('home',$data);
	}
	
	function add_cabang()
	{
		$data['param'] = 'cabang/form';
		$this->load->view('home',$data);
	}
		
	function create()
	{
		$data = array(
			'nama_grup' => $this->input->post('nama_grup'),
			'kantor' => $this->input->post('kantor'),
			'no_dirian' => $this->input->post('no_dirian'),
			'alamat' => $this->input->post('alamat'),
			'kota' => $this->input->post('kota'),
			'longitude' => $this->input->post('longitude'),
			'latitude' => $this->input->post('latitude'),
		);
		
			if(!$this->crud_cabang->create('mypos.tr_grup',$data))
			{
				$msg = array(
					'status' => 1,
					'title' => 'Success',
					'msg' => '<strong>Selamat !!!</strong> anda berhasil memasukan data.',
				);
				$this->session->set_flashdata('alert',$msg);
				redirect("cabang");
			}
			else
			{
				$msg = array(
					'status' => 0,
					'title' => 'Failed',
					'msg' => "<strong>Maaf !!!</strong> anda gagal memasukan data.",
				);
				$this->session->set_flashdata('alert',$msg);
				redirect("cabang/add_cabang");
			}
	}
	
	function edit($id)
	{
		$data['cabang'] = $this->crud_cabang->get_cabang($id,'id_grup','mypos.tr_grup');
		$data['param'] = 'cabang/form';
		$data['edit'] = 1;
		$this->load->view('home',$data);
	}
	
	function update()
	{
		$data = array(
			'nama_grup' => $this->input->post('nama_grup'),
			'kantor' => $this->input->post('kantor'),
			'no_dirian' => $this->input->post('no_dirian'),
			'alamat' => $this->input->post('alamat'),
			'kota' => $this->input->post('kota'),
			'longitude' => $this->input->post('longitude'),
			'latitude' => $this->input->post('latitude'),
		);
		
		$id = $this->input->post('id');
			if(!$this->crud_cabang->update($id,'id_grup',$data,'mypos.tr_grup'))
			{
				$msg = array(
					'status' => 1,
					'title' => 'Success',
					'msg' => '<strong>Selamat !!!</strong> anda berhasil mengubah data.',
				);
				$this->session->set_flashdata('alert',$msg);
				redirect("cabang");
			}
			else
			{
				$msg = array(
					'status' => 0,
					'title' => 'Failed',
					'msg' => "<strong>Maaf !!!</strong> anda gagal mengubah data.",
				);
				$this->session->set_flashdata('alert',$msg);
				redirect("cabang/edit/$id");
			}
		
	}
	
	function delete($id)
	{
		if(!$this->crud_cabang->delete($id,'cabang_id','cabang'))
		{
			$msg = array(
				'status' => 1,
				'title' => 'Berhasil',
				'msg' => '<strong>Selamat !!!</strong> anda berhasil menghapus data.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("cabang");
		}
		else
		{
			$msg = array(
				'status' => 0,
				'title' => 'Gagal',
				'msg' => "<strong>Maaf !!!</strong> anda gagal menghapus data.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("cabang");
		}
	}
	
	function deactive($id)
	{
		//$data['password'] = md5(0);
		$data['login_state'] = 0;
		
		if(!$this->crud_cabang->non_aktif($id,$data))
		{
			$msg = array(
				'status' => 1,
				'title' => 'Berhasil',
				'msg' => '<strong>Selamat !!!</strong> anda berhasil me-non aktifkan pengantar.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("cabang");
		}
		else
		{
			$msg = array(
				'status' => 0,
				'title' => 'Gagal',
				'msg' => "<strong>Maaf !!!</strong> anda gagal me-non aktifkan pengantar.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("cabang");
		}
	}
	
	function active($id)
	{
		//$data['password'] = md5($id);
		$data['login_state'] = 1;
		if(!$this->crud_cabang->aktif($id,$data))
		{
			$msg = array(
				'status' => 1,
				'title' => 'Berhasil',
				'msg' => '<strong>Selamat !!!</strong> anda berhasil mengaktifkan pengantar.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("cabang");
		}
		else
		{
			$msg = array(
				'status' => 0,
				'title' => 'Gagal',
				'msg' => "<strong>Maaf !!!</strong> anda gagal mengaktifkan pengantar.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("cabang");
		}
	}
	
	function search()
	{
		if($this->input->post('status') != ' ')
		{
			$data['cabang'] = $this->crud_cabang->get_src($this->input->post('status'));
			$data['stat'] = $this->input->post('status');
			$data['param'] = 'cabang/show';
			$this->load->view('home',$data);
		}
		else
		{
			redirect("cabang");
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
			'cabang_id' => 'cur'.time(),
			'nama' => 'contoh',
			'password' => md5(123456),
			'alamat' => 'rancabolang',
			'email' => 'haha@haha.lol',
			'no_hp_cabang' => '0000000000',
			'foto' => $gbr,
			'longlat' => $latlong,
			//'login_state' => '1',
		);
		
		if(!$this->crud_cabang->create('cabang',$data))
		{
			echo 1;
		}
		else
		{
			echo 0;
		}
	}

}