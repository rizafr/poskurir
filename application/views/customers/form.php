<div class="col-lg-12">
  <section class="panel">
	  <header class="panel-heading">
		 Ubah Data Pelanggan
	  </header>
	  <div class="panel-body">
		  <div class="form">
			  <form class="form-validate form-horizontal " id="register_form" method="post" action="<?php echo base_url(); ?>customer/update">
						<?php
							$get = current($cust);
						?>
						<input type='hidden' name='id' value='<?php echo $get->customers_id; ?>'>
						
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
			<fieldset>
			<legend>Login Data</legend>
			  <div class="form-group ">
				  <label for="name" class="control-label col-lg-2">Username <span class="required">*</span></label>
				  <div class="col-lg-5">
					  <input class=" form-control" name="user" type="text" value="<?php echo $get->username; ?>" />
				  </div>
			  </div>
			  <div class="form-group ">
				  <label for="name" class="control-label col-lg-2">Password <span class="required">*</span></label>
				  <div class="col-lg-5">
					  <input class=" form-control" id="pass1" name="pass1" type="password" />
				  </div>
			  </div>
			  <div class="form-group ">
				  <label for="name" class="control-label col-lg-2">Confirm Password <span class="required">*</span></label>
				  <div class="col-lg-5">
					  <input class=" form-control" name="pass2" type="password" />
				  </div>
			  </div>
			  <div class="form-group ">
				  <label for="name" class="control-label col-lg-2">Email <span class="required">*</span></label>
				  <div class="col-lg-5">
					  <input class=" form-control" name="email" type="text" value="<?php echo $get->email; ?>" />
				  </div>
			  </div>
			</fieldset>

			<fieldset>
			<legend>Data Pribadi</legend>
			  <div class="form-group ">
				  <label for="name" class="control-label col-lg-2">Nama <span class="required">*</span></label>
				  <div class="col-lg-5">
					  <input class=" form-control" name="name" type="text" value="<?php echo $get->nama; ?>" />
				  </div>
			  </div>
			  <div class="form-group ">
				  <label for="name" class="control-label col-lg-2">Alamat Rumah <span class="required">*</span></label>
				  <div class="col-lg-5">
					  <textarea class="form-control " name="home"><?php echo $get->alamat_rumah; ?></textarea>
				  </div>
			  </div>
			  <div class="form-group ">
				  <label for="name" class="control-label col-lg-2">Alamat Kantor <span class="required">*</span></label>
				  <div class="col-lg-5">
					  <textarea class="form-control " name="office"><?php echo $get->alamat_kantor; ?></textarea>
				  </div>
			  </div>
			  <div class="form-group ">
				  <label for="name" class="control-label col-lg-2">Telepon <span class="required">*</span></label>
				  <div class="col-lg-5">
					  <input class=" form-control" name="phone" type="text" value="<?php echo $get->telp; ?>" />
				  </div>
			  </div>
			</fieldset>
				  <br />
				  <div class="form-group">
					  <div class="col-lg-offset-2 col-lg-10">
						  <input class="btn btn-primary" type="submit" value="Save">
					  </div>
				  </div>
			  </form>
		  </div>
	  </div>
  </section>
</div>
</div>