<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usersController
 *
 * @author Temmy Rustandi Hidayat
 */
class Users extends CI_Controller
{

	function __construct()
    {
      parent::__construct();
	  $this->load->model('crud_user');
    }
	
	function index()
	{
		$data['user'] = $this->crud_user->read();
		$data['param'] = 'users/show';
		$this->load->view('home',$data);
	}
	
	function add_user()
	{
		$data['roles'] = $this->crud_user->get_roles();
		$data['param'] = 'users/form';
		$this->load->view('home',$data);
	}
	
	function signup()
	{
		$data = array(
			'username' => $this->input->post('user'),
			'password' => md5($this->input->post('pass1')),
			'email' => $this->input->post('email'),
			'name' => $this->input->post('name'),
			'role_id' => $this->input->post('role'),
			'status' => 1,
		);
		
		$user = $this->crud_user->look_user($this->input->post('user'));
		$email = $this->crud_user->look_email($this->input->post('email'));
		
		if($user > 0)
		{
			$msg = array(
				'status' => 0,
				'title' => 'Username Sama',
				'msg' => '<strong>Maaf,</strong> Anda memasukkan username yang sama, silakan coba yang lain.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect('users/add_user');
		}
		elseif($email > 0)
		{
			$msg = array(
				'status' => 0,
				'title' => 'Email Sama',
				'msg' => '<strong>Maaf,!!!</strong> Anda memasukkan email yang sama, silakan coba yang lain.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect('users/add_user');
		}
		else
		{
			if(!$this->crud_user->create('users',$data))
			{
				$msg = array(
					'status' => 1,
					'title' => 'Sukses',
					'msg' => '<strong>Berhasil !!!</strong> Anda berhasil memasukkan data.',
				);
				$this->session->set_flashdata('alert',$msg);
				redirect('users');
			}
			else
			{
				$msg = array(
					'status' => 0,
					'title' => 'Gagal',
					'msg' => '<strong>Maaf,</strong> terjadi kesalahan saat memasukkan data.',
				);
				$this->session->set_flashdata('alert',$msg);
				redirect('users/add_user');
			}
		}
	}
	
	function edit($id)
	{
		$data['user'] = $this->crud_user->get_data($id,'users','id');
		$data['param'] = 'users/form';
		$data['roles'] = $this->crud_user->get_roles();
		$data['edit'] = 1;
		$this->load->view('home',$data);
	}
	
	function update()
	{
		$data = array(
			'username' => $this->input->post('user'),
			'password' => md5($this->input->post('pass1')),
			'email' => $this->input->post('email'),
			'name' => $this->input->post('name'),
			'role_id' => $this->input->post('role'),
			'status' =>1,
		);
		
		if($this->input->post('pass1') == '')
		{
			unset($data['password']);
		}
		
		$id = $this->input->post('id');
		$user = $this->crud_user->look_user2($id,$this->input->post('user'));
		$email = $this->crud_user->look_email2($id,$this->input->post('email'));
		
		if($user > 0)
		{
			$msg = array(
				'status' => 0,
				'title' => 'Username sama',
				'msg' => '<strong>Maaf, </strong> Anda mengubah username yang sama, silakan coba yang lain.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("users/edit/$id");
		}
		elseif($email > 0)
		{
			$msg = array(
				'status' => 0,
				'title' => 'Email sama',
				'msg' => '<strong>Maaf, </strong> Anda mengubah email yang sama, silakan coba yang lain.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("users/edit/$id");
		}
		else
		{
			if(!$this->crud_user->update('users',$id,$data,'id'))
			{
				$msg = array(
					'status' => 1,
					'title' => 'Success',
					'msg' => '<strong>Berhasil !!!</strong> Anda berhasil mengubah data.',
				);
				$this->session->set_flashdata('alert',$msg);
				redirect('users');
			}
			else
			{
				$msg = array(
					'status' => 0,
					'title' => 'Gagal',
					'msg' => '<strong>Maaf !!!</strong> terjadi kesalahan saat mengubah data.',
				);
				$this->session->set_flashdata('alert',$msg);
				redirect("users/edit/$id");
			}
		}
	}
	
	function delete($id)
	{
		if(!$this->crud_user->del('users',$id,'id'))
		{
			$msg = array(
				'status' => 1,
				'title' => 'Sukses',
				'msg' => '<strong>Berhasil !!!</strong> Anda sukses menghapus data.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect('users');
		}
		else
		{
			$msg = array(
				'status' => 0,
				'title' => 'Gagal',
				'msg' => '<strong>Maaf, </strong> Anda gagal menghapus data.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect('users');
		}
	}
	
	//USER ROLES
	
	function roles()
	{
		$data['roles'] = $this->crud_user->get_roles();
		$data['param'] = 'roles/show';
		$this->load->view('home',$data);
	}
	
	function add_role()
	{
		$data['param'] = 'roles/form';
		$this->load->view('home',$data);
	}
	
	function signup_role()
	{
		$data['rolename'] = $this->input->post('name');
		$name = $this->crud_user->look_name($this->input->post('name'));
		
		if($name > 0)
		{
			$msg = array(
				'status' => 0,
				'title' => 'Nama sama',
				'msg' => '<strong>Maaf, </strong> Anda gagal memasukkan nama, coba yang lain.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("users/add_role");
		}
		else
		{
			if(!$this->crud_user->create('user_roles',$data))
			{
				$msg = array(
					'status' => 1,
					'title' => 'Sukses',
					'msg' => '<strong>Berhasil !!!</strong> Anda sukses memasukkan data.',
				);
				$this->session->set_flashdata('alert',$msg);
				redirect('users/roles');
			}
			else
			{
				$msg = array(
					'status' => 0,
					'title' => 'Gagal',
					'msg' => '<strong>Maaf, </strong> Anda gagal memasukkan data.',
				);
				$this->session->set_flashdata('alert',$msg);
				redirect("users/add_role");
			}
		}
	}
	
	function edit_role($id)
	{
		$data['roles'] = $this->crud_user->get_data($id,'user_roles','role_id');
		$data['param'] = 'roles/form';
		$data['edit'] = 1;
		$this->load->view('home',$data);
	}
	
	function update_role()
	{
		$data['rolename'] = $this->input->post('name');
		$id = $this->input->post('id');
		$name = $this->crud_user->look_name2($id,$this->input->post('name'));
		
		if($name > 0)
		{
			$msg = array(
				'status' => 0,
				'title' => 'Data sama',
				'msg' => '<strong>Maaf, </strong> Anda gagal mengubah data, coba data yang lain.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("users/edit_role/$id");
		}
		else
		{
			if(!$this->crud_user->update('user_roles',$id,$data,'role_id'))
			{
				$msg = array(
					'status' => 1,
					'title' => 'Sukses',
					'msg' => '<strong>Sukses !!!</strong> Anda berhasil mengubah data.',
				);
				$this->session->set_flashdata('alert',$msg);
				redirect("users/roles");
			}
			else
			{
				$msg = array(
					'status' => 0,
					'title' => 'Gagal',
					'msg' => '<strong>Maaf, </strong> Anda gagal mengubah data.',
				);
				$this->session->set_flashdata('alert',$msg);
				redirect("users/edit_role/$id");
			}
		}
	}
	
	function delete_role($id)
	{
		if(!$this->crud_user->del('user_roles',$id,'role_id'))
		{
			$msg = array(
				'status' => 1,
				'title' => 'Sukses',
				'msg' => '<strong>Berhasil !!!</strong> Anda berhasil menghapus data.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect('users/roles');
		}
		else
		{
			$msg = array(
				'status' => 0,
				'title' => 'Gagal',
				'msg' => '<strong>Maaf, strong> Anda gagal menghapus data.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect('users/roles');
		}
	}
    
    function deactive($id)
    {
        $data['status'] = 0;
        if(!$this->crud_user->non_aktif($id,$data))
		{
			$msg = array(
				'status' => 1,
				'title' => 'Berhasil',
				'msg' => '<strong>Selamat !!!</strong> anda berhasil me-non aktifkan admin.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("users");
		}
		else
		{
			$msg = array(
				'status' => 0,
				'title' => 'Gagal',
				'msg' => "<strong>Oh tidak !!!</strong> anda gagal me-non aktifkan admin.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("users");
		}
        
    }
    
    function active($id)
    {
        $data['status'] = 1;
        if(!$this->crud_user->non_aktif($id,$data))
		{
			$msg = array(
				'status' => 1,
				'title' => 'Berhasil',
				'msg' => '<strong>Selamat !!!</strong> anda berhasil mengaktifkan admin.',
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("users");
		}
		else
		{
			$msg = array(
				'status' => 0,
				'title' => 'Gagal',
				'msg' => "<strong>Oh tidak !!!</strong> anda gagal me-non aktifkan admin.",
			);
			$this->session->set_flashdata('alert',$msg);
			redirect("users");
		}
    }
	
}