	<link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap-chosen.css" />
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="http://harvesthq.github.io/chosen/chosen.jquery.js"></script>
    <script>
      $(function() {
        $('#chosen-select').chosen();
        $('#chosen-select-deselect').chosen({ allow_single_deselect: true });
      });
    </script>

<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-table"></i> Transaction Customers Data</h3>
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
			  <form class="form-inline" role="form" action="<?php echo base_url(); ?>transaksi/customers" method="post">
				  <div class="form-group">
					  <label class="sr-only" for="exampleInputEmail2">Customers</label>
					  <!--<input type="email" class="form-control" id="demo-input-local" placeholder="Enter Customer">-->
					  <select data-placeholder="Choose Customers" name="cust" class="form-control" id="chosen-select">
							<option value=""></option>
							<?php 
								foreach($cust as $customer)
								{
									echo '<option value="'.$customer->customers_id.'" '.(isset($customers) ? (($customers['cust'] == $customer->customers_id) ? 'selected' : '') : '').'>'.$customer->nama.'</option>';
								}							
							?>
					  </select>
				  </div>
				  
				  <div class="form-group">
					  <label class="sr-only" for="exampleInputPassword2">From</label>
					  <input type="text" class="form-control" id='date1' name="from" placeholder="Enter First Date" value="<?php echo (isset($customers) ? $customers['from'] : ''); ?>">
				  </div>
				  
				  <div class="form-group">
					  <label class="sr-only" for="exampleInputPassword2">Till</label>
					  <input type="text" class="form-control" id='date2' name="till" placeholder="Enter Second Date" value="<?php echo (isset($customers) ? $customers['till'] : ''); ?>">
				  </div>
				  
				  <input type="submit" value="Submit" class="btn btn-primary">
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
							<td>'.$data->cust_name.'</td>
							<td>'.$data->date.'</td>
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