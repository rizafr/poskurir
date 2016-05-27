
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-table"></i> Tarif </h3>
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
			<!--<a class="btn btn-primary" href="<?php echo base_url("tarif/add_tarif"); ?>"><i class="icon_plus_alt2"></i> Tambah Tarif</a>-->
			<table id='bootstrap-table' class="table table-bordered table-striped table-advance table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Asal</th>
						<th>Tujuan</th>
						<th>Layanan</th>
						<th>Harga</th>
                        <th><i class="icon_cogs"></i> Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				if($tarif->num_rows() > 0)
				{
					foreach($tarif->result() as $data)
					{
						echo '
						<tr class="odd gradeX">
							<td>'.$no.'</td>
							<td>'.$data->asal.'</td>
							<td>'.$data->tujuan.'</td>
							<td>'.$data->layanan.'</td>
							<td>Rp. '.number_format($data->harga,2,",",".").'</td>
							<td>
							  <div class="btn-group">
								  <a class="btn btn-success" href="'.base_url().'tarif/edit/'.$data->tarif_id.'">Ubah</a>';
								  ?>
								  <a class="btn btn-danger" onclick="return konfirmasi('Apakah anda yakin ?');" href="<?php echo base_url().'tarif/delete/'.$data->tarif_id; ?>">Hapus</a>
							  <?php
							  echo '
							  </div>
							</td>
						</tr>';
						
						$no++;
					}
				}
				else
				{
					echo "
						<tr class='odd gradeX'>
							<td colspan='6' align='center'><h2>Customers data isn't required</h2></td>
						</tr>";
				}
				?>
				</tbody>
			</table>
		</section>
	</div>
</div>