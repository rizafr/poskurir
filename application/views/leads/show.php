
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-table"></i> Data User Roles</h3>
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
						<th>Customer Name</th>
						<th>Peerson PickUp</th>
						<th>Person PickUp Address</th>
						<th>Person PickUp Phone</th>
						<th>Person Deliv</th>
						<th>Person Deliv Address</th>
						<th>Person Deliv Phone</th>
                        <th><i class="icon_cogs"></i> Action</th>
					</tr>
				</thead>
				<tbody>
				<?php
				$no = 1;
				if($lead->num_rows() > 0)
				{
					foreach($lead->result() as $data)
					{
						echo '
						<tr class="odd gradeX">
							<td>'.$no.'</td>
							<td>'.$data->cust_name.'</td>
							<td>'.$data->pickup_name.'</td>
							<td>'.$data->almt_pickup.'</td>
							<td>'.$data->phone1.'</td>
							<td>'.$data->name_dlv.'</td>
							<td>'.$data->alamat_dlv.'</td>
							<td>'.$data->phone2.'</td>
							<td>
							  <div class="btn-group">
								  <a class="btn btn-success" href="'.base_url().'customer/edit/'.$data->order_id.'">Edit</a>
								  <a class="btn btn-danger" href="'.base_url().'customer/delete/'.$data->order_id.'">Delete</a>
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
							<td colspan='9' align='center'><h2>Lead Customers data isn't required</h2></td>
						</tr>";
				}
				?>
				</tbody>
			</table>
		</section>
	</div>
</div>