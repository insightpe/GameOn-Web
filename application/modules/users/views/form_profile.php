<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                    <h4 class="card-title"><?php echo $header_title; ?></h4>
            </div>
            <div class="card-body">
        <!-- general form elements -->
                <ul class="nav nav-pills nav-pills-primary" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#settings" role="tablist">
                            <?php echo $this->lang->line('users_view_tap_profile'); ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#password" role="tablist">
                            <?php echo $this->lang->line('users_view_tap_security'); ?>
                        </a>
                    </li>
                </ul>
                <?php
                if (validation_errors()) {
                    echo '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>';
                }
                ?>

                    <div class="tab-content tab-space">
                        <div class="tab-pane active" id="settings">
                            <form class="form-horizontal" id="frmUpdateProfile" action="<?php echo base_url('actualizar-perfil'); ?>" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <label for="user_name" class="col-sm-3 control-label"><?php echo $this->lang->line('users_forms_full_name'); ?></label>
                                            <div class="col-sm-9">
                                                <input type="text" id="user_name" name="user_name" value="<?php if (set_value('user_name')) {
                                                    echo set_value('user_name');
                                                } else {
                                                    echo $user->nombre;
                                                } ?>" required data-val="true" data-val-required="El Nombre del Role es obligatorio." class="form-control" id="user_name" placeholder="<?php echo $this->lang->line('users_forms_full_name'); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="user_email" class="col-sm-3 control-label"><?php echo $this->lang->line('users_forms_email'); ?></label>
                                            <div class="col-sm-9">
                                                <input type="email" value="<?php echo $user->user_email; ?>" readonly class="form-control" id="user_email" placeholder="<?php echo $this->lang->line('users_forms_email'); ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <h4 class="card-title custom-profile"><?php echo $this->lang->line('users_view_user_img_profile'); ?></h4>
                                        <div class="fileinput text-center <?php echo ($_SESSION['user_img'] == null ? "fileinput-new" : "fileinput-exists") ?>" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail img-circle">
                                                <?php if($_SESSION['user_img'] == null){?>
                                                <img src="<?php echo base_url('assets/img') . "/placeholder.jpg";?>" alt="...">
                                                <?php } ?>
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail img-circle">
                                                <?php if($_SESSION['user_img'] != null){?>
                                                    <img src="<?php echo base_url('assets/img/users_img') . "/" . $_SESSION['user_img'];?>" alt="...">
                                                <?php } ?>
                                            </div>
                                            <div>
                                                <span class="btn btn-round btn-rose btn-file">
                                                    <span class="fileinput-new">Agregar Foto</span>
                                                    <span class="fileinput-exists">Cambiar</span>
                                                    <input type="file" id="userfile" name="userfile" name="..." /></span>
                                                <br />
                                                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Eliminar</a>
                                            </div>
                                        </div>
                                        <!--
                                        <div class="form-group">
                                            <label for="userfile" class="col-sm-4 control-label"><?php echo $this->lang->line('users_view_user_img_profile'); ?></label>
                                            <div class="col-sm-12">
                                                <img class="profile-user-img img-responsive pull-left" src="<?php echo base_url('assets/img/users_img'); ?>/<?php echo $_SESSION['user_img']; ?>" alt="<?php echo $_SESSION['user_name']; ?>">
                                                <input type="file" id="userfile" name="userfile" class="form-control">
                                            </div>
                                        </div>!-->
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <button type="button" id="btnUpdateProfile" class="btn btn-danger"><?php echo $this->lang->line('button_update'); ?></button>
                                            </div>
                                        </div>
                                    </div>                            
                                </div>                        
                            </form>
                        </div><!-- /.tab-pane -->
                        <div class="tab-pane" id="password">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6 col-xs-12">
                                    <form class="form-horizontal" id="frmUpdatePassProfile" action="<?php echo base_url('actualizar-pass-perfil'); ?>" method="POST">
                                        <div class="form-group">
                                            <label for="user_pass" class="col-sm-4 control-label"><?php echo $this->lang->line('users_forms_user_current'); ?></label>
                                            <div class="col-sm-8">
                                                <input type="password" name="user_old_pass" class="form-control" id="user_pass" placeholder="<?php echo $this->lang->line('users_forms_user_current'); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="user_new_pass" class="col-sm-4 control-label"><?php echo $this->lang->line('users_forms_user_pass'); ?></label>
                                            <div class="col-sm-8">
                                                <input type="password" name="user_pass" class="form-control" id="user_new_pass" placeholder="<?php echo $this->lang->line('users_forms_user_pass'); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="user_confirm_new_pass" class="col-sm-4 control-label"><?php echo $this->lang->line('users_forms_user_confirm_pass'); ?></label>
                                            <div class="col-sm-8">
                                                <input type="password" name="user_confirm_pass" class="form-control" id="user_confirm_new_pass" placeholder="<?php echo $this->lang->line('users_forms_user_confirm_pass'); ?>">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="button" id="btnUpdateSecurity" class="btn btn-danger"><?php echo $this->lang->line('button_update'); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div><!-- /.tab-pane -->
                    </div><!-- /.tab-content -->

            </div>
        </div>
    </div>
</div>