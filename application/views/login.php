<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
    <meta name="author" content="GeeksLabs">
    <meta name="keyword" content="Creative, Dashboard, Admin, Template, Theme, Bootstrap, Responsive, Retina, Minimal">
    <link rel="shortcut icon" href="img/favicon.png">

    <title>Login Pos Kurir | PT POS INDONESIA</title>
	
	<!-- SCRIPT JS -->
	
	<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery-ui-1.9.2.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
	<?php echo (isset($map) ? $map['js'] : ''); ?>
	
	<!-- END -->
	
	<!-- Bootstrap CSS -->    
    <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="<?php echo base_url(); ?>css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="<?php echo base_url(); ?>css/elegant-icons-style.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles -->
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/style-responsive.css" rel="stylesheet" /> 

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
</head>

  <body class="login-img3-body">

    <div class="container">

         <?php
    /*if($this->session->flashdata('alert') == '1')
    {
        echo '
        <div style="padding-top:60px;" id="eror">
            <div class="col-lg-3">
            </div>

            <div class="col-lg-6">
            <div class="alert alert-block alert-danger fade in" style="padding:30px 30px 30px 30px;">
              <button data-dismiss="alert" class="close close-sm" type="button">
                  <i class="icon-remove">x</i>
              </button>
              <strong>Maaf, </strong> username atau password Anda salah.
            </div>
            </div>

            <div class="col-lg-3">
            </div>
        </div>
        ';
    }*/
    ?>
	
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

      <div class="login-panel panel panel-default login-form"> 
        
        <div class="login-wrap">

        <div class="login-img">
            <center><img src="<?php echo base_url(); ?>img/pic/pos-1.png" alt="Pos Kurir" height="100" width="150"></center> 
        </div>
        <br><br>

            <form action="<?php echo base_url(); ?>primary/home" method="post"> 
                  
                    <div class="input-group">
                      <span class="input-group-addon"><i class="icon_profile"></i></span>
                      <input type="text" class="form-control" name="user" placeholder="Username atau Email" autofocus>
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon_key_alt"></i></span>
                        <input type="password" class="form-control" name="pass" placeholder="Password">
                    </div>  


                    <input class="btn btn-lg btn-warning btn-block" type="submit" value="Login" name="admin_login" > 
                    <!--<a href="<?php echo base_url(); ?>primary/signup" class="btn btn-info btn-lg btn-block">Signup</a>-->
                 
            </form>

        </div>
        </div> 
	<div class="footer">
		<div class="container">
			<b class="copyright"><center>Supported By PT. Bhakti Wasantara Net.</center></b>
		</div>
	</div>

    </div>

<!-- javascripts -->
	<script src="<?php echo base_url(); ?>js/jquery-ui-1.9.2.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    <!-- nicescroll -->
    <script src="<?php echo base_url(); ?>js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery.nicescroll.js" type="text/javascript"></script>
    <!--custome script for all page-->
    <script src="<?php echo base_url(); ?>js/scripts.js"></script>
	
	<!-- jquery validate js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.min.js"></script>

    <!-- custom form validation script for this page-->
    <script src="<?php echo base_url(); ?>js/<?php echo (isset($edit) ? 'vendor/' : ''); ?>validation.js"></script>
	
	
	<script src="<?php echo base_url(); ?>js/vendor/jquery.sortelements.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/jquery.bdt.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>js/jquery.simplePagination.js"></script>
    <script src="<?php echo base_url(); ?>js/chosen.jquery.js"></script>
	
	<script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/5.5.3/js/foundation.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery.dateselector.js"></script>
	
	
<script type="text/javascript">
    $(window).load(function(){
        $('#myModal').modal('show');
    });
</script>

  </body>
</html>
