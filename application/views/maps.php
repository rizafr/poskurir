<script>
var a = 60000;
var b = 5;
var time = a * b;

$(document).ready(function() {
    setInterval(function(){ loadDoc() }, time);
});

function loadDoc() {
    location.reload();
}
</script>
              <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"><i class="fa fa-laptop"></i>Command Center</h3>
                    </div>
                    <div class="col-lg-20 col-md-12">
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2><i class="fa fa-map-marker red"></i><strong>Lokasi Kurir dan Pelanggan</strong></h2>
						</div>
						<div class="panel-body-map">
							<?php echo $map['html']; ?>   
						</div>
                        
	
					</div>
				</div>
                </div>