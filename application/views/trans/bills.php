

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-table"></i><?php echo ($kurir != 0 ? 'Tagihan Kurir '.$curs->nama : 'Tagihan Kosong'); ?></h3>
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
			<form role="form" name="form1" action="<?php echo base_url(); ?>transaksi/process" onsubmit="return konfirmasi('Apakah anda yakin ?');" method="post">
            <input type='hidden' value='<?php echo $nip; ?>' name='nip'>
			<table class="table table-bordered table-striped table-advance table-hover">
				<thead>
					<tr>
						<th><input type="checkbox" class="check" id="checkAll" value="0"></th>
						<th>Order Id</th>
						<th>Nama Pelanggan</th>
						<th>Layanan</th>
						<th>Tanggal</th>
						<th>Tagihan</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$harga = 0;
				if($bills != 0)
				{
					foreach($bills as $key => $data)
					{
						$harga = $harga + $data->harga;
						echo '
						<tr class="odd gradeX">
							<input type="hidden" name="tarif['.$kurir[$key]->order_id.']" value="'.$kurir[$key]->tarif_id.'">
							<td><input type="checkbox" class="check" name="order['.$kurir[$key]->order_id.']" value="'.$kurir[$key]->harga.'"></td>
							<td>'.$data->order_id.'</td>
							<td>'.$data->cust_name.'</td>
							<td>'.$data->layanan.'</td>
							<td>'.tanggal($data->date).'</td>
							<td>Rp. '.number_format($data->harga,2,",",".").'</td>
						</tr>';
					}
				}
				else
				{
					echo "
						<tr class='odd gradeX'>
							<td colspan='6' align='center'><h2>Tidak ada tagihan</h2></td>
						</tr>";
				}
				?>
				
				</tbody>
				
				<tfoot>
					
				<tr class='odd gradeX'>
							<td colspan='5' align='center'><h2>Total</h2></td>
							<td>Rp. <?php echo number_format($harga,2,",","."); ?></td>
				</tr>
				
				</tfoot>
			</table>
			<br>
			<div class="form-group">
			<label class="control-label col-lg-3" for="exampleInputEmail2"><b>Total Bayar</b></label>
			<div class="col-lg-4">
			<input class="form-control" name="total" disabled />
			</div>
			<br>
			</div>
			<div class="form-group">
			<label></label>
			<input type="submit" value="Terima" class="btn btn-success terima" name="terima">
			</div>
			<br><br>
			</form>
			
			<a href="<?php echo base_url(); ?>transaksi/bills" class="btn btn-primary">Kembali</a>
			<br><br>
			
		</section>
	</div>
</div>

<?php
function tanggal($tgl)
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