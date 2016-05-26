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
class Ccnter extends CI_Controller{

	function __construct()
    {
      parent::__construct();
	  $this->load->model('crud_ccenter');
	  
    }

    function coba()
    {
        $this->load->library('googlemaps');
        $config['center'] = '-6.9103232,107.62763589999997';
        $config['zoom'] = '15';
        $this->googlemaps->initialize($config);

        $marker = array();
        $marker['position'] = '-6.914744, 107.609000';
        $this->googlemaps->add_marker($marker);
        $data['map'] = $this->googlemaps->create_map();
		
		$data['param'] = 'maps';

        $this->load->view('home', $data);
    }
	
	function index()
	{
		//print_r($this->crud_ccenter->longlat_pickup());
		
		if($this->crud_ccenter->longlat_pickup() == '0')
		{
			$default = '-6.218335,106.802216';
		}
		else
		{
			$longlat = current($this->crud_ccenter->longlat_pickup());
			if($longlat != '0')
			{
				$default = $longlat->longlat;
			}
			else
			{
				$default = '-6.218335,106.802216';
			}
		}
		
		//print_r($default);
        
        //print_r($longlat);
		
		$couriers = $this->crud_ccenter->get_kurir();
		$orders = $this->crud_ccenter->get_orders();
		
		$this->load->library('googlemaps');
        $config['center'] = 'auto';
        $config['zoom'] = '15';
        $this->googlemaps->initialize($config);
		
		$key = 'SumApaLAp05';
		
		if($couriers > 0)
		{
			foreach($couriers as $courier)
			{
				$msg  = "<div align='center'><center><b>".ucfirst($courier->nama)."</center><br>";
				if($courier->status_delv_id == 3 or $courier->status_assign == 1)
				{
					$msg .= "<a class='btn btn-primary' href='".base_url()."order/order_detail/$courier->order_id'>Detail Order</a></div>";
					$gbr = 'img/courier-2.png';
				}
				elseif($courier->status_delv_id == 2)
				{
					$msg .= "<a class='btn btn-primary' href='".base_url()."order/order_detail/$courier->order_id'>Detail Order</a></div>";
					$gbr = 'img/kurir-go.png';
				}
				else
				{
					//$msg .= "<a class='btn btn-success' href='".base_url()."order/proses_curs/$courier->courier_id'>Assign Me</a></div>";
					$gbr = 'img/kurir.png';
				}
				$marker = array();
				$marker['position'] = $courier->longlat;
				$marker['animation'] = 'DROP';
				$marker['icon'] = base_url().$gbr;
				$marker['infowindow_content'] = $msg;
				$this->googlemaps->add_marker($marker);
			}
		}
        
        if($orders > 0)
        {
		
            foreach($orders as $cust)
            {
                $marker = array();
                $marker['position'] = $cust->longlat_pickup;
				$marker['animation'] = 'DROP';
                $marker['icon'] = base_url()."img/Box-icon.png";
                $marker['infowindow_content'] = '<b>'.ucfirst($cust->pickup_name).'</b>';
                $this->googlemaps->add_marker($marker);
            }
        
        }
		
        $data['map'] = $this->googlemaps->create_map();
		//print_r($couriers);
		$data['param'] = 'maps';
        
		$this->load->view('home', $data);
	}
	
	function contoh()
	{
		echo "<pre>";
		print_r($this->crud_ccenter->get_kurir());
		echo "</pre>";
	}
    
    function test()
    {
        echo "Test Command Center";
    }
}