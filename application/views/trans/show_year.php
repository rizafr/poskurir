	<script>
      $(function() {
        $('#chosen-select').chosen();
        $('#chosen-select-deselect').chosen({ allow_single_deselect: true });
      });
    </script>

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-table"></i> Transaction Per Month</h3>
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
			  <form class="form-horizontal" role="form" action="<?php echo base_url(); ?>transaksi/year" method="post">
				  <div class="form-group">
					  <label class="control-label col-lg-2" for="exampleInputPassword2">Choose Year</label>
					  <div class="input-group col-lg-6">
						<?php
						if(!empty($from))
						{
						?>
						  <div class="btn btn-default from"><?php echo $from; ?></div> *klik jika akan merubah
						  <br><br>
						<?php
						}
						?>
						<div class="<?php echo (!empty($from) ? 'date1' : ''); ?>">
						
						<div class="col-lg-3">
						<select name='year' class="form-control m-bot15">
						<?php
							for($x=2015;$x<=date("Y");$x++)
							{
								echo "<option value='$x' ".($x == date("Y") ? 'selected' : '').">".$x."</option>";
							}
						?>
						</select>
						</div>
						  
						  
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
			<table id='pagging' class="table table-bordered table-striped table-advance table-hover">
				<thead>
					<tr>
						<th>No</th>
						<th>Name</th>
						<th>Transaction's Date</th>
						<th>Transaction</th>
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
							<td>'.tanggal($data->date).'</td>
							<td>Rp. '.number_format($data->harga,2,",",".").'</td>
						</tr>';
						
						$no++;
					}
				}
				else
				{
					echo "
						<tr class='odd gradeX'>
							<td colspan='4' align='center'><h2>Transaction data isn't required</h2></td>
						</tr>";
				}
				?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="3"><p align="right">Total All Transaction</p></th>
						<th>Rp. <?php echo number_format($total,2,",","."); ?></th>
					</tr>
				</tfoot>
			</table>
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

function bulan($bln)
{
	
	switch($bln)
	{
		case '1';
		$b = 'Januari';
		break;
		
		case '2';
		$b = 'Februari';
		break;
		
		case '3';
		$b = 'Maret';
		break;
		
		case '4';
		$b = 'April';
		break;
		
		case '5';
		$b = 'Mei';
		break;
		
		case '6';
		$b = 'juni';
		break;
		
		case '7';
		$b = 'Juli';
		break;
		
		case '8';
		$b = 'Agustus';
		break;
		
		case '9';
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
	
	return $b;
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
		$b = 'juni';
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