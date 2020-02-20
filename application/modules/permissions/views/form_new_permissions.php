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
                <!-- form start -->
                <form role="form" id="frmPermission" action="<?php echo base_url('agregar-permiso'); ?>" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="permissions_name"><?php echo $this->lang->line('permission_name'); ?></label>
                            <input type="text" class="form-control" id="permissions_name" name="permissions_name" placeholder="<?php echo $this->lang->line('permission_name'); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="permissions_key"><?php echo $this->lang->line('permission_key'); ?></label>
                            <input type="text" class="form-control" id="permissions_key" name="permissions_key" placeholder="<?php echo $this->lang->line('permission_key'); ?>">
                        </div>
                        
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                    <button type="button" id="btnNewPermission"  class="btn btn-primary"><?php echo $this->lang->line('button_create'); ?></button>
                    <button type="button" class="btn btn-primary" onclick='window.location="<?php echo base_url('listar-permiso'); ?>"'>Regresar</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
