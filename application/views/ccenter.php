<?php
	if($this->session->userdata('username') == FALSE && $this->session->userdata('password') == FALSE)
	{
		redirect("primary/login");
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php echo $map['js']; ?>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PT POS INDONESIA">
    <meta name="author" content="SUMAPALA || Temmy Rustandi Hidayat">
    <meta name="keyword" content="POS, PT, Indonesia, Kurir, online, POS Online, Kurir Online">
    <link rel="shortcut icon" href="<?php echo site_url(); ?>img/pic/pos2.png">

    <title>PT POS INDONESIA</title>

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
            <div class="toggle-nav">
                <div class="icon-reorder tooltips" data-original-title="Toggle Navigation" data-placement="bottom"><i class="icon_menu"></i></div>
            </div>

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

            <div class="top-nav notification-row">                
                <!-- notificatoin dropdown start-->
                <ul class="nav pull-right top-menu">
                    <!-- user login dropdown start-->
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <!--<span class="profile-ava">
                                <img alt="" src="img/avatar1_small.jpg">
                            </span>-->
                            <span class="username"><?php echo $this->session->userdata('name'); ?></span>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu extended logout">
                            <div class="log-arrow-up"></div>
                            <li class="eborder-top">
                                <a href="#"><i class="icon_profile"></i> Settings</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() ?>primary/logout"><i class="icon_key_alt"></i> Log Out</a>
                        </ul>
                    </li>
                    <!-- user login dropdown end -->
                </ul>
                <!-- notificatoin dropdown end-->
            </div>
      </header>      
      <!--header end-->

      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu">                
                  <li class="sub-menu">
                      <a class=""  href="javascript:;" class="">
                          <i class="icon_document_alt"></i>
                          <span>Manajemen User</span>
                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
					  <ul class="sub">
                          <li><a class="" href="#">Users Data</a></li>
                          <li><a class="" href="#">Roles Data</a></li>
                      </ul>
                  </li>                
                  <li>
                      <a class="" href="<?php echo base_url(); ?>">
                          <i class="icon_document_alt"></i>
                          <span>Manajemen Kurir</span>
                      </a>
                  </li>              
                  <li>
                      <a class="" href="<?php echo base_url(); ?>">
                          <i class="icon_documents_alt"></i>
                          <span>Manajemen Transaksi</span>
                      </a>
                  </li>            
                  <li>
                      <a class="" href="<?php echo base_url(); ?>ccnter">
                          <i class="icon_desktop"></i>
                          <span>Command Center</span>
                      </a>
                  </li>
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper">            
              <!--map disini bro-->
              <div class="row">
                    <div class="col-lg-12">
                        <h3 class="page-header"><i class="fa fa-laptop"></i>Command Center</h3>
                    </div>
                    <div class="col-lg-20 col-md-12">
					
					<div class="panel panel-default">
						<div class="panel-heading">
							<h2><i class="fa fa-map-marker red"></i><strong>Lokasi Kurir dan Pelanggan</strong></h2>
							<div class="panel-actions">
								<a href="index.html#" class="btn-setting"><i class="fa fa-rotate-right"></i></a>
								<a href="index.html#" class="btn-minimize"><i class="fa fa-chevron-up"></i></a>
								<a href="index.html#" class="btn-close"><i class="fa fa-times"></i></a>
							</div>
						</div>
						<div class="panel-body-map">
							<?php echo $map['html']; ?>   
						</div>
                        
	
					</div>
				</div>
                </div>
          </section>
      </section>
      <!--main content end-->
  </section>
  <!-- container section start -->

    <!-- javascripts -->
    <script src="<?php echo base_url(); ?>js/jquery.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery-ui-1.10.4.min.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.9.2.custom.min.js"></script>
    <!-- bootstrap -->
    <script src="<?php echo base_url(); ?>js/bootstrap.min.js"></script>
    <!-- nice scroll -->
    <script src="<?php echo base_url(); ?>js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery.nicescroll.js" type="text/javascript"></script>
    <!-- charts scripts -->
    <script src="<?php echo base_url(); ?>assets/jquery-knob/js/jquery.knob.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery.sparkline.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script>
    <script src="<?php echo base_url(); ?>js/owl.carousel.js" ></script>
    <!-- jQuery full calendar -->
    <<script src="<?php echo base_url(); ?>js/fullcalendar.min.js"></script> <!-- Full Google Calendar - Calendar -->
	<script src="<?php echo base_url(); ?>assets/fullcalendar/fullcalendar/fullcalendar.js"></script>
    <!--script for this page only-->
    <script src="<?php echo base_url(); ?>js/calendar-custom.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery.rateit.min.js"></script>
    <!-- custom select -->
    <script src="<?php echo base_url(); ?>js/jquery.customSelect.min.js" ></script>
	<script src="<?php echo base_url(); ?>assets/chart-master/Chart.js"></script>
   
    <!--custome script for all page-->
    <script src="<?php echo base_url(); ?>js/scripts.js"></script>
    <!-- custom script for this page-->
    <script src="<?php echo base_url(); ?>js/sparkline-chart.js"></script>
    <script src="<?php echo base_url(); ?>js/easy-pie-chart.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery-jvectormap-world-mill-en.js"></script>
	<script src="<?php echo base_url(); ?>js/xcharts.min.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery.autosize.min.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery.placeholder.min.js"></script>
	<script src="<?php echo base_url(); ?>js/gdp-data.js"></script>	
	<script src="<?php echo base_url(); ?>js/morris.min.js"></script>
	<script src="<?php echo base_url(); ?>js/sparklines.js"></script>	
	<script src="<?php echo base_url(); ?>js/charts.js"></script>
	<script src="<?php echo base_url(); ?>js/jquery.slimscroll.min.js"></script>
	
	
	<script src="<?php echo base_url(); ?>js/jquery.dataTables.js"></script>
	<script>
		$(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		} );
	</script>
  <script>
      //knob
      $(function() {
        $(".knob").knob({
          'draw' : function () { 
            $(this.i).val(this.cv + '%')
          }
        })
      });

      //carousel
      $(document).ready(function() {
          $("#owl-slider").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });
      
       /* ---------- Map ---------- */
        $(function(){
          $('#map').vectorMap({
            map: '',
            series: {
              regions: [{
                values: gdpData,
                scale: ['#000', '#000'],
                normalizeFunction: 'polynomial'
              }]
            },
            backgroundColor: '#eef3f7',
            onLabelShow: function(e, el, code){
              el.html(el.html()+' (GDP - '+gdpData[code]+')');
            }
          });
        });
  </script>
  <script>
        function initialize(lat, lng) {
        
          var myLatLng = {lat: -6.914744, lng: 107.609000};

          var mapProp = {
            center:new google.maps.LatLng(-6.914744,107.609810),
            zoom:15,
            mapTypeId:google.maps.MapTypeId.ROADMAP
          };
         
          var map=new google.maps.Map(document.getElementById("map"),mapProp);
          
          var marker=new google.maps.Marker({
              position:myLatLng,
              title: 'Customer'
              });
          marker.setMap(map);
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>

  </body>
</html>
