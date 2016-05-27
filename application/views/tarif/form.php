-<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-chosen.css" />
	<link href="<?php echo base_url(); ?>css/date.css" rel="stylesheet">
    <script>
      $(function() {
        $('#chosen-select').chosen();
        $('#chosen-till').chosen();
        $('#chosen-select-deselect').chosen({ allow_single_deselect: true });
      });
    </script>
	
<div class="col-lg-12">
  <section class="panel">
	  <header class="panel-heading">
		 <?php echo (isset($edit) ? 'Ubah' : 'Tambah'); ?> Tarif
	  </header>
	  <div class="panel-body">
		  <div class="form">
			  <form class="form-validate form-horizontal " id="register_form" method="post" onsubmit="return konfirmasi('Apakah anda yakin ?');" action="<?php echo base_url(); ?>tarif/<?php echo (isset($edit) ? 'update' : 'create'); ?>">
					  <?php
							if(isset($edit))
							{
								$get = current($tarif);
								
								echo "<input type='hidden' name='id' value='$get->tarif_id'>";
							}
						?>
						
						<?php 
						if($this->session->flashdata('alert') == TRUE)
						{
							$msg = $this->session->flashdata('alert');
						?>
						<!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
						  <div class="modal-dialog">
							  <div class="modal-content">
								  <div class="modal-header">
									  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									  <h4 class="modal-title"><?php echo $msg['title']; ?></h4>
								  </div>
								  <div class="modal-body">

									  <?php echo $msg['msg']; ?>

								  </div>
								  <div class="modal-footer">
									  <button data-dismiss="modal" class="btn <?php echo ($msg['status'] == 0 ? 'btn-danger' : 'btn-primary'); ?>" type="button">Tutup</button>
								  </div>
							  </div>
						  </div>
						</div>
						<!-- modal -->
						<?php
						}
						?>
					
					  <div class="form-group ">
						  <label for="name" class="control-label col-lg-2">Asal <span class="required">*</span></label>
						  <div class="col-lg-5">
							<!--<select data-placeholder="Choose City" name="from" class="form-control" id="chosen-select">
								<option value="" selected></option>
								<?php 
									foreach($asal as $from)
									{
										echo '<option value="'.$from->lokasi_nama.'" '.(isset($edit) ? ($get->asal == $from->lokasi_nama ? 'selected' : '') : '').'>'.$from->lokasi_nama.'</option>';
									}							
								?>
						   </select>-->
						   <input type="from" class="form-control" name="from" value="<?php echo (isset($edit) ? $get->asal : ''); ?>">
						  </div>
					  </div>
						
					  <div class="form-group ">
						  <label for="name" class="control-label col-lg-2">Tujuan <span class="required">*</span></label>
						  <div class="col-lg-5">
							<!--<select data-placeholder="Choose City" name="till" class="form-control" id="chosen-till">
								<option value="" selected></option>
								<?php 
									foreach($tujuan as $till)
									{
										echo '<option value="'.$till->lokasi_nama.'" '.(isset($edit) ? ($get->tujuan == $till->lokasi_nama ? 'selected' : '') : '').'>'.$till->lokasi_nama.'</option>';
									}							
								?>
						    </select>-->
							<input type="from" class="form-control" name="till" value="<?php echo (isset($edit) ? $get->tujuan : ''); ?>">
						  </div>
					  </div>
					  
					  <div class="form-group ">
						  <label for="name" class="control-label col-lg-2">Layanan <span class="required">*</span></label>
						  <div class="col-lg-5">
							<select data-placeholder="Choose Service" name="service" class="form-control">
								<option value="">Pilih Layanan</option>
								<option value="CITY COURIER" <?php echo (isset($edit) ? ($get->layanan == 'CITY COURIER' ? 'selected' : '') : ''); ?>>CITY COURIER</option>
						    </select>
						  </div>
					  </div>
					  
					  <div class="form-group ">
						  <label for="name" class="control-label col-lg-2">Tarif <span class="required">*</span></label>
						  <div class="col-lg-5">
							  <input onkeyup="formatangka1(this);" class=" form-control" name="fare" type="text" value="<?php echo (isset($edit) ? $get->harga : ''); ?>" />
						  </div>
					  </div>
					  
				  <br />
				  <div class="form-group">
					  <div class="col-lg-offset-2 col-lg-10">
						  <input class="btn btn-primary" type="submit" value="Simpan">
					  </div>
				  </div>
			  </form>
		  </div>
	  </div>
  </section>
</div>
</div>