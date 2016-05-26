
<div class="row">
	<div class="col-lg-12">
		<!--<h3 class="page-header"><i class="fa fa-table"></i> Data Logs Customers</h3>-->
        <h3 class="page-header"><i class="fa fa-table"></i> Data Historis Order Berdasarkan Pelanggan</h3>
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
			<table id='bootstrap-table' class="table table-bordered table-striped table-advance table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Order ID</th>
						<th>Nama Pelanggan</th>
						<th>Email Pelanggan</th>
						<th>Detail Barang</th>
						<th>Tanggal Kirim</th>
                        <th><i class="icon_cogs"></i> Status / Detail</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				if($cust != 0)
				{
					foreach($cust as $key => $data)
					{
						echo '
						<tr class="odd gradeX">
							<td>'.$no.'</td>
							<td>'.$data->order_id.'</td>
							<td>'.$data->nama.'</td>
							<td>'.$data->email.'</td>
							<td>'.$data->detail_barang.'</td>
							<td>'.tgl($data->timestamp).'</td>
							<td>
							  <div class="btn-group">
								  <a class="btn btn-primary" href="'.base_url().'order/logs_detail_cust/'.$order[$key]->order_id.'">'.status($data->status_delv_id).'</a>
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
							<td colspan='7' align='center'><h2>Customers data isn't required</h2></td>
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