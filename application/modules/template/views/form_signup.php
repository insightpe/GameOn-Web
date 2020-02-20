<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $title; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo base_url('assets/templates/admin'); ?>/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url('assets/templates/admin'); ?>/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url('assets/templates/admin'); ?>/plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="hold-transition register-page">
        <div class="register-box">
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
            }
            ?>
            <div class="register-logo">
                <a href="<?php echo base_url(); ?>"><b><?php echo $this->configs->getAppName(); ?></b></a>
            </div>

            <div class="register-box-body">
                <p class="login-box-msg"><?php echo $this->lang->line('auth_signup_user'); ?></p>
                <?php
                if (validation_errors()) {
                    echo '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>';
                }
                ?>
                <form action="<?php echo base_url('signup'); ?>" method="POST">
                    <div class="form-group has-feedback">
                        <input type="text" name="user_name" value="<?php echo set_value('user_name'); ?>" class="form-control" placeholder="<?php echo $this->lang->line('users_forms_full_name'); ?>">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="email" name="user_email" value="<?php echo set_value('user_email'); ?>" class="form-control" placeholder="<?php echo $this->lang->line('users_forms_email'); ?>">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="user_pass" class="form-control" placeholder="<?php echo $this->lang->line('users_forms_user_pass'); ?>">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" name="user_confirm_pass" class="form-control" placeholder="<?php echo $this->lang->line('users_forms_user_confirm_pass'); ?>">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    </div>
                    <p><small> <?php echo $this->lang->line('info_captcha'); ?></small><br><?php echo $captcha['image']; ?></p>
                    <div class="form-group has-feedback">
                        <input type="text" name="user_captcha" class="form-control" placeholder="Captcha">
                        <span class="glyphicon glyphicon-pencil form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="<?php echo base_url(); ?>" class="btn btn-danger btn-block btn-flat"><?php echo $this->lang->line('button_cancel'); ?></a>
                        </div><!-- /.col -->
                        <div class="col-xs-6">
                            <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo $this->lang->line('button_create'); ?></button>
                        </div><!-- /.col -->
                    </div>
                </form>
                <br>
                <a href="<?php echo base_url('inicio-sesion'); ?>" class="text-center"><?php echo $this->lang->line('button_signin'); ?></a>
            </div><!-- /.form-box -->
        </div><!-- /.register-box -->

        <!-- jQuery 2.1.4 -->
        <script src="<?php echo base_url('assets/templates/admin'); ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="<?php echo base_url('assets/templates/admin'); ?>/bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url('assets/templates/admin'); ?>/plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>




<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>AppUI - Web App Bootstrap Admin Template</title>

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
            <!-- Register Header -->
            <h1 class="h2 text-light text-center push-top-bottom animation-slideDown">
                <i class="fa fa-plus"></i> <strong>Create Account</strong>
            </h1>
            <!-- END Register Header -->

            <!-- Register Form -->
            <div class="block animation-fadeInQuickInv">
                <!-- Register Title -->
                <div class="block-title">
                    <div class="block-options pull-right">
                        <a href="page_ready_login.html" class="btn btn-effect-ripple btn-primary" data-toggle="tooltip" data-placement="left" title="Back to login"><i class="fa fa-user"></i></a>
                    </div>
                    <h2>Register</h2>
                </div>
                <!-- END Register Title -->

                <!-- Register Form -->
                <form id="form-register" action="page_ready_register.html" method="post" class="form-horizontal">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="text" id="register-username" name="register-username" class="form-control" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="text" id="register-email" name="register-email" class="form-control" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="password" id="register-password" name="register-password" class="form-control" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="password" id="register-password-verify" name="register-password-verify" class="form-control" placeholder="Verify Password">
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-6">
                            <label class="csscheckbox csscheckbox-primary" data-toggle="tooltip" title="Agree to the terms">
                                <input type="checkbox" id="register-terms" name="register-terms">
                                <span></span>
                            </label>
                            <a href="#modal-terms" data-toggle="modal">Terms</a>
                        </div>
                        <div class="col-xs-6 text-right">
                            <button type="submit" class="btn btn-effect-ripple btn-success"><i class="fa fa-plus"></i> Create Account</button>
                        </div>
                    </div>
                </form>
                <!-- END Register Form -->
            </div>
            <!-- END Register Block -->

            <!-- Footer -->
            <footer class="text-muted text-center animation-pullUp">
                <small><span id="year-copy"></span> &copy; <a href="http://goo.gl/RcsdAh" target="_blank">AppUI 2.7</a></small>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Login Container -->

        <!-- Modal Terms -->
        <div id="modal-terms" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title text-center"><strong>Terms and Conditions</strong></h3>
                    </div>
                    <div class="modal-body">
                        <h4 class="page-header">1. <strong>General</strong></h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta. Integer fermentum tincidunt auctor.</p>
                        <h4 class="page-header">2. <strong>Account</strong></h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta. Integer fermentum tincidunt auctor.</p>
                        <h4 class="page-header">3. <strong>Service</strong></h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta. Integer fermentum tincidunt auctor.</p>
                        <h4 class="page-header">4. <strong>Payments</strong></h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas ultrices, justo vel imperdiet gravida, urna ligula hendrerit nibh, ac cursus nibh sapien in purus. Mauris tincidunt tincidunt turpis in porta. Integer fermentum tincidunt auctor.</p>
                    </div>
                    <div class="modal-footer">
                        <div class="text-center">
                            <button type="button" class="btn btn-effect-ripple btn-sm btn-primary" data-dismiss="modal">I've read them!</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Modal Terms -->

        <!-- jQuery, Bootstrap, jQuery plugins and Custom JS code -->
        <script src="<?php echo base_url('assets'); ?>/js/vendor/jquery-2.2.4.min.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/vendor/bootstrap.min.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/plugins.js"></script>
        <script src="<?php echo base_url('assets'); ?>/js/app.js"></script>

        <!-- Load and execute javascript code used only in this page -->
        <script src="<?php echo base_url('assets'); ?>/js/pages/readyRegister.js"></script>
        <script>$(function(){ ReadyRegister.init(); });</script>
    </body>
</html>