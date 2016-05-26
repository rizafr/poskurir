<script>
function yakin()
{
	var konfirm = confirm("Apa anda yakin menghapus ini ?");
	
	if(konfirm == false)
	{
		return false;
	}
}
</script>
<div class="row">
	<div class="col-lg-12">
	<div class="panel panel-default">
		<?php $data = current($order); ?>
		
		<div class="panel-heading">
			<h2><strong>Detail Order</strong> <?php echo '|'.$data->order_id ?></h2>
		</div>
		
		<div class="panel-body">
		
		<div class='form-horizontal'>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Nama Pelanggan</label>
		  <div class="col-sm-10">
			<?php echo $data->cust_name; ?> 
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Nama Pengirim</label>
		  <div class="col-sm-10">
			<?php echo ($pick == FALSE ? '' : $pick->nama); ?> 
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Nama Penerima</label>
		  <div class="col-sm-10">
			<?php echo ($delv == FALSE ? '' : $delv->nama); ?> 
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Detail Barang</label>
		  <div class="col-sm-10">
			<?php echo $data->detail_barang ?> 
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Alamat PickUp</label>
		  <div class="col-sm-10">
			<?php echo $data->alamat_pickup; ?> 
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Alamat Delivery</label>
		  <div class="col-sm-10">
			<?php echo $data->alamat_delivery; ?> 
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Layanan</label>
		  <div class="col-sm-10">
			<?php echo $data->layanan; ?> 
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Harga</label>
		  <div class="col-sm-10">
			<?php echo 'Rp. '.number_format($data->harga,2,",","."); ?> 
		  </div>
		</div>
		
		<?php
		if($data->courier_id != 0)
		{
		?>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Nama Pengantar</label>
		  <div class="col-sm-10">
			<?php echo $data->curs_name; ?> 
		  </div>
		</div>
		
		<?php
		}
		?>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Status</label>
		  <div class="col-sm-10">
			<?php echo status($data->status_delv_id); ?> 
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Berita Order</label>
		  <div class="col-sm-10">
			<?php echo $data->berita_order; ?> 
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label"> </label>
		  <div class="col-sm-10">
		  <?php
			if($data->status_delv_id == 0)
			{
			  echo '<a class="btn '.(($data->courier_id == 0 and $data->status_delv_id == 0) ? 'btn-success' : 'btn-primary').'" href="'.base_url().'order/proses/'.$data->order_id.'">'.(($data->courier_id == 0 and $data->status_delv_id == 0) ? 'Proses' : (($data->status_delv_id == 0 and $data->courier_id != '0') ? 'Proses' : 'Ubah Pengantar')).'</a>';
			}
		  ?>
		  </div>
		</div>
		<?php
		if($data->status_delv_id < 3)
		{
		?>
		<div class="form-group">
		  <label class="col-sm-2 control-label"> </label>
		  <div class="col-sm-10">
		  <?php
			  echo '<a class="btn btn-danger" href="'.base_url().'order/del_order/'.$data->order_id.'" onclick="return yakin();">Hapus Order</a>';
		  ?>
		  </div>
		</div>
		<?php
		}
		?>
		</div>
		</div>
	</div>
	</div>
</div>

<?php

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
		$a = 'On Waitting';
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

function tgl($tgl)
{
	$tanggal1 = explode(" ",$tgl);
	$tanggal2 = explode("-",$tanggal1[0]);
	
	switch($tanggal2[1])
	{
		case '01';
		$b = 'Januari';
		break;
		
		case '02';
		$b = 'Februari';
		break;
		
		case '03';
		$b = 'Maret';
		break;
		
		case '04';
		$b = 'April';
		break;
		
		case '05';
		$b = 'Mei';
		break;
		
		case '06';
		$b = 'Juni';
		break;
		
		case '07';
		$b = 'Juli';
		break;
		
		case '08';
		$b = 'Agustus';
		break;
		
		case '09';
		$b = 'September';
		break;
		
		case '10';
		$b = 'Oktober';
		break;
		
		case '11';
		$b = 'November';
		break;
		
		case '12';
		$b = 'Desember';
		break;
	}
	
	$tanggal = $tanggal2[2].' '.$b.' '.$tanggal2[0];
	
	return $tanggal;
}

?>