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
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>        
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
    </body>
</html>