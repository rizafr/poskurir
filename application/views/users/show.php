 <div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-table"></i> Admin Data</h3>
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

			<br>
		<a class="btn btn-primary" href="<?php echo base_url("users/add_user"); ?>"><i class="icon_plus_alt2"></i> Tambah Admin</a>
			<table id='bootstrap-table' class="table table-bordered table-striped table-advance table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Username</th>
						<th>Email</th>
						<th>Nama</th>
						<th>Admin Role</th>
						<th>Status</th>
                        <th><i class="icon_cogs"></i> Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				foreach($user as $data)
				{
					echo '
					<tr class="odd gradeX">
						<td>'.$no.'</td>
						<td>'.$data->username.'</td>
						<td>'.$data->email.'</td>
						<td>'.$data->name.'</td>
						<td>'.$data->rolename.'</td>
						<td>'.($data->status == 0 ? 'Non Aktif' : 'Aktif').'</td>
						<td>
						  <div class="btn-group">
							  <a class="btn btn-success" href="'.base_url().'users/edit/'.$data->id.'">Ubah</a>
                              ';
                              if($this->session->userdata('id') != $data->id)
                              {
                              echo '
							  <a class="btn '.($data->status == 0 ? 'btn-primary' : 'btn-danger').'" href="'.base_url().'users/'.($data->status == 0 ? 'active' : 'deactive').'/'.$data->id.'">'.($data->status == 0 ? 'Aktifkan' : 'Non Aktif').'</a>';
                                }
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

