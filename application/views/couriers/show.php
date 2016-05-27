
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-table"></i> Pengantar</h3>
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
					  <button data-dismiss="modal" class="btn <?php echo ($msg['status'] == 0 ? 'btn-danger' : 'btn-primary'); ?>" type="button">Close</button>
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
			
			<div align="right">
			<form class="form-inline" role="form" name='form_search' action="<?php echo base_url(); ?>couriers/search" method="post">
			  <div class="form-group">
				  <select class="form-control m-bot15" name='status' onchange="this.form.submit()">
					  <option value=" " <?php echo (!isset($stat) ? 'selected' : '' ); ?>>Status</option>
					  <option value="1" <?php echo (isset($stat) ? ($stat == '1' ? 'selected' : '') : '' ); ?>>Aktif</option>
					  <option value="0" <?php echo (isset($stat) ? ($stat == '0' ? 'selected' : '' ) : '' ); ?>>Non Aktif</option>
				 </select>
			  </div>
			</form>
			</div>
			
		<a class="btn btn-primary" href="<?php echo base_url("couriers/add_courier"); ?>"><i class="icon_plus_alt2"></i> Tambah Pengantar</a>
			<table id='bootstrap-table' class="table table-bordered table-striped table-advance table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>ID Pengantar</th>
						<th>Nama</th>
						<th>Alamat</th>
						<th>Telp</th>
						<th>Email</th>
						<th>Status</th>
                        <th><i class="icon_cogs"></i> Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				if(isset($couriers) and count($couriers) > 0)
				{
					foreach($couriers as $data)
					{
						echo '
						<tr class="odd gradeX">
							<td>'.$no.'</td>
							<td>'.$data->courier_id.'</td>
							<td>'.$data->nama.'</td>
							<td>'.$data->alamat.'</td>
							<td>'.$data->no_telpon.'</td>
							<td>'.$data->email.'</td>
                            <td>'.(($data->login_state == 0) ? 'Non Aktif' : 'Aktif').'</td>
							<td>
							  <div class="btn-group">
								  <a class="btn btn-success" href="'.base_url().'couriers/edit/'.$data->courier_id.'">Ubah</a>
								  <a class="btn '.($data->login_state == 0 ? 'btn-primary' : 'btn-danger').'" href="'.base_url().'couriers/'.($data->login_state == 0 ? 'active' : 'deactive').'/'.$data->courier_id.'">'.($data->login_state == 0 ? 'Aktifkan' : 'Non Aktifkan').'</a>
							  </div>
							</td>
						</tr>';
						
						$no++;
					}
				}
				else
				{
					echo '
						<tr class="odd gradeX">
							<td colspan="8" align="center"><h2>Tidak ada data pengantar</h2></td>
						</tr>';
				}
				?>
				</tbody>
			</table>
		</section>
	</div>
</div>