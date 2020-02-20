<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title><?php echo $title; ?></title>

        <meta name="description" content="<?php echo $header_description; ?>">
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

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/main.css">

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="<?php echo base_url('assets'); ?>/css/themes.css">
        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) -->
        <script src="<?php echo base_url('assets'); ?>/js/vendor/modernizr-3.3.1.min.js"></script>
    </head>
    <body>
        <!-- Login Container -->
        <div id="login-container">
            <!-- Reminder Header -->
            <h1 class="h2 text-light text-center push-top-bottom animation-slideDown">
                <i class="fa fa-history"></i> <strong>Recordar Contraseña</strong>
            </h1>
            <!-- END Reminder Header -->

            <!-- Reminder Block -->
            <div class="block animation-fadeInQuickInv">
                <!-- Reminder Title -->
                <div class="block-title">
                    <div class="block-options pull-right">
                        <a href="<?php echo base_url('inicio-sesion'); ?>" class="btn btn-effect-ripple btn-primary" data-toggle="tooltip" data-placement="left" title="Regresar a Inicio de Sesión"><i class="fa fa-user"></i></a>
                    </div>
                    <h2>Recordar</h2>
                </div>
                <!-- END Reminder Title -->

                <!-- Reminder Form -->
                <form id="form-reminder" action="<?php echo base_url('envio-contrasena'); ?>" method="post" class="form-horizontal">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="text" id="user_email" name="user_email" class="form-control" placeholder="Enter your email..">
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-12 text-right">
                            <button type="submit" class="btn btn-effect-ripple btn-sm btn-primary"><i class="fa fa-check"></i> Recordar Contraseña</button>
                        </div>
                    </div>
                </form>
                <!-- END Reminder Form -->
            </div>
            <!-- END Reminder Block -->

            <!-- Footer -->
            <footer class="text-muted text-center animation-pullUp">
                <small><span id="year-copy"></span> &copy; <a href="https://raycomsoluciones.com/site/" target="_blank">RaycomSoluciones</a></small>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Login Container -->

        <!-- jQuery, Bootstrap, jQuery plugins and Custom JS code -->
        <script src="<?php echo base_url('assets'); ?>/js/vendor/jquery-2.2.4.min.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/vendor/bootstrap.min.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/plugins.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/app.js"></script>

        <!-- Load and execute javascript code used only in this page -->
        <script src="<?php echo base_url('assets'); ?>/js/pages/readyReminder.js"></script>
        <script>$(function(){ ReadyReminder.init(); });</script>
    </body>
</html>