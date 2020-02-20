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
                <?php
                if (validation_errors()) {
                    echo '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>';
                }
                ?>
                <form role="form" id="frmRole" action="<?php echo base_url('actualizar-rol'); ?>" method="POST">
                    <input type="hidden" value="<?php echo $rol->role_id; ?>" id="id" name="id">
                    <div class="form-group">
                        <label for="rol_name">
                            <?php echo $this->lang->line('role_name'); ?>
                        </label>
                        <input type="text" class="form-control" value="<?php if (set_value('role_name')) {
                    echo set_value('role_name');
                } else {
                    echo $rol->role;
                } ?>" name="rol_name" id="rol_name" placeholder="<?php echo $this->lang->line('role_name'); ?>">

                    </div>
                    <button type="button" id="btnUpdate" class="btn btn-o btn-primary">
                    
                        <?php echo $this->lang->line('button_update'); ?>
                    </button>
                    <button type="button" class="btn btn-primary" onclick='window.location="<?php echo base_url('listar-roles'); ?>"'>Regresar</button>
                    
                </form>
            </div>
        </div>
    </div>
</div>


