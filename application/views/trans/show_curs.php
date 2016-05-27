	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-chosen.css" />
	<link href="<?php echo base_url(); ?>css/date.css" rel="stylesheet">
    <script>
      $(function() {
        $('#chosen-select').chosen();
        $('#chosen-select-deselect').chosen({ allow_single_deselect: true });
      });
    </script>

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-table"></i> Transaksi Order</h3>
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
			  <form class="form-horizontal" role="form" action="<?php echo base_url(); ?>transaksi/couriers" method="post">
				  
				  <!--<div class="form-group">
					  <label class="control-label col-lg-1" for="exampleInputEmail2">Couriers</label>
					  <!--<input type="email" class="form-control" id="demo-input-local" placeholder="Enter Customer">-->
					  <!--<div class="col-lg-4">
						  <select data-placeholder="Choose Courier" name="cust" class="form-control" id="chosen-select">
								<option value="" selected></option>
								<?php 
									foreach($cust as $customer)
									{
										echo '<option value="'.$customer->courier_id.'" '.(isset($customers) ? ($customers['cust'] == $customer->courier_id ? 'selected' : '') : '').'>'.$customer->nama.'</option>';
									}							
								?>
						  </select>
					  </div>
				  </div>-->
				  
				  <div class="form-group">
					  <label class="control-label col-lg-1" for="exampleInputPassword2">Dari</label>
					  <div class="input-group col-lg-5">
						<?php
						if(!empty($customers))
						{
						?>
						  <div class="btn btn-default from"><?php echo tgl($customers['from']); ?></div> *klik jika akan merubah
						  <br><br>
						<?php
						}
						?>
						<div class="<?php echo (!empty($customers) ? 'date1' : ''); ?>">
						  <input class="dateselector-basic form-control" type="text" name='from'>
						</div>
					  </div>
				  </div>
				  
				  <div class="form-group">
					  <label class="control-label col-lg-1" for="exampleInputPassword2">Hingga</label>
					  <div class="col-lg-5">
					  <?php
						if(!empty($customers))
						{
						?>
						<div class="btn btn-default till"><?php echo tgl($customers['till']); ?></div> *klik jika akan merubah
						<br>
						<br>
						<?php
						}
						?>
						<div class="<?php echo (!empty($customers) ? 'date2' : ''); ?>">
						<input class="dateselector-basic form-control" type="text" name='till'>
						</div>
					  </div>
				  </div>
				  
				  <div class="form-group">
					  <label class="control-label col-lg-1" for="exampleInputPassword2"></label>
					  <div class="col-lg-5">
						<input type="submit" value="Submit" class="btn btn-primary">
					  </div>
				  </div>
			  </form>
			
			<br>
			<?php
			if($post == '1')
			{
			?>
			<table id='pagging' class="table table-bordered table-striped table-advance table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Nama</th>
						<th>Jumlah Transaksi</th>
						<th>Total Transaksi</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				$total = 0;
				if($data->num_rows() > 0)
				{
					foreach($data->result() as $data)
					{
						$total = $total + $data->harga;
						echo '
						<tr class="odd gradeX">
							<td>'.$no.'</td>
							<td>'.$data->curs_name.'</td>
							<td>'.$data->transaksi.'</td>
							<td>Rp. '.number_format($data->harga,2,",",".").'</td>
						</tr>';
						
						$no++;
					}
				}
				else
				{
					echo "
						<tr class='odd gradeX'>
							<td colspan='4' align='center'><h2>Tidak ada data transaksi</h2></td>
						</tr>";
				}
				?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="3"><p align="right">Total Seluruh Transaksi</p></th>
						<th>Rp. <?php echo number_format($total,2,",","."); ?></th>
					</tr>
				</tfoot>
			</table>
			<?php
			}
			?>
			<br>
		</section>
	</div>
</div>

<script>
$(document).ready(function(){
	$(".date1").hide();
	$(".date2").hide();
    $(".from").click(function(){
        $(".date1").show();
    });
	
    $(".till").click(function(){
        $(".date2").show();
    });
});
</script>

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

function tgl($tgl)
{
	$tanggal1 = explode(" ",$tgl);
	$tanggal2 = explode("/",$tanggal1[0]);
	
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