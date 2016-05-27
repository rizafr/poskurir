<?php
if(isset($param)){
	$file = strip_tags($param).".php";
	include $file;
}
else
{
	echo '
		<div class="row">
			<div class="col-lg-12">
				<h3 class="page-header"><i class="fa fa-laptop"></i> Dashboard</h3>
				
				<div class="col-lg-9 col-md-12">	
				<div class="panel panel-default">
					<div class="panel-body">
							Selamat datang '.$this->session->userdata('name').'
					</div>
				</div>
				</div>
			</div>
		</div>
		';
}
?>