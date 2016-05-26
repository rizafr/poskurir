
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-table"></i> Daftar Order</h3>
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
			<div align="right">
			<form class="form-inline" role="form" name='form_search' action="<?php echo base_url(); ?>order/search" method="post">
			  <div class="form-group">
				  <select class="form-control m-bot15" name='status' onchange="this.form.submit()">
					  <option value=" " <?php echo (!isset($stat) ? 'selected' : '' ); ?>>Status</option>
					  <option value="0" <?php echo (isset($stat) ? ($stat == '0' ? 'selected' : '') : '' ); ?>>Request</option>
					  <option value="1" <?php echo (isset($stat) ? ($stat == '1' ? 'selected' : '' ) : '' ); ?>>On Assignment</option>
					  <option value="2" <?php echo (isset($stat) ? ($stat == '2' ? 'selected' : '' ) : '' ); ?>>On Waiting</option>
					  <option value="3" <?php echo (isset($stat) ? ($stat == '3' ? 'selected' : '' ) : '' ); ?>>Pick Up</option>
					  <option value="4" <?php echo (isset($stat) ? ($stat == '4' ? 'selected' : '' ) : '' ); ?>>Delivered</option>
					  <option value="5" <?php echo (isset($stat) ? ($stat == '5' ? 'selected' : '' ) : '' ); ?>>Rejected</option>
					  <option value="6" <?php echo (isset($stat) ? ($stat == '6' ? 'selected' : '' ) : '' ); ?>>Retour</option>
					  <option value="8" <?php echo (isset($stat) ? ($stat == '8' ? 'selected' : '' ) : '' ); ?>>Retour Delivered</option>
					  <option value="7" <?php echo (isset($stat) ? ($stat == '7' ? 'selected' : '' ) : '' ); ?>>Rejected Delivered</option>
					  <!--<option value="9" <?php echo (isset($stat) ? ($stat == '10' ? 'selected' : '' ) : '' ); ?>>Financial Acceptance</option>-->
					  <option value="10" <?php echo (isset($stat) ? ($stat == '10' ? 'selected' : '' ) : '' ); ?>>Completed</option>
				  </select>
			  </div>
			</form>
			</div>
			
			<table id='bootstrap-table' class="table table-bordered table-striped table-advance table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama Pelanggan</th>
						<th>Nama Pengantar</th>
						<th>Detail Barang</th>
						<!--<th>Tanggal Kirim</th>-->
						<th>Jenis Layanan</th>
						<th>Status</th>
                        <th><i class="icon_cogs"></i> Aksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				if($order->num_rows() > 0)
				{
					foreach($order->result() as $data)
					{
						echo '
						<tr class="odd gradeX">
							<td>'.$no.'</td>
							<td>'.$data->nama.'</td>
							<td>'.($data->status_delv_id == '0' ? 'Belum ada pengantar' : ((!empty($data->nama_kurir) or $data->nama_kurir != NULL) ? $data->nama_kurir : 'Belum ada pengantar')).'</td>
							<td>'.$data->detail_barang.'</td>
							';
							//<td>'.tgl($data->tgl_kirim).'</td>
							echo '<td>'.$data->layanan.'</td>
							<td>'.status($data->status_delv_id).'</td>
							<td>
							  <div class="btn-group">
								  <a class="btn btn-default" href="'.base_url().'order/order_detail/'.$data->order_id.'">Detail Order</a>';
								if($data->status_delv_id == 0)
								{
								  echo '<a class="btn '.(($data->courier_id == 0 and $data->status_delv_id == 0) ? 'btn-success' : 'btn-primary').'" href="'.base_url().'order/proses/'.$data->order_id.'">'.(($data->courier_id == 0 and $data->status_delv_id == 0) ? 'Proses' : (($data->status_delv_id == 0 and $data->courier_id != '0') ? 'Ganti Pengantar' : 'Ubah Pengantar')).'</a>';
								}
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
							<td colspan='9' align='center'><h2>Tidak ada data order</h2></td>
						</tr>";
				}
				?>
				</tbody>
			</table>
		</section>
	</div>
</div>

<?php

function status($id)
{
	switch($id)
	{
		case '0';
		$a = 'Request';
		break;
		
		case '1';
		$a = 'On Assignment';
		break;
		
		case '2';
		$a = 'On Waitting';
		break;
		
		case '3';
		$a = 'Pick Up';
		break;
		
		case '4';
		$a = 'Delivered';
		break;
		
		case '5';
		$a = 'Rejected';
		break;
		
		case '6';
		$a = 'Retour';
		break;
		
		case '8';
		$a = 'Retour Delivered';
		break;
		
		case '7';
		$a = 'Rejected Delivered';
		break;
		
		case '9';
		$a = 'Financial Acceptance';
		break;
		
		case '10';
		$a = 'Completed';
		break;
	}
	
	return $a;
}

function tgl($tgl)
{
	$tanggal1 = explode(" ",$tgl);
	$tanggal2 = explode("-",$tanggal1[0]);
	
	switch($tanggal2[1])
	{
		case '01';
		$b = 'Januari';
		break;
		
		case '02';
		$b = 'Februari';
		break;
		
		case '03';
		$b = 'Maret';
		break;
		
		case '04';
		$b = 'April';
		break;
		
		case '05';
		$b = 'Mei';
		break;
		
		case '06';
		$b = 'Juni';
		break;
		
		case '07';
		$b = 'Juli';
		break;
		
		case '08';
		$b = 'Agustus';
		break;
		
		case '09';
		$b = 'September';
		break;
		
		case '10';
		$b = 'Oktober';
		break;
		
		case '11';
		$b = 'November';
		break;
		
		case '12';
		$b = 'Desember';
		break;
	}
	
	$tanggal = $tanggal2[2].' '.$b.' '.$tanggal2[0];
	
	return $tanggal;
}

?>