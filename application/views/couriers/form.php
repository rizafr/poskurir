<script>
function yakin()
{
	var konfirm = confirm("Apa anda yakin semua isian sudah benar ?");
	
	if(konfirm == false)
	{
		alert("Silahkan periksa kembali");
		return false;
	}
}
</script>
<div class="col-lg-12">
  <section class="panel">
	  <header class="panel-heading">
		 <?php echo (isset($edit) ? 'Sunting' : 'Tambah'); ?> Pengantar
	  </header>
	  <div class="panel-body">
		  <div class="form">
			  <form class="form-validate form-horizontal " id="register_form" onsubmit="return yakin();" method="post" action="<?php echo base_url(); ?>couriers/<?php echo (isset($edit) ? 'update' : 'create'); ?>">
					  <?php
							if(isset($edit))
							{
								$get = current($courier);
								
								echo "<input type='hidden' name='id' value='$get->courier_id'>";
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
									  <button data-dismiss="modal" class="btn <?php echo ($msg['status'] == 0 ? 'btn-danger' : 'btn-primary'); ?>" type="button">Close</button>
								  </div>
							  </div>
						  </div>
						</div>
						<!-- modal -->
						<?php
						}
						?>
					
					  <div class="form-group ">
						  <label for="name" class="control-label col-lg-2">ID Pengantar <span class="required">*</span></label>
						  <div class="col-lg-5">
							  <input class=" form-control" name="nip" type="text" value="<?php echo (isset($edit) ? $get->courier_id : '') ?>" <?php echo (isset($edit) ? 'disabled' : '') ?> />
						  </div>
					  </div>
					  <div class="form-group ">
						  <label for="name" class="control-label col-lg-2">Email/Username <span class="required">*</span></label>
						  <div class="col-lg-5">
							  <input class=" form-control" name="email" type="text" value="<?php echo (isset($edit) ? $get->email : '') ?>" />
						  </div>
					  </div>
					  <div class="form-group ">
						  <label for="name" class="control-label col-lg-2">Password <span class="required">*</span></label>
						  <div class="col-lg-5">
							  <input class=" form-control" id="pass1" name="pass1" type="password" />
						  </div>
					  </div>
					  
					  <div class="form-group ">
						  <label for="name" class="control-label col-lg-2">Konfirmasi Password <span class="required">*</span></label>
						  <div class="col-lg-5">
							  <input class=" form-control" name="pass2" type="password" />
						  </div>
					  </div>
						
					  <div class="form-group ">
						  <label for="name" class="control-label col-lg-2">Nama <span class="required">*</span></label>
						  <div class="col-lg-5">
							  <input class=" form-control" name="name" type="text" value="<?php echo (isset($edit) ? $get->nama : '') ?>" />
						  </div>
					  </div>
					  
					  <div class="form-group ">
						  <label for="name" class="control-label col-lg-2">Alamat <span class="required">*</span></label>
						  <div class="col-lg-5">
							   <textarea class="form-control " name="address"><?php echo (isset($edit) ? $get->alamat : '') ?></textarea>
						  </div>
					  </div>
					  <div class="form-group ">
						  <label for="name" class="control-label col-lg-2">No Telepon <span class="required">*</span></label>
						  <div class="col-lg-5">
							  <input class=" form-control" name="phone" type="text" value="<?php echo (isset($edit) ? $get->no_hp_courier : '') ?>" />
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