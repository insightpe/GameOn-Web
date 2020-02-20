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
                <form role="form" id="frmUser" action="<?php echo base_url('actualizar-usuario'); ?>" method="POST">
                    <input type="hidden" value="<?php echo $user->id; ?>" name="id">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="user_name"><?php echo $this->lang->line('users_forms_full_name'); ?></label>
                            <input type="text" id="user_name" value="<?php if(set_value('user_name')){ echo set_value('user_name');}else{echo $user->nombre;} ?>" class="form-control" name="user_name" placeholder="<?php echo $this->lang->line('users_forms_full_name'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_email"><?php echo $this->lang->line('users_forms_email'); ?></label>
                            <input type="email" id="user_email" class="form-control" readonly value="<?php echo $user->user_email; ?>" placeholder="<?php echo $this->lang->line('users_forms_email'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_role"><?php echo $this->lang->line('users_forms_user_rol'); ?></label>
                            <select class="form-control" id="user_role" name="user_role">
                                <?php
                                foreach ($roles as $rol) {
                                    if($user->user_role_id == $rol->role_id){
                                        $selected = "selected";
                                    }else{
                                        $selected = "";
                                    }
                                    echo '<option value="' . $rol->role_id . '" '.$selected.'>' . $rol->role . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user_status"><?php echo $this->lang->line('users_forms_user_status'); ?></label>
                            <select class="form-control" id="user_status" name="user_status">
                                <?php
                                $activo = "";
                                $inactivo = "";
                                    if($user->user_status_id == 1){
                                        $activo = "selected";
                                    }else{
                                        $inactivo = "selected";
                                    }
                                ?>
                                <option value="1" <?php echo $activo; ?>><?php echo $this->lang->line('status_active'); ?></option>
                                <option value="2" <?php echo $inactivo; ?>><?php echo $this->lang->line('status_unactive'); ?></option>
                            </select>
                        </div>                    
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                    <button type="button" name="update_user" id="update_user" value="dash" class="btn btn-primary"><?php echo $this->lang->line('button_update'); ?></button>
                    <button type="button" class="btn btn-primary" onclick='window.location="<?php echo base_url('listar-usuarios'); ?>"'>Regresar</button>
                    
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>