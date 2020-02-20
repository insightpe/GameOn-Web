<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge;" />
        <title>PLANTILLA WEB</title>

        <meta name="description" content="AppUI is a Web App Bootstrap Admin Template created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="<?php echo base_url('assets'); ?>/img/favicon.png">
        <link rel="apple-touch-icon" href="<?php echo base_url('assets'); ?>/img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="<?php echo base_url('assets'); ?>/img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="<?php echo base_url('assets'); ?>/img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="<?php echo base_url('assets'); ?>/img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="<?php echo base_url('assets'); ?>/img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="<?php echo base_url('assets'); ?>/img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="<?php echo base_url('assets'); ?>/img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="<?php echo base_url('assets'); ?>/img/icon180.png" sizes="180x180">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/bootstrap.min.css">

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/plugins.css">
        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/pdf/viewer.css">
        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/main.css">

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->

        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/themes.css">
        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/custom.css">
        <link rel="resource" type="application/l10n" href="<?php echo base_url('assets'); ?>/js/media/pdf/locale/locale.properties">
        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) -->
        <script src="<?php echo base_url('assets'); ?>/js/vendor/modernizr-3.3.1.min.js"></script>
    </head>
    <body>
        <input type="hidden" id="baseUrl" name="baseUrl" value="<?php echo base_url(); ?>">
        <!-- Page Wrapper -->
        <!-- In the PHP version you can set the following options from inc/config file -->
        <!--
            Available classes:

            'page-loading'      enables page preloader
        -->
        <div id="page-wrapper" class="page-loading">
            <!-- Preloader -->
            <!-- Preloader functionality (initialized in js/app.js) - pageLoading() -->
            <!-- Used only if page preloader enabled from inc/config (PHP version) or the class 'page-loading' is added in #page-wrapper element (HTML version) -->
            <div class="preloader">
                <div class="inner">
                    <!-- Animation spinner for all modern browsers -->
                    <div class="preloader-spinner hidden-lt-ie10"></div>

                    <!-- Text for IE9 -->
                    <h3 class="text-primary visible-lt-ie10"><strong>Cargando..</strong></h3>
                </div>
            </div>
            <!-- END Preloader -->

            <!-- Page Container -->
            <!-- In the PHP version you can set the following options from inc/config file -->
            <!--
                Available #page-container classes:

                'sidebar-light'                                 for a light main sidebar (You can add it along with any other class)

                'sidebar-visible-lg-mini'                       main sidebar condensed - Mini Navigation (> 991px)
                'sidebar-visible-lg-full'                       main sidebar full - Full Navigation (> 991px)

                'sidebar-alt-visible-lg'                        alternative sidebar visible by default (> 991px) (You can add it along with any other class)

                'header-fixed-top'                              has to be added only if the class 'navbar-fixed-top' was added on header.navbar
                'header-fixed-bottom'                           has to be added only if the class 'navbar-fixed-bottom' was added on header.navbar

                'fixed-width'                                   for a fixed width layout (can only be used with a static header/main sidebar layout)

                'enable-cookies'                                enables cookies for remembering active color theme when changed from the sidebar links (You can add it along with any other class)
            -->
            <div id="page-container" class="header-fixed-top sidebar-visible-lg-full">
                <!-- Alternative Sidebar -->
                
                <!-- END Alternative Sidebar -->

                <!-- Main Sidebar -->
                <div id="sidebar">
                    <!-- Sidebar Brand -->
                    <div id="sidebar-brand" class="themed-background">
                        <a href="index.html" class="sidebar-title">
                            <i class="fa fa-cube"></i> <span class="sidebar-nav-mini-hide"> <strong>PLANTILLA WEB</strong></span>
                        </a>
                    </div>
                    <!-- END Sidebar Brand -->

                    <!-- Wrapper for scrolling functionality -->
                    <div id="sidebar-scroll">
                        <!-- Sidebar Content -->
                        <div class="sidebar-content">
                            <!-- Sidebar Navigation -->
                            <ul class="sidebar-nav">
                                <li>
                                    <a href="<?php echo base_url('dashboard'); ?>" class=" active"><i class="gi gi-compass sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Tablero de Control</span></a>
                                </li>
                                <li class="sidebar-separator">
                                    <i class="fa fa-ellipsis-h"></i>
                                </li>
                                <?php if($this->acl->control_acceso('mudule_access_users') || $this->acl->control_acceso('mudule_access_roles') || $this->acl->control_acceso('mudule_access_permissions')){ ?>
                                <li class="<?php echo ($active == 'users' || $active == 'roles' || $active == 'permissions' ? 'active' : ''); ?>">
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-lock sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Seguridad</span></a>
                                    <ul>
                                        <?php if($this->acl->control_acceso('mudule_access_users')){ ?>
                                        <li class="<?php echo ($active == 'users' ? 'active' : ''); ?>">
                                            <a href="#" class="sidebar-nav-submenu"><i class="fa fa-chevron-left sidebar-nav-indicator"></i>Módulo de Usuarios</a>
                                            <ul>
                                                <?php if($this->acl->control_acceso('list_users')){ ?>
                                                <li>
                                                    <a href="<?php echo base_url('listar-usuarios'); ?>">Ver Usuarios</a>
                                                </li>
                                                <?php } ?>
                                                <?php if($this->acl->control_acceso('form_new_user')){ ?>
                                                <li>
                                                    <a href="<?php echo base_url('nuevo-usuario'); ?>">Crear Usuario</a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                        <?php } ?>
                                        <?php if($this->acl->control_acceso('mudule_access_roles')){ ?>
                                        <li class="<?php echo ($active == 'roles' ? 'active' : ''); ?>">
                                            <a href="#" class="sidebar-nav-submenu "><i class="fa fa-chevron-left sidebar-nav-indicator"></i>Módulo de Roles</a>
                                            <ul>
                                                <?php if($this->acl->control_acceso('list_roles')){ ?>
                                                <li>
                                                    <a href="<?php echo base_url('listar-roles'); ?>">Ver Roles</a>
                                                </li>
                                                <?php } ?>
                                                <?php if($this->acl->control_acceso('form_new_role')){ ?>
                                                <li>
                                                    <a href="<?php echo base_url('nuevo-rol'); ?>">Crear Rol</a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                        <?php } ?>
                                        <?php if($this->acl->control_acceso('mudule_access_permissions')){ ?>
                                        <li clasS="<?php echo ($active == 'permissions' ? 'active' : ''); ?>">
                                            <a href="#" class="sidebar-nav-submenu "><i class="fa fa-chevron-left sidebar-nav-indicator"></i>Módulo de Permisos</a>
                                            <ul>
                                                <?php if($this->acl->control_acceso('list_permissions')){ ?>
                                                <li>
                                                    <a href="<?php echo base_url('listar-permiso'); ?>">Ver Permisos</a>
                                                </li>
                                                <?php } ?>
                                                <?php if($this->acl->control_acceso('form_new_permissions')){ ?>
                                                <li>
                                                    <a href="<?php echo base_url('nuevo-permiso'); ?>">Crear Permiso</a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <?php } ?>
                                <?php if($this->acl->control_acceso('mudule_access_configuraciones')){ ?>
                                <li class="<?php echo ($active == 'configuraciones' ? 'active' : ''); ?>">
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-cogs sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Configuración</span></a>
                                    <ul>
                                        <?php if($this->acl->control_acceso('mudule_access_configuraciones')){ ?>
                                        <li class="<?php echo ($active == 'configuraciones' ? 'active' : ''); ?>">
                                            <a href="#" class="sidebar-nav-submenu "><i class="fa fa-chevron-left sidebar-nav-indicator"></i>Configuraciones</a>
                                            <ul>
                                                <?php if($this->acl->control_acceso('list_permissions')){ ?>
                                                <li>
                                                    <a href="<?php echo base_url('editar-configuraciones');?>">Editar Configuraciones</a>
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <?php } ?>
                            </ul>
                            <!-- END Sidebar Navigation -->

                            <!-- Color Themes -->
                            <!-- Preview a theme on a page functionality can be found in js/app.js - colorThemePreview() -->
                            
                            <!-- END Color Themes -->
                        </div>
                        <!-- END Sidebar Content -->
                    </div>
                    <!-- END Wrapper for scrolling functionality -->

                    <!-- Sidebar Extra Info 
                    <div id="sidebar-extra-info" class="sidebar-content sidebar-nav-mini-hide">
                        <div class="push-bit">
                            <span class="pull-right">
                                <a href="javascript:void(0)" class="text-muted"><i class="fa fa-plus"></i></a>
                            </span>
                            <small><strong>78 GB</strong> / 100 GB</small>
                        </div>
                        <div class="progress progress-mini push-bit">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100" style="width: 78%"></div>
                        </div>
                        <div class="text-center">
                            <small>Crafted with <i class="fa fa-heart text-danger"></i> by <a href="http://goo.gl/vNS3I" target="_blank">pixelcave</a></small><br>
                            <small><span id="year-copy"></span> &copy; <a href="http://goo.gl/RcsdAh" target="_blank">AppUI 2.7</a></small>
                        </div>
                    </div>
                    END Sidebar Extra Info -->
                </div>
                <!-- END Main Sidebar -->

                <!-- Main Container -->
                <div id="main-container">
                    <!-- Header -->
                    <!-- In the PHP version you can set the following options from inc/config file -->
                    <!--
                        Available header.navbar classes:

                        'navbar-default'            for the default light header
                        'navbar-inverse'            for an alternative dark header

                        'navbar-fixed-top'          for a top fixed header (fixed main sidebar with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar())
                            'header-fixed-top'      has to be added on #page-container only if the class 'navbar-fixed-top' was added

                        'navbar-fixed-bottom'       for a bottom fixed header (fixed main sidebar with scroll will be auto initialized, functionality can be found in js/app.js - handleSidebar()))
                            'header-fixed-bottom'   has to be added on #page-container only if the class 'navbar-fixed-bottom' was added
                    -->
                    <header class="navbar navbar-fixed-top navbar-inverse">
                        <!-- Left Header Navigation -->
                        <ul class="nav navbar-nav-custom">
                            <!-- Main Sidebar Toggle Button -->
                            <li>
                                <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                                    <i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
                                    <i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>
                                </a>
                            </li>
                            <!-- END Main Sidebar Toggle Button -->

                            <!-- Header Link -->
                            <li class="hidden-xs animation-fadeInQuick">
                                <a href=""><strong>BIENVENIDO</strong></a>
                            </li>
                            <!-- END Header Link -->
                        </ul>
                        <!-- END Left Header Navigation -->

                        <!-- Right Header Navigation -->
                        <ul class="nav navbar-nav-custom pull-right">
                            <!-- Search Form -->
           
                            <!-- END Search Form -->

                            <!-- Alternative Sidebar Toggle Button -->

                            <!-- END Alternative Sidebar Toggle Button -->

                            <!-- User Dropdown -->
                            <li class="dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="<?php echo base_url('assets'); ?>/img/placeholders/avatars/avatar9.jpg" alt="avatar">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-header">
                                        <strong><?php echo strtoupper($_SESSION['user_name']); ?></strong>
                                    </li>
                                    
                                    <li>
                                        <a href="<?php echo base_url("editar-usuario") . '/' . $_SESSION['user_id']; ?>">
                                            <i class="fa fa-pencil-square fa-fw pull-right"></i>
                                            Perfil
                                        </a>
                                    </li>
                                  
                                    <li>
                                        <a href="<?php echo base_url("signout"); ?>">
                                            <i class="fa fa-power-off fa-fw pull-right"></i>
                                            Cerrar Sesión
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- END User Dropdown -->
                        </ul>
                        <!-- END Right Header Navigation -->
                    </header>
                    <!-- END Header -->

                    <!-- Page content -->
                    <div id="page-content">
                        
                        <!-- Blank Header -->
                        <?php if($type_layout == LAYOUT_TYPE_GENERAL){ ?>
                        <div class="content-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="header-section">
                                        <h1><?php echo $header_title; ?></h1>
                                    </div>
                                </div>
                                <div class="col-sm-6 hidden-xs">
                                    <!--<div class="header-section">
                                        <ul class="breadcrumb breadcrumb-top">
                                            <li>Extra Pages</li>
                                            <li><a href="">Blank</a></li>
                                        </ul>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <!-- END Blank Header -->

                        <!-- Get Started Block -->
                        <div class="block full">
                            <!-- Get Started Title -->
                            <div class="block-title">
                                <h2><?php echo $header_description; ?></h2>
                            </div>
                            <!-- END Get Started Title -->
                            <?php
                                if ($this->session->flashdata('message_error')) {
                                    ?>
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <strong><?php echo $this->session->flashdata('message_error'); ?></strong>
                                    </div>
                                    <?php
                                $this->session->unset_userdata('message_error');
                                }
                                if ($this->session->flashdata('message_success')) {
                                    ?>
                                    <div role="alert" class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <strong><?php echo $this->session->flashdata('message_success'); ?></strong>
                                    </div>
                                    <?php
                                $this->session->unset_userdata('message_success');
                                }
                            ?>
                            <!-- Get Started Content -->
                            <?php echo $this->load->view($dash_container); ?>
                            <!-- END Get Started Content -->
                        </div>
                        <?php }else if($type_layout == LAYOUT_TYPE_DASHBOARD){ ?>
                            <?php
                                if ($this->session->flashdata('message_error')) {
                                    ?>
                                    <div class="alert alert-danger">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <strong><?php echo $this->session->flashdata('message_error'); ?></strong>
                                    </div>
                                    <?php
                                $this->session->unset_userdata('message_error');
                                }
                                if ($this->session->flashdata('message_success')) {
                                    ?>
                                    <div role="alert" class="alert alert-success">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <strong><?php echo $this->session->flashdata('message_success'); ?></strong>
                                    </div>
                                    <?php
                                $this->session->unset_userdata('message_success');
                                }
                            ?>
                            <?php echo $this->load->view($dash_container); ?>
                        <?php } ?>
                        <!-- END Get Started Block -->
                    </div>
                    <!-- END Page Content -->
                </div>
                <!-- END Main Container -->
            </div>
            <!-- END Page Container -->
        </div>
        <!-- END Page Wrapper -->

        <!-- jQuery, Bootstrap, jQuery plugins and Custom JS code -->
        <script src="<?php echo base_url('assets'); ?>/js/vendor/jquery-2.2.4.min.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/vendor/bootstrap.min.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/plugins.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/app.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/plugins/promise.min.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/plugins/sweetalert2.min.js"></script>


        <?php echo $footer_scripts; ?>
        <!-- Load and execute javascript code used only in this page -->
        
    </body>
</html>