<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<form method="POST" id="frmRolePermissions" action="<?php echo base_url('actualizar-permisos-rol').'/'.$rol->role_id; ?>">
    <input type="hidden" id="role_id" value="<?php echo $rol->role_id?>"/>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                        <h4 class="card-title"><?php echo $header_description; ?></h4>
                </div>
                <div class="card-body">
                    <div class="toolbar">
                        
                    </div>
                    
                  
                    <table id="dt-permissions" class="table table-striped table-bordered table-vcenter" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th width="100%"><?php echo $this->lang->line('permission_many'); ?></th>
                                <th class="text-center">
                                    <?php echo $this->lang->line('status_enable'); ?><br/>
                                    <div class="form-check form-check-radio">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" id="chk_perm_habilitado" value="1" onclick="$('.perm_habilitado').each(function() {
                                        $( this ).prop('checked', $('#chk_perm_habilitado').prop('checked'));
                                    });$('#chk_perm_denegado').prop('checked', false);$('#chk_perm_ignorado').prop('checked', false);">
                                    <span class="form-check-sign"></span>
                                    &nbsp;
                                    </label>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <?php echo $this->lang->line('status_denied'); ?><br/>
                                    <div class="form-check form-check-radio">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" id="chk_perm_denegado" value="" onclick="$('.perm_denegado').each(function() {
                                        $( this ).prop('checked', $('#chk_perm_denegado').prop('checked'));
                                    });$('#chk_perm_habilitado').prop('checked', false);$('#chk_perm_ignorado').prop('checked', false);">
                                    <span class="form-check-sign"></span>
                                    &nbsp;
                                    </label>
                                    </div>
                                </th>
                                <th class="text-center">
                                    <?php echo $this->lang->line('status_ignore'); ?><br/>
                                    <div class="form-check form-check-radio">
                                    <label class="form-check-label">
                                    <input type="radio" class="form-check-input" id="chk_perm_ignorado" value="x" onclick="$('.perm_ignorado').each(function() {
                                        $( this ).prop('checked', $('#chk_perm_ignorado').prop('checked'));
                                    });$('#chk_perm_denegado').prop('checked', false);$('#chk_perm_habilitado').prop('checked', false);">
                                    <span class="form-check-sign"></span>
                                    &nbsp;
                                    </label>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (count($permisos)) {
                                foreach ($permisos as $permiso) {
                                    if ($permiso['status'] == 1) {
                                        $checked_1 = "checked";
                                    } else {
                                        $checked_1 = "";
                                    }
                                    if ($permiso['status'] == "") {
                                        $checked = "checked";
                                    } else {
                                        $checked = "";
                                    }
                                    if ($permiso['status'] === "x") {
                                        $checked_x = "checked";
                                    } else {
                                        $checked_x = "";
                                    }
                                    echo '<tr>';
                                    echo '<td>' . $permiso['title'] . '</td>';

                                    echo '<td class="text-center">
                                        <div class="form-check form-check-radio">
                                        <label class="form-check-label">
                                        <input type="radio" class="form-check-input perm_habilitado" name="perm_' . $permiso['id_permission'] . '" value="1" ' . $checked_1 . '>
                                        <span class="form-check-sign"></span>
                                        &nbsp;
                                        </label>
                                        </div>
                                        </td>';
                                    echo '<td class="text-center">
                                        <div class="form-check form-check-radio">
                                        <label class="form-check-label">
                                        <input type="radio" class="form-check-input perm_denegado" name="perm_' . $permiso['id_permission'] . '" value="" ' . $checked . '>
                                        <span class="form-check-sign"></span>
                                        &nbsp;
                                        </label>
                                        </div>
                                        </td>';
                                    echo '<td class="text-center">
                                        <div class="form-check form-check-radio">
                                        <label class="form-check-label">
                                        <input type="radio" class="form-check-input perm_ignorado" name="perm_' . $permiso['id_permission'] . '" value="x" ' . $checked_x . '>
                                        <span class="form-check-sign"></span>
                                        &nbsp;
                                        </label> 
                                        </div>
                                        </td>';
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="pull-right">
                        <button type="button" id="btnUpdatePermissionsRole" value="dash" class="btn btn-primary"><?php echo $this->lang->line('button_save'); ?></button>
                        <button type="button" class="btn btn-primary" onclick='window.location="<?php echo base_url('listar-roles'); ?>"'>Regresar</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</form>
