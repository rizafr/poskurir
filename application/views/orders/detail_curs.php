<style>
th, td {
    border-bottom: 1px solid #ddd;
}
</style>
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-table"></i> Detail Historis Pengantar</h3>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="container panel panel-default">
		
		<?php
		if($logs != 0)
		{
			$profile = current($prof);
		?>
			<br>
			<div class='form-horizontal'>
			
			<table border="0" class="table table-condensed">
				<tr>
					<td width="130px">Nama Pengirim</td>
					<td width="10px">:</td>
					<td><?php echo $profile->pickup_name; ?></td>
				</tr>
				<tr>
					<td>Nama Penerima</td>
					<td>:</td>
					<td><?php echo $profile->delv_name; ?></td>
				</tr>
				<tr>
					<td>Detail Barang</td>
					<td>:</td>
					<td><?php echo $profile->detail_barang; ?></td>
				</tr>
			</table>
			  
			  <h2>Tracking</h2>
			  
			  <table border="0" class="table table-condensed">
			  
			  <?php
			  foreach($logs as $key => $data)
			  {
			  echo '
			  <tr>
				<td width="130px"><b>'.tgl($data->timestamp).'</b></td>
				<td colspan="2">'.(!empty($data->curs_name) ? ($data->status_delv_id > 1 ? '<b>Nama Kurir</b> : '.$data->curs_name.'<br>' : '') : '').'<b>Status</b> : '.status($data->status_delv_id).'</td>
			  </tr>';
			
			  }
			  ?>
			  
			  </table>
			  
			</div>
			<?php
			}
			else
			{
				echo "<h2>Logs data isn't required</h2>";
			}
			?>
		</section>
		<br />
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
		$b = 'juni';
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
	
	$tanggal = $tanggal2[2].' '.$b.' '.$tanggal2[0].'<br> Pukul : '.$tanggal1[1];
	
	return $tanggal;
}

?>