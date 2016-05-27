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
			<h2><strong>Detail Order <?php echo ' ['.$data->order_id.'] ' ?></strong></h2>
		</div>
		
		<div class="panel-body">
		
		<div class='form-horizontal'>
		
		<table border="0" class="table table-condensed">
		
			<tr>
				<td>Nama Pelanggan</td>
				<td>:</td>
				<td><?php echo $data->cust_name; ?></td>
			</tr>
			
			<tr>
				<td>Nama Pengirim</td>
				<td>:</td>
				<td><?php echo ($pick == FALSE ? '' : $pick->nama); ?></td>
			</tr>
			
			<tr>
				<td>Nama Penerima</td>
				<td>:</td>
				<td><?php echo ($delv == FALSE ? '' : $delv->nama); ?> </td>
			</tr>
			
			<tr>
				<td>Detail Barang</td>
				<td>:</td>
				<td><?php echo $data->detail_barang ?></td>
			</tr>
			
			<tr>
				<td>Alamat PickUp</td>
				<td>:</td>
				<td><?php echo $data->alamat_pickup; ?></td>
			</tr>
			
			<tr>
				<td>Alamat Delivery</td>
				<td>:</td>
				<td><?php echo $data->alamat_delivery; ?> </td>
			</tr>
			
			<tr>
				<td>Layanan</td>
				<td>:</td>
				<td><?php echo $data->layanan; ?> </td>
			</tr>
			
			<tr>
				<td>Harga</td>
				<td>:</td>
				<td><?php echo 'Rp. '.number_format($data->harga,2,",","."); ?> </td>
			</tr>
			
			<?php
			if($data->status_delv_id == 0)
			{
			if($data->courier_id != 0)
			{
			?>
			<tr>
				<td>Nama Pengantar</td>
				<td>:</td>
				<td><?php if($data->status_delv_id != 0) { echo $data->curs_name; } else { echo "Belum ada pengantar"; } ?></td>
			</tr>
			<?php
			}
			}
			?>
			
			<tr>
				<td>Status</td>
				<td>:</td>
				<td><?php echo status($data->status_delv_id); ?> </td>
			</tr>
			
			<?php
			if($data->berita_order != '')
			{
			?>
			<tr>
				<td>Berita Order</td>
				<td>:</td>
				<td><?php echo $data->berita_order; ?> </td>
			</tr>
			<?php
			}
			?>
			
			<?php
			if($data->status_delv_id == 0)
					{
					?>
			<tr>
				<td></td>
				<td></td>
				<td>
				<?php
					
					  echo '<a class="btn '.(($data->courier_id == 0 and $data->status_delv_id == 0) ? 'btn-success' : 'btn-primary').'" href="'.base_url().'order/proses/'.$data->order_id.'">'.(($data->courier_id == 0 and $data->status_delv_id == 0) ? 'Proses' : (($data->status_delv_id == 0 and $data->courier_id != 0) ? 'Ganti Pengantar' : 'Proses')).'</a>';
					
				?>
				</td>
			</tr>
			<?php
			}
			?>
			
			<?php
			if($data->status_delv_id < 3)
			{
			?>
			<tr>
				<td></td>
				<td></td>
				<td>
				<?php
					  echo '<a class="btn btn-danger" href="'.base_url().'order/del_order/'.$data->order_id.'" onclick="return yakin();">Hapus Order</a>';
				?>
				</td>
			</tr>
			<?php
			}
			?>
		
		</table>
		
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