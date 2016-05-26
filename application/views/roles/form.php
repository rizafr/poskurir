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
		 <?php echo (isset($edit) ? 'Edit' : 'Add'); ?> Role
	  </header>
	  <div class="panel-body">
		  <div class="form">
			  <form class="form-validate form-horizontal " id="register_form" onsubmit="return yakin();" method="post" action="<?php echo base_url(); ?>users/<?php echo (isset($edit) ? 'update_role' : 'signup_role'); ?>">
					  <?php
							if(isset($edit))
							{
								$get = current($roles);
								
								echo "<input type='hidden' name='id' value='$get->role_id'>";
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
						  <label for="name" class="control-label col-lg-2">Name <span class="required">*</span></label>
						  <div class="col-lg-5">
							  <input class=" form-control" name="name" type="text" value="<?php echo (isset($edit) ? $get->rolename : '') ?>" />
						  </div>
					  </div>
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