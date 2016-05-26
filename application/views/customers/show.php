<script>
function confirm() {
    confirm("Apakah anda yakin ?");
}
</script>

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-table"></i> Pelanggan</h3>
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
			<br>
			<div align="right">
			<form class="form-inline" role="form" name='form_search' action="<?php echo base_url(); ?>customer/search" method="post">
			  <div class="form-group">
				  <select class="form-control m-bot15" name='status' onchange="this.form.submit()">
					  <option value=" " <?php echo (!isset($stat) ? 'selected' : '' ); ?>>Status</option>
					  <option value="1" <?php echo (isset($stat) ? ($stat == '1' ? 'selected' : '') : '' ); ?>>Aktif</option>
					  <option value="0" <?php echo (isset($stat) ? ($stat == '0' ? 'selected' : '' ) : '' ); ?>>Non Aktif</option>
				 </select>
			  </div>
			</form>
			</div>
			
			<table id='bootstrap-table' class="table table-bordered table-striped table-advance table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Email</th>
						<th>Alamat Rumah</th>
						<th>Telp</th>
						<th>Status</th>
                        <th><i class="icon_cogs"></i> Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				if(isset($cust) and count($cust) > 0)
				{
					foreach($cust as $data)
					{
						echo '
						<tr class="odd gradeX">
							<td>'.$no.'</td>
							<td>'.$data->nama.'</td>
							<td>'.$data->email.'</td>
							<td>'.$data->alamat_rumah.'</td>
							<td>'.$data->telp.'</td>
							<td>'.status($data->status).'</td>
							<td>
							  <div class="btn-group">
								  <a class="btn btn-success" href="'.base_url().'customer/detail/'.$data->customers_id.'">Detail</a>
								  <a class="btn '.($data->status == 0 ? 'btn-primary' : 'btn-danger').'" href="'.base_url().'customer/'.($data->status == 0 ? 'active' : 'deactive').'/'.$data->customers_id.'">'.($data->status == 0 ? 'Aktifkan' : 'Non Aktifkan').'</a>
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
							<td colspan='8' align='center'><h2>Tidak ada data pelanggan</h2></td>
						</tr>";
				}
				?>
				</tbody>
			</table>
		</section>
	</div>
</div>
<?php
function status($stat)
{
	switch($stat)
	{
		case 0;
		$a = "Non Aktif";
		break;
		
		case 1;
		$a = "Aktif";
		break;
	}
	
	return $a;
}
?>