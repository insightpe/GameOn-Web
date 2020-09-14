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
                <form role="form" id="frmDeporte" action="<?php echo base_url('actualizar-deporte'); ?>" method="POST">
                    <input type="hidden" value="<?php echo $deporte->deporte_id; ?>" id="id" name="id">
                    <div class="form-group">
                        <label for="nombre">
                            <?php echo $this->lang->line('nombre'); ?>
                        </label>
                        <input type="text" class="form-control" value="<?php if (set_value('nombre')) {
                    echo set_value('nombre');
                } else {
                    echo $deporte->nombre;
                } ?>" name="nombre" id="nombre" placeholder="<?php echo $this->lang->line('nombre'); ?>">

                    </div>
                    <button type="button" id="btnUpdate" class="btn btn-o btn-primary">
                    
                        <?php echo $this->lang->line('button_update'); ?>
                    </button>
                    <button type="button" class="btn btn-primary" onclick='window.location="<?php echo base_url('listar-deportes'); ?>"'>Regresar</button>
                    
                </form>
            </div>
        </div>
    </div>
</div>


