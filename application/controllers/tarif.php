<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tarifController
 *
 * @author Temmy Rustandi Hidayat
 */
class Tarif extends CI_Controller
{

	function __construct()
    {
      parent::__construct();
	  $this->load->model('crud_tarif');
    }
	
	function index()
	{
		$data['tarif'] = $this->crud_tarif->read('tarif');
		$data['param'] = 'tarif/show';
		$this->load->view('home',$data);
	}
	
	function add_tarif()
	{
		$data['asal'] = $this->crud_tarif->get_kota();
		$data['tujuan'] = $this->crud_tarif->get_kota();
		$data['param'] = 'tarif/form';
		$this->load->view('home',$data);
	}
	
	function edit($id)
	{
		$data['asal'] = $this->crud_tarif->get_kota();
		$data['tujuan'] = $this->crud_tarif->get_kota();
		$data['tarif'] = $this->crud_tarif->get_data($id,'tarif_id','tarif');
		$data['edit'] = 1;
		$data['param'] = 'tarif/form';
		$this->load->view('home',$data);
	}
	
	function create()
	{
		$data = array(
			'asal' => $this->input->post('from'),
			'tujuan' => $this->input->post('till'),
			'layanan' => $this->input->post('service'),
			'harga' => str_replace(".","",$this->input->post('fare')),
		);
		
		if(!$this->crud_tarif->insert('tarif',$data))
		{
			$msg = array(
				'title' => 'Berhasil Input Tarif',
				'msg' => '<b>Selamat</b>, anda berhasil input tarif.',
				'status' => 1,
			);
			$this->session->set_flashdata('alert',$msg);
			
			redirect("tarif");
		}
		else
		{
			$msg = array(
				'title' => 'Gagal Input Tarif',
				'msg' => '<b>Oh tidak !</b>, anda gagal input tarif, mohon coba lagi.',
				'status' => 0,
			);
			$this->session->set_flashdata('alert',$msg);
			
			redirect("tarif/add_tarif");
		}
	}
	
	function update()
	{
		$data = array(
			'asal' => $this->input->post('from'),
			'tujuan' => $this->input->post('till'),
			'layanan' => $this->input->post('service'),
			'harga' => str_replace(".","",$this->input->post('fare')),
		);
		
		$id = $this->input->post('id');
		
		if(!$this->crud_tarif->update($id,'tarif_id',$data,'tarif'))
		{
			$msg = array(
				'title' => 'Berhasil Ubah Tarif',
				'msg' => '<b>Selamat</b>, anda berhasil mengubah data tarif.',
				'status' => 1,
			);
			$this->session->set_flashdata('alert',$msg);
			
			redirect("tarif");
		}
		else
		{
			$msg = array(
				'title' => 'Gagal Ubah Tarif',
				'msg' => '<b>Oh tidak !</b>, kamu gagal mengubah data tarif',
				'status' => 0,
			);
			$this->session->set_flashdata('alert',$msg);
			
			redirect("tarif/edit/$id");
		}
	}
	
	function delete($id)
	{
		if(!$this->crud_tarif->delete($id,'tarif_id','tarif'))
		{
			$msg = array(
				'title' => 'Sukses Menghapus data',
				'msg' => '<b>Selamat</b>, anda berhasil menghapus data.',
				'status' => 1,
			);
			$this->session->set_flashdata('alert',$msg);
			
			redirect("tarif");
		}
		else
		{
			$msg = array(
				'title' => 'Gagal Menghapus Data',
				'msg' => '<b>Oh tidak !</b>, anda gagal menghapus data',
				'status' => 0,
			);
			$this->session->set_flashdata('alert',$msg);
			
			redirect("tarif");
		}
	}

}