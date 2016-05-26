<?php
if($longlat == '')
{
	if($akses = 'order')
	{
		$bank = 'Tidak ada data Latitude dan Longitude di data order ini, silahkan pilih kurir di Combobox yang telah disediakan.';
	}
	else
	{
		$bank = 'Tidak ada data Latitude dan Longitude di data kurir, silahkan pilih order di Combobox yang telah disediakan.';
	}
?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		  <div class="modal-dialog">
			  <div class="modal-content">
				  <div class="modal-header">
					  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					  <h4 class="modal-title">Latitude dan Longitude tidak ada</h4>
				  </div>
				  <div class="modal-body">

					  <?php echo $bank; ?>

				  <div class="modal-footer">
					  <button data-dismiss="modal" class="btn btn-danger" type="button">Tutup</button>
				  </div>
			  </div>
		  </div>
		</div>
</div>
<?php
}
?>

<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-chosen.css" />
	<link href="<?php echo base_url(); ?>css/date.css" rel="stylesheet">
<div class="row">
	<div class="col-lg-12">
		<?php
		//print_r($url);
		if($akses == 'order')
		{
		?>
		<div class="col-lg-12">
		<form class="form-horizontal" role="form" action="<?php echo base_url(); ?>order/take_curs/<?php echo $url; ?>" method="post">
		  <div class="form-group">
			  <label class="control-label col-lg-5" for="exampleInputEmail2">Pilih kurir disini bila tidak ada data kurir terdekat di peta</label>
			  <!--<input type="email" class="form-control" id="demo-input-local" placeholder="Enter Customer">-->
			  <div class="col-lg-4">
				  <!--<select data-placeholder="Nama Pengantar" name="curs" class="form-control" id="chosen-select" onchange="this.form.submit()">
						<option value="" selected></option>
						<?php 
							foreach($kurir as $kur)
							{
								echo '<option value="'.$kur->courier_id.'">'.$kur->nama.'</option>';
							}							
						?>
				  </select>-->
				  
				  <select data-placeholder="Nama Pengantar" name="curs" class="form-control" id="chosen-select">
						<option value="" selected></option>
						<?php 
							foreach($kurir as $kur)
							{
								if($kur->status_delv_id == 0 or $kur->status_delv_id == 4 or $kur->status_delv_id > 6)
								{
									echo '<option value="'.$kur->courier_id.'">'.$kur->nama.'</option>';
								}
							}							
						?>
				  </select>
				  
				  <input type="submit" class="btn btn-primary" value="Proses">
				  
			  </div>
			  </div>
		</form>
		</div>
		<?php
		}
		else
		{
		//print_r($url);
		?>
		<div class="col-lg-12">
		<form class="form-horizontal" role="form" action="<?php echo base_url(); ?>order/take_curs2/<?php echo $url; ?>" method="post">
		  <div class="form-group">
			  <label class="control-label col-lg-5" for="exampleInputEmail2">Pilih order disini bila tidak ada data order terdekat di peta</label>
			  <!--<input type="email" class="form-control" id="demo-input-local" placeholder="Enter Customer">-->
			  <div class="col-lg-4">
				  <!--<select data-placeholder="Daftar Order" name="curs" class="form-control" id="chosen-select" onchange="this.form.submit()">
						<option value="" selected></option>
						<?php 
							foreach($order as $kur)
							{
								echo '<option value="'.$kur->courier_id.'">'.$kur->pickup_name.'</option>';
							}							
						?>
				  </select>-->
				  <select data-placeholder="Daftar Order" name="curs" class="form-control" id="chosen-select">
						<option value="" selected></option>
						<?php 
							foreach($order as $kur)
							{
								if($kur->status_delv_id == 0)
								{
									echo '<option value="'.$kur->order_id.'">'.$kur->order_id.' | '.$kur->pickup_name.' | '.$kur->detail_barang.'</option>';
								}
							}							
						?>
				  </select>
				  
				  <input type="submit" class="btn btn-primary" value="Proses">
			  </div>
		  </div>
		  
		</form>
		</div>
		<?php
		}
		?>
		<br>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h2><i class="fa fa-map-marker red"></i><strong>Pilih Pengantar</strong></h2>
		</div>
		
		<div class="panel-body-map">
		
		<?php echo $map['html'] ?>
						
		</div>
	</div>
	</div>
</div>