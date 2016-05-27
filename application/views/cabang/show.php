
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-table"></i>Grup Kantor</h3>
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
			<form class="form-inline" role="form" name='form_search' action="<?php echo base_url(); ?>cabang/search" method="post">
			  <div class="form-group">
				  <select class="form-control m-bot15" name='status' onchange="this.form.submit()">
					  <option value=" " <?php echo (!isset($stat) ? 'selected' : '' ); ?>>Status</option>
					  <option value="1" <?php echo (isset($stat) ? ($stat == '1' ? 'selected' : '') : '' ); ?>>Aktif</option>
					  <option value="0" <?php echo (isset($stat) ? ($stat == '0' ? 'selected' : '' ) : '' ); ?>>Non Aktif</option>
				 </select>
			  </div>
			</form>
			</div>
			
		<a class="btn btn-primary" href="<?php echo base_url("cabang/add_cabang"); ?>"><i class="icon_plus_alt2"></i> Tambah Data</a>
			<table id='bootstrap-table' class="table table-bordered table-striped table-advance table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Grup</th>
						<th>Kantor</th>
						<th>No. Pendirian</th>
						<th>Alamat</th>
						<th>Kota</th>
						<th>Longitude</th>
						<th>Latitude</th>
                        <th><i class="icon_cogs"></i> Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				if(isset($cabang) and count($cabang) > 0)
				{
					foreach($cabang as $data)
					{
						echo '
						<tr class="odd gradeX">
							<td>'.$no.'</td>
							<td>'.$data->nama_grup.'</td>
							<td>'.$data->kantor.'</td>
							<td>'.$data->no_dirian.'</td>
							<td>'.$data->alamat.'</td>
							<td>'.$data->kota.'</td>
							<td>'.$data->longitude.'</td>
                            <td>'.$data->latitude.'</td>
							<td>
							  <div class="btn-group">
								  <a class="btn btn-success" href="'.base_url().'cabang/edit/'.$data->id_grup.'">Ubah</a>
								  <a class="btn btn-danger"  href="'.base_url().'cabang/delete/'.$data->id_grup.'">Hapus</a>
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
							<td colspan="8" align="center"><h2>Tidak ada data grup kantor</h2></td>
						</tr>';
				}
				?>
				</tbody>
			</table>
		</section>
	</div>
</div>