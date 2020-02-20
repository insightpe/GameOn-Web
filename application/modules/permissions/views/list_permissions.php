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
                <div class="toolbar">
                    
                </div>
                <?php echo $this->table->generate(); ?>
                
            </div>
        </div>
    </div>
</div>
<input type="hidden" value="<?php echo $this->acl->control_acceso('form_edit_permission')? '1':'0' ?>" id="__form_edit_permission" name="__form_edit_permission" >
<input type="hidden" value="<?php echo $this->acl->control_acceso('delete_permission')? '1':'0' ?>" id="__delete_permission" name="__delete_permission" >