<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
<link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets'); ?>/img/apple-icon-76x76.png">
<link rel="icon" type="image/png" href="<?php echo base_url('assets'); ?>/img/favicon-96x96.png">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

<title><?php echo APP_NAME ?></title>
<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
<!--     Fonts and icons     -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
<link href="<?php echo base_url('assets'); ?>/use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
<!-- CSS Files -->
<link href="<?php echo base_url('assets'); ?>/css/bootstrap.min.css" rel="stylesheet" />
<link href="<?php echo base_url('assets'); ?>/css/now-ui-dashboard.min.css?v=1.1.0" rel="stylesheet" />

<link href="<?php echo base_url('assets'); ?>/css/custom/custom.css" rel="stylesheet" />

    </head>

    <body class=" sidebar-mini ">
        <input type="hidden" id="baseUrl" name="baseUrl" value="<?php echo base_url(); ?>">

        
        
        <div class="wrapper ">
          
            <div class="sidebar" data-color="orange">
    <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->

    <div class="logo">
        <a href="https://www.decorcenter.pe/" class="simple-text logo-mini">
        <?php echo APP_NAME_ABBREV ?>
        </a>

        <a href="https://www.decorcenter.pe/" class="simple-text logo-normal">
        <?php echo APP_NAME ?>
        </a>
        
        <div class="navbar-minimize">
          <button id="minimizeSidebar" class="btn btn-outline-white btn-icon btn-round">
              <i class="now-ui-icons text_align-center visible-on-sidebar-regular"></i>
              <i class="now-ui-icons design_bullet-list-67 visible-on-sidebar-mini"></i>
          </button>
  	    </div>
        
    </div>

    <div class="sidebar-wrapper" id="sidebar-wrapper">
        
        <div class="user">
            <div class="photo">
                <img src="<?php echo base_url('assets/img/users_img'); ?>/<?php echo $_SESSION['user_img']; ?>" />
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#perfilCollapse" class="collapsed">
                    <span>
                        <?php echo substr(strtoupper($_SESSION['user_name']),0, 12) . (strlen($_SESSION['user_name']) > 12 ? "..." : ""); ?>
                        <b class="caret"></b>
                    </span>
                </a>
                <div class="clearfix"></div>
                <div class="collapse <?php echo ($active == 'profile' ? 'show' : ''); ?>" id="perfilCollapse">
                    <ul class="nav">
                        <li class="<?php echo ($active == 'profile' ? 'active' : ''); ?>">
                            <a href="<?php echo base_url('perfil'); ?>">
                                <span class="sidebar-mini-icon">MP</span>
                                <span class="sidebar-normal">Mi Perfil</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('signout'); ?>">
                                <span class="sidebar-mini-icon">CS</span>
                                <span class="sidebar-normal">Cerrar Sesión</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <ul class="nav">
             
              <li  class="<?php echo ($active == 'home' ? 'active' : ''); ?>" >

                  
                    <a href="<?php echo base_url('dashboard'); ?>">
                      
                        <i class="now-ui-icons design_app"></i>
                      
                      <p>Dashboard</p>
                    </a>
                  
              </li>
              <?php if($this->acl->control_acceso('mudule_access_users') || $this->acl->control_acceso('mudule_access_roles') || $this->acl->control_acceso('mudule_access_permissions')){ ?>
                <li >

                    <a data-toggle="collapse" href="#seguridad" >
                      
                        <i class="now-ui-icons objects_key-25"></i>
                      
                        <p>
                          Seguridad <b class="caret"></b>
                        </p>
                    </a>

                    <div class="collapse <?php echo ($active == 'users' || $active == 'roles' || $active == 'permissions' ? 'show' : ''); ?>" id="seguridad">
                        <ul class="nav">
                        <?php if($this->acl->control_acceso('mudule_access_users')){ ?>
                          <li class="<?php echo ($active == 'users' ? 'active' : ''); ?>">
                              <a href="<?php echo base_url('listar-usuarios'); ?>">
                                  <span class="sidebar-mini-icon">U</span>
                                  <span class="sidebar-normal"> Módulo de Usuarios </span>
                              </a>
                          </li>
                          <?php } ?>
                          <?php if($this->acl->control_acceso('mudule_access_roles')){ ?>
                          <li class="<?php echo ($active == 'roles' ? 'active' : ''); ?>">
                              <a href="<?php echo base_url('listar-roles'); ?>">
                                  <span class="sidebar-mini-icon">R</span>
                                  <span class="sidebar-normal"> Módulo de Roles </span>
                              </a>
                          </li>
                          <?php } ?>
                          <?php if($this->acl->control_acceso('mudule_access_permissions')){ ?>
                          <li class="<?php echo ($active == 'permissions' ? 'active' : ''); ?>">
                              <a href="<?php echo base_url('listar-permiso'); ?>">
                                  <span class="sidebar-mini-icon">P</span>
                                  <span class="sidebar-normal"> Módulo de Permiso </span>
                              </a>
                          </li>
                          <?php } ?>
                          
                        
                      </ul>
                  </div>

                  
              </li>
              <?php } ?>
              
              
            
          
        </ul>
    </div>
</div>


            <div class="main-panel" id="main-panel">
              <!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
	<div class="container-fluid">
    <div class="navbar-wrapper">
      
			<div class="navbar-toggle">
				<button type="button" class="navbar-toggler">
					<span class="navbar-toggler-bar bar1"></span>
					<span class="navbar-toggler-bar bar2"></span>
					<span class="navbar-toggler-bar bar3"></span>
				</button>
			</div>
      
			<a class="navbar-brand" href="#pablo"><?php echo $header_title; ?></a>
		</div>

		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-bar navbar-kebab"></span>
			<span class="navbar-toggler-bar navbar-kebab"></span>
			<span class="navbar-toggler-bar navbar-kebab"></span>
		</button>

	    <div class="collapse navbar-collapse justify-content-end" id="navigation">
      
        
          <form>
    <div class="input-group no-border">
        <input type="text" value="" class="form-control" placeholder="Search...">
        <div class="input-group-append">
         <div class="input-group-text">
           <i class="now-ui-icons ui-1_zoom-bold"></i>
         </div>
       </div>
    </div>
</form>

<ul class="navbar-nav">
  <li class="nav-item">
    <a class="nav-link" href="#pablo">
      <i class="now-ui-icons media-2_sound-wave"></i>
      <p>
        <span class="d-lg-none d-md-block">Stats</span>
      </p>
    </a>
  </li>
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <i class="now-ui-icons location_world"></i>
      <p>
        <span class="d-lg-none d-md-block">Some Actions</span>
      </p>
    </a>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
      <a class="dropdown-item" href="#">Action</a>
      <a class="dropdown-item" href="#">Another action</a>
      <a class="dropdown-item" href="#">Something else here</a>
    </div>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="#pablo">
      <i class="now-ui-icons users_single-02"></i>
      <p>
        <span class="d-lg-none d-md-block">Account</span>
      </p>
    </a>
  </li>
</ul>

        
      

      
	    </div>
	</div>
</nav>
<!-- End Navbar -->


              

                  <div class="panel-header panel-header-sm">
  

  
  
</div>


                  <div class="content">
                  <?php echo $this->load->view($dash_container); ?>

                  </div>

                  <footer class="footer" >
    
    <div class="container-fluid">
        <nav>
            <ul>
                <li>
                    <a href="https://www.creative-tim.com/">
                        Creative Tim
                    </a>
                </li>
                <li>
                    <a href="http://presentation.creative-tim.com/">
                       About Us
                    </a>
                </li>
                <li>
                    <a href="http://blog.creative-tim.com/">
                       Blog
                    </a>
                </li>
            </ul>
        </nav>
        <div class="copyright" id="copyright">
        &copy; <script>document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))</script>, Todos los derechos reservados a <a href="https://www.decorcenter.pe/" target="_blank">Decor Center</a>.
        </div>
    </div>
    


</footer>

               
             </div>
          
        </div>
        
            
</div>

        
        















<!--   Core JS Files   -->
<script src="<?php echo base_url('assets'); ?>/js/core/jquery.min.js" ></script>
<script src="<?php echo base_url('assets'); ?>/js/core/popper.min.js" ></script>


<script src="<?php echo base_url('assets'); ?>/js/core/bootstrap.min.js" ></script>


<script src="<?php echo base_url('assets'); ?>/js/plugins/perfect-scrollbar.jquery.min.js" ></script>

<script src="<?php echo base_url('assets'); ?>/js/plugins/moment.min.js"></script>



<!--  Plugin for Switches, full documentation here: http://www.jque.re/plugins/version3/bootstrap.switch/ -->
<script src="<?php echo base_url('assets'); ?>/js/plugins/bootstrap-switch.js"></script>

<!--  Plugin for Sweet Alert -->
<script src="<?php echo base_url('assets'); ?>/js/plugins/sweetalert2.min.js"></script>

<!-- Forms Validations Plugin -->
<script src="<?php echo base_url('assets'); ?>/js/plugins/jquery.validate.min.js"></script>

<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="<?php echo base_url('assets'); ?>/js/plugins/jquery.bootstrap-wizard.js"></script>

<!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="<?php echo base_url('assets'); ?>/js/plugins/bootstrap-selectpicker.js" ></script>

<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="<?php echo base_url('assets'); ?>/js/plugins/bootstrap-datetimepicker.js"></script>

<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->
<script src="<?php echo base_url('assets'); ?>/js/plugins/jquery.dataTables.min.js"></script>

<!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="<?php echo base_url('assets'); ?>/js/plugins/bootstrap-tagsinput.js"></script>

<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?php echo base_url('assets'); ?>/js/plugins/jasny-bootstrap.min.js"></script>

<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<script src="<?php echo base_url('assets'); ?>/js/plugins/fullcalendar.min.js"></script>

<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<script src="<?php echo base_url('assets'); ?>/js/plugins/jquery-jvectormap.js"></script>

<!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
<script src="<?php echo base_url('assets'); ?>/js/plugins/nouislider.min.js" ></script>


<!--  Google Maps Plugin    -->



<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="<?php echo base_url('assets'); ?>/buttons.github.io/buttons.js"></script>


<!-- Chart JS -->
<script src="<?php echo base_url('assets'); ?>/js/plugins/chartjs.min.js"></script>

<!--  Notifications Plugin    -->
<script src="<?php echo base_url('assets'); ?>/js/plugins/bootstrap-notify.js"></script>




<script src="<?php echo base_url('assets'); ?>/js/now-ui-dashboard.min.js?v1.0.0"></script>
<script src="<?php echo base_url('assets'); ?>/js/custom/app.js?v1.0.0"></script>



  <!-- Sharrre libray -->
  <script src="<?php echo base_url('assets'); ?>/js/core/jquery.sharrre.js"></script>


  <script>
  $(document).ready(function(){
    $().ready(function(){
        $sidebar = $('.sidebar');
        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');
        sidebar_mini_active = true;

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

        // if( window_width > 767 && fixed_plugin_open == 'Dashboard' ){
        //     if($('.fixed-plugin .dropdown').hasClass('show-dropdown')){
        //         $('.fixed-plugin .dropdown').addClass('show');
        //     }
        //
        // }

        $('.fixed-plugin a').click(function(event){
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
            if($(this).hasClass('switch-trigger')){
                if(event.stopPropagation){
                    event.stopPropagation();
                }
                else if(window.event){
                   window.event.cancelBubble = true;
                }
            }
        });

        $('.fixed-plugin .background-color span').click(function(){
            $(this).siblings().removeClass('active');
            $(this).addClass('active');

            var new_color = $(this).data('color');

            if($sidebar.length != 0){
                $sidebar.attr('data-color',new_color);
            }

            if($full_page.length != 0){
                $full_page.attr('filter-color',new_color);
            }

            if($sidebar_responsive.length != 0){
                $sidebar_responsive.attr('data-color',new_color);
            }
        });

        $('.fixed-plugin .img-holder').click(function(){
            $full_page_background = $('.full-page-background');

            $(this).parent('li').siblings().removeClass('active');
            $(this).parent('li').addClass('active');


            var new_image = $(this).find("img").attr('src');

            if( $sidebar_img_container.length !=0 && $('.switch-sidebar-image input:checked').length != 0 ){
                $sidebar_img_container.fadeOut('fast', function(){
                   $sidebar_img_container.css('background-image','url("' + new_image + '")');
                   $sidebar_img_container.fadeIn('fast');
                });
            }

            if($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0 ) {
                var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                $full_page_background.fadeOut('fast', function(){
                   $full_page_background.css('background-image','url("' + new_image_full_page + '")');
                   $full_page_background.fadeIn('fast');
                });
            }

            if( $('.switch-sidebar-image input:checked').length == 0 ){
                var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
                var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

                $sidebar_img_container.css('background-image','url("' + new_image + '")');
                $full_page_background.css('background-image','url("' + new_image_full_page + '")');
            }

            if($sidebar_responsive.length != 0){
                $sidebar_responsive.css('background-image','url("' + new_image + '")');
            }
        });

        $('.switch-sidebar-image input').on("switchChange.bootstrapSwitch", function(){
            $full_page_background = $('.full-page-background');

            $input = $(this);

            if($input.is(':checked')){
                if($sidebar_img_container.length != 0){
                    $sidebar_img_container.fadeIn('fast');
                    $sidebar.attr('data-image','#');
                }

                if($full_page_background.length != 0){
                    $full_page_background.fadeIn('fast');
                    $full_page.attr('data-image','#');
                }

                background_image = true;
            } else {
                if($sidebar_img_container.length != 0){
                    $sidebar.removeAttr('data-image');
                    $sidebar_img_container.fadeOut('fast');
                }

                if($full_page_background.length != 0){
                    $full_page.removeAttr('data-image','#');
                    $full_page_background.fadeOut('fast');
                }

                background_image = false;
            }
        });

        $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function(){
          var $btn = $(this);

          if(sidebar_mini_active == true){
              $('body').removeClass('sidebar-mini');
              sidebar_mini_active = false;
              nowuiDashboard.showSidebarMessage('Sidebar mini deactivated...');
          }else{
              $('body').addClass('sidebar-mini');
              sidebar_mini_active = true;
              nowuiDashboard.showSidebarMessage('Sidebar mini activated...');
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function(){
              window.dispatchEvent(new Event('resize'));
          },180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function(){
              clearInterval(simulateWindowResize);
          },1000);
        });
    });
  });
</script>
<?php echo $footer_scripts; ?>
<?php if ($this->session->flashdata('message_error')) { ?>
    <script>
        App.showNotification("<?php echo $this->session->flashdata('message_error'); ?>");
    </script>
<?php 
    $this->session->unset_userdata('message_error');
    } 
?>
<?php if ($this->session->flashdata('message_success')) { ?>
    <script>
        App.showNotification("<?php echo $this->session->flashdata('message_success'); ?>");
    </script>
<?php 
    $this->session->unset_userdata('message_success', 'top', 'center', 'success');
    } 
?>
    </body>


</html>
