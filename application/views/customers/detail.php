<div class="row">
	<div class="col-lg-12">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2><strong>Detail Pelanggan</strong></h2>
		</div>
		<script>
		function goBack() {
			window.history.go(-1);
		}
		</script>
		
		<div class="panel-body">
		<?php
		if($detail != 0)
		{
		?>
		
		<?php $data = current($detail); ?>
		
		<div class='form-horizontal'>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Nama Pelanggan</label>
		  <div class="col-sm-10">
			<?php echo $data->nama; ?> 
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Email</label>
		  <div class="col-sm-10">
			<?php echo $data->email; ?> 
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Alamat Rumah</label>
		  <div class="col-sm-10">
			<?php echo $data->alamat_rumah; ?> 
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Alamat Kantor</label>
		  <div class="col-sm-10">
			<?php echo $data->alamat_kantor ?> 
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Telp</label>
		  <div class="col-sm-10">
			<?php echo $data->telp; ?> 
		  </div>
		</div>
		
		<div class="form-group">
		  <label class="col-sm-2 control-label">Waktu Join</label>
		  <div class="col-sm-10">
			<?php echo tgl($data->waktu_join); ?> 
		  </div>
		</div>
				
		</div>
		<?php
		}
		else
		{
		?>
		<div class='form-horizontal'>
		
		<div class="form-group">
		  <div class="col-sm-12">
			<h2>Data Tidak Ditemukan</h2>
		  </div>
		</div>
		
		</div>
		<?php
		}
		?>
		<br><br>
		
		<button class="btn btn-default" onclick="goBack()">Kembali</button>
		</div>
	</div>
	</div>
</div>

<?php
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