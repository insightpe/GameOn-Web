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
                <?php
                if (validation_errors()) {
                    echo '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>';
                }
                ?>
                <!-- form start -->
                <form role="form" id="frmDeporte" action="<?php echo base_url('agregar-deporte'); ?>" method="POST">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="nombre"><?php echo $this->lang->line('nombre'); ?></label>
                            <input id="nombre" type="text" class="form-control" name="nombre" placeholder="<?php echo $this->lang->line('nombre'); ?>">
                        </div>
                    </div><!-- /.box-body -->

                    <div class="box-footer">
                    
                    <button type="button" id="btnNewDeporte" class="btn btn-primary"><?php echo $this->lang->line('button_create'); ?></button>
                        <button type="button" class="btn btn-primary" onclick='window.location="<?php echo base_url('listar-deportes'); ?>"'>Regresar</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


