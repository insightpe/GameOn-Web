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
                <form role="form" id="frmRole" action="<?php echo base_url('agregar-rol'); ?>" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="rol_name"><?php echo $this->lang->line('role_name'); ?></label>
                            <input id="rol_name" type="text" class="form-control" name="rol_name" placeholder="<?php echo $this->lang->line('role_name'); ?>">
                        </div>
                        
                        <div class="form-group">
                            <label for="lista_roles">Clonar Rol desde</label>
                            <select class="form-control" name="lista_roles" id="lista_roles"  >    
                            <option value="">Seleccionar...</option>     
                            <?php
                            foreach ($roles as $rol) {
                                echo '<option value="' . $rol->role_id . '">' . $rol->role . '</option>';
                            }
                            ?>                                            
                            </select>
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                    
                    <button type="button" id="btnNewRole" class="btn btn-primary"><?php echo $this->lang->line('button_create'); ?></button>
                        <button type="button" class="btn btn-primary" onclick='window.location="<?php echo base_url('listar-roles'); ?>"'>Regresar</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


