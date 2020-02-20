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
                <?php
                if (validation_errors()) {
                    echo '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>';
                }
                ?>
                <!-- form start -->
                <form role="form" id="frmUpdatePass"  action="<?php echo base_url('actualizar-pass'); ?>" method="POST">
                    <input type="hidden" value="<?php echo $user->id; ?>" id="id" name="id">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="user_pass"><?php echo $this->lang->line('users_forms_user_pass'); ?></label>
                            <input type="password" class="form-control" id="user_pass" name="user_pass" placeholder="<?php echo $this->lang->line('users_forms_user_pass'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_confirm_pass"><?php echo $this->lang->line('users_forms_user_confirm_pass'); ?></label>
                            <input type="password" class="form-control" id="user_confirm_pass" name="user_confirm_pass" placeholder="<?php echo $this->lang->line('users_forms_user_confirm_pass'); ?>">
                        </div>               
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                    <button type="button" id="change_pass" class="btn btn-primary"><?php echo $this->lang->line('button_update'); ?></button>
                    <button type="button" class="btn btn-primary" onclick='window.location="<?php echo base_url('listar-usuarios'); ?>"'>Regresar</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>