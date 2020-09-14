<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                    <h4 class="card-title"><?php echo $header_description; ?></h4>
            </div>
            <div class="card-body">
        <!-- general form elements -->

                <?php
                if (validation_errors()) {
                    echo '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>';
                }
                ?>
                <!-- form start -->
                <form role="form" id="frmUser" action="<?php echo base_url('agregar-usuario'); ?>" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="user_name">Nombres</label>
                            <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Nombres">
                        </div>
                        <div class="form-group">
                            <label for="user_lastname">Apellidos</label>
                            <input type="text" class="form-control" name="user_lastname" id="user_lastname" placeholder="Apellidos">
                        </div>
                        <div class="form-group">
                            <label for="user_email"><?php echo $this->lang->line('users_forms_email'); ?></label>
                            <input type="email" class="form-control" name="user_email" id="user_email" placeholder="<?php echo $this->lang->line('users_forms_email'); ?>">
                        </div>
                        <div class="form-group" id="secPass">
                            <label for="user_pass"><?php echo $this->lang->line('users_forms_user_pass'); ?></label>
                            <input type="password" class="form-control" name="user_pass" id="user_pass" placeholder="<?php echo $this->lang->line('users_forms_user_pass'); ?>">
                        </div>
                        <div class="form-group" id="secPassConfirm">
                            <label for="user_confirm_pass"><?php echo $this->lang->line('users_forms_user_confirm_pass'); ?></label>
                            <input type="password" class="form-control" name="user_confirm_pass" id="user_confirm_pass" placeholder="<?php echo $this->lang->line('users_forms_user_confirm_pass'); ?>">
                        </div>
                        <div class="form-group">
                            <label for="user_role"><?php echo $this->lang->line('users_forms_user_rol'); ?></label>
                            <select class="form-control" name="user_role" id="user_role">
                                <?php
                                foreach ($roles as $rol) {
                                    echo '<option value="' . $rol->role_id . '">' . $rol->role . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group" id="secCampoAsignado" style="display:none">
                            <label for="user_role">Centro Deportivo Asignado</label>
                            <select class="form-control" name="campo_id" id="campo_id">
                                <option value="">Seleccione uno...</option>
                                <?php
                                foreach ($campos as $campo) {
                                    echo '<option value="' . $campo->campo_id . '">' . $campo->nombre . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user_status"><?php echo $this->lang->line('users_forms_user_status'); ?></label>
                            <select class="form-control" name="user_status" id="user_status">
                                <option value="1"><?php echo $this->lang->line('status_active'); ?></option>
                                <option value="2"><?php echo $this->lang->line('status_unactive'); ?></option>
                                <option value="4"><?php echo $this->lang->line('status_unactive'); ?></option>
                            </select>
                        </div>                    
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                    <button type="button" id="btnNewUser" name="btnNewUser" value="dash" class="btn btn-primary"><?php echo $this->lang->line('button_create'); ?></button>
                    <button type="button" class="btn btn-primary" onclick='window.location="<?php echo base_url('listar-usuarios'); ?>"'>Regresar</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>