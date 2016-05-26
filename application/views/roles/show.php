 <div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-table"></i> Role Data</h3>
</div>
<div class="row">
	<div class="col-lg-12">
		<section class="container panel panel-default">
		
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
		
		
		<?php
		echo $this->session->flashdata('user1');
		?>
			<br>
		<a class="btn btn-primary" href="<?php echo base_url("users/add_role"); ?>"><i class="icon_plus_alt2"></i> Tambah Role</a>
			<table id='bootstrap-table' class="table table-bordered table-striped table-advance table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
                        <th><i class="icon_cogs"></i> Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				foreach($roles as $data)
				{
					echo '
					<tr class="odd gradeX">
						<td>'.$no.'</td>
						<td>'.$data->rolename.'</td>
						<td>
						  <div class="btn-group">
							  <a class="btn btn-success" href="'.base_url().'users/edit_role/'.$data->role_id.'">Ubah</a>';
							  //<a class="btn btn-danger" href="'.base_url().'users/delete_role/'.$data->role_id.'">Hapus</a>
						  echo '</div>
						</td>
					</tr>';
					
					$no++;
				}
				?>
				</tbody>
			</table>
		</section>
	</div>
</div>

