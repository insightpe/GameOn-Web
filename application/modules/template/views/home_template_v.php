<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Starter, App Base para un proyecto web">
        <meta name="author"content="Christopher Flores">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title><?php echo $title; ?></title>

        <!-- Bootstrap -->
        <link href="<?php echo base_url('assets/templates/home/bootstrap'); ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url('assets/templates/home/mdl'); ?>/material.min.css" rel="stylesheet" type="text/css"/>        
        <link href="<?php echo base_url('assets/templates/home/font-awesome-4.6.1'); ?>/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
      <link href="<?php echo base_url(); ?>assets/css/general.css" rel="stylesheet" type="text/css"/>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
    <input type="hidden" id="baseUrl" name="baseUrl" value="<?php echo base_url(); ?>">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url('home'); ?>">Starter</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="<?php echo base_url('home'); ?>">Inicio <span class="sr-only">(current)</span></a></li>
                        <li><a href="<?php echo base_url('dashboard'); ?>">Admin</a></li>                        
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <?php if (@$_SESSION['is_logged_in']): ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['user_name']; ?> <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Action</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?php echo base_url('signout'); ?>">Salir</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li><a href="<?php echo base_url('registro-usuario'); ?>">Registrarse</a></li>
                            <li><a href="<?php echo base_url('inicio-sesion'); ?>">Iniciar Sesión</a></li>
                        <?php endif; ?>

                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>

        <main>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
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
                    </div>
                </div>
                <?php echo $this->load->view($main_container); ?>                
            </div>
        </main>

        <footer class="mdl-mini-footer">
            <div class="mdl-mini-footer__left-section">
                <div class="mdl-logo">Starter by Christopher Flores</div>
            </div>
        </footer>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="<?php echo base_url('assets/templates/home/jquery'); ?>/jquery-1.12.3.min.js" type="text/javascript"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo base_url('assets/templates/home/bootstrap'); ?>/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url('assets/templates/home/mdl'); ?>/material.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url('assets/templates/home/jquery-block-ui'); ?>/jquery.blockUI.js" type="text/javascript"></script>
    </body>
</html>