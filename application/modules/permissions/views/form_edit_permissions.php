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
                <form role="form" id="frmPermission" action="<?php echo base_url('actualizar-permiso'); ?>" method="POST">
                    <input type="hidden" value="<?php echo $permission->id_permission; ?>" id="id" name="id">
                    <div class="form-group">
                        <label for="permissions_name">
                            <?php echo $this->lang->line('permission_name'); ?>
                        </label>
                        <input type="text" class="form-control" value="<?php if(set_value('permissions_name')){ echo set_value('permissions_name');}else{ echo $permission->title; } ?>" id="permissions_name" name="permissions_name" placeholder="<?php echo $this->lang->line('permission_name'); ?>">
                    </div>
                    <div class="form-group">
                        <label for="permissions_key">
                            <?php echo $this->lang->line('permission_key'); ?>
                        </label>
                        <input type="text" class="form-control" value="<?php if(set_value('permissions_key')){ echo set_value('permissions_key');}else{ echo $permission->name; }; ?>" id="permissions_key" name="permissions_key" placeholder=" <?php echo $this->lang->line('permission_key'); ?>">
                    </div>
                    <button type="button" id="btnUpdate" class="btn btn-o btn-primary">
                    
                        <?php echo $this->lang->line('button_update'); ?>
                    </button>
                    <button type="button" class="btn btn-primary" onclick='window.location="<?php echo base_url('listar-permiso'); ?>"'>Regresar</button>
                    
                </form>
            </div>
        </div>
    </div>
</div>
