<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"><?php echo $header_description; ?></h4>
			</div>
			<div class="card-body">
				<div class="toolbar">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="campo_id">Centro Deportivo</label>
								<select class="form-control" name="campo_id" id="campo_id" <?php echo $_SESSION['user_role'] == CAMPO_ROLE_ID ? "disabled" : "" ?>>
									<?php
									foreach ($campos as $campo) {
											echo '<option ' . ($_SESSION['campo_id'] ==  $campo->campo_id ? "selected" : "") .  ' value="' . $campo->campo_id . '">' . $campo->nombre . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="deporte_id">Deporte</label>
								<select class="form-control" name="deporte_id" id="deporte_id">
									<?php
									foreach ($deportes as $deporte) {
											echo '<option  value="' . $deporte->deporte_id . '">' . $deporte->nombre . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="campo_cancha_id">Cancha</label>
								<select class="form-control" name="campo_cancha_id" id="campo_cancha_id">
									<option value="">TODAS LAS CANCHAS</option>
									<?php
									foreach ($campo_canchas as $campo_cancha) {
											echo '<option  value="' . $campo_cancha->campo_cancha_id . '">' . $campo_cancha->nombre . '</option>';
									}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div id="fullCalendar"></div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" value="<?php echo $this->acl->control_acceso('form_edit_campocanchas') ? '1' : '0' ?>" id="__form_edit_campocanchas" name="__form_edit_campocanchas">
<input type="hidden" value="<?php echo $this->acl->control_acceso('delete_campocanchas') ? '1' : '0' ?>" id="__delete_campocanchas" name="__delete_campocanchas">