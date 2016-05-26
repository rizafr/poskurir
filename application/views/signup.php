<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PT POS INDONESIA">
    <meta name="author" content="SUMAPALA || Temmy Rustandi Hidayat">
    <meta name="keyword" content="POS, PT, Indonesia, Kurir, online, POS Online, Kurir Online">
    <link rel="shortcut icon" href="<?php echo site_url(); ?>img/pic/pos2.png">

    <title>Signup || PT POS INDONESIA</title>

    <!-- Bootstrap CSS -->    
    <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel="stylesheet">
    <!-- bootstrap theme -->
    <link href="<?php echo base_url(); ?>css/bootstrap-theme.css" rel="stylesheet">
    <!--external css-->
    <!-- font icon -->
    <link href="<?php echo base_url(); ?>css/elegant-icons-style.css" rel="stylesheet" />
    <link href="<?php echo base_url(); ?>css/font-awesome.min.css" rel="stylesheet" />    
    <!-- full calendar css-->
    <link href="<?php echo base_url(); ?>assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/fullcalendar/fullcalendar/fullcalendar.css" rel="stylesheet" />
    <!-- easy pie chart-->
    <link href="<?php echo base_url(); ?>assets/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <!-- owl carousel -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/owl.carousel.css" type="text/css">
	<link href="<?php echo base_url(); ?>css/jquery-jvectormap-1.2.2.css" rel="stylesheet">
    <!-- Custom styles -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>css/fullcalendar.css">
	<link href="<?php echo base_url(); ?>css/widgets.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>css/style-responsive.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>css/xcharts.min.css" rel=" stylesheet">	
	<link href="<?php echo base_url(); ?>css/jquery-ui-1.10.4.min.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <script src="js/lte-ie7.js"></script>
    <![endif]-->
  </head>

  <body>
  <!-- container section start -->
  <section id="container" class="">
     
      
      <header class="header dark-bg">
            <!--logo start-->
            <a href="<?php echo base_url(); ?>" class="logo">PT POS INDONESIA</a>
            <!--logo end-->

            <div class="nav search-row" id="top_menu">
                <!--  search form start -->
                <!--<ul class="nav top-menu">                    
                    <li>
                        <form class="navbar-form">
                            <input class="form-control" placeholder="Search" type="text">
                        </form>
                    </li>                    
                </ul>-->
                <!--  search form end -->                
            </div>
      </header>      
      <!--header end-->
      
      <!--main content start-->
      <section id="container">
          <section class="wrapper">            
              <!--overview start-->
			  <div id="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class="fa fa-files-o"></i> Signup</h3>
				</div>
				
                  <div class="col-lg-12">
                      <section class="panel">
                          <header class="panel-heading">
                             Fill this form
                          </header>
                          <div class="panel-body">
                              <div class="form">
                                  <form class="form-validate form-horizontal " id="register_form" method="post" action="<?php echo base_url(); ?>primary/signup_process">
                                      <fieldset>
									  <legend>Login Data</legend>
										  <div class="form-group ">
											  <label for="name" class="control-label col-lg-2">Username <span class="required">*</span></label>
											  <div class="col-lg-5">
												  <input class=" form-control" name="user" type="text" />
											  </div>
										  </div>
										  <div class="form-group ">
											  <label for="name" class="control-label col-lg-2">Password <span class="required">*</span></label>
											  <div class="col-lg-5">
												  <input class=" form-control" id="pass1" name="pass1" type="password" />
											  </div>
										  </div>
										  <div class="form-group ">
											  <label for="name" class="control-label col-lg-2">Confirm Password <span class="required">*</span></label>
											  <div class="col-lg-5">
												  <input class=" form-control" name="pass2" type="password" />
											  </div>
										  </div>
										  <div class="form-group ">
											  <label for="name" class="control-label col-lg-2">Email <span class="required">*</span></label>
											  <div class="col-lg-5">
												  <input class=" form-control" name="email" type="text" />
											  </div>
										  </div>
									  </fieldset>
									  
									  <fieldset>
									  <legend>Personal Data</legend>
										  <div class="form-group ">
											  <label for="name" class="control-label col-lg-2">Name <span class="required">*</span></label>
											  <div class="col-lg-5">
												  <input class=" form-control" name="name" type="text" />
											  </div>
										  </div>
										  <div class="form-group ">
											  <label for="name" class="control-label col-lg-2">Address <span class="required">*</span></label>
											  <div class="col-lg-5">
												  <textarea class="form-control " name="address"></textarea>
											  </div>
										  </div>
										  <div class="form-group ">
											  <label for="name" class="control-label col-lg-2">Phone <span class="required">*</span></label>
											  <div class="col-lg-5">
												  <input class=" form-control" name="phone" type="text" />
											  </div>
										  </div>
									  </fieldset>
									  <br />
                                      <div class="form-group">
                                          <div class="col-lg-offset-2 col-lg-10">
                                              <input class="btn btn-primary" type="submit" value="Save">
                                          </div>
                                      </div>
                                  </form>
                              </div>
                          </div>
                      </section>
                  </div>
				</div>
          </section>
      </section>
      <!--main content end-->
  </section>
  <!-- container section start -->

    <!-- javascripts -->
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    <!-- nice scroll -->
    <script src="<?php echo base_url(); ?>js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery.nicescroll.js" type="text/javascript"></script>
    <!-- jquery validate js -->
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.min.js"></script>

    <!-- custom form validation script for this page-->
    <script src="<?php echo base_url(); ?>js/validation.js"></script>
    <!--custome script for all page-->
    <script src="<?php echo base_url(); ?>js/scripts.js"></script> 

  </body>
</html>
