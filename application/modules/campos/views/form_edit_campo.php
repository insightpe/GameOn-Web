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
				<?php
				if (validation_errors()) {
					echo '<div class="alert alert-danger" role="alert">' . validation_errors() . '</div>';
				}
				?>
				<form role="form" id="frmCampo" action="<?php echo base_url('actualizar-deporte'); ?>" method="POST">
					<input type="hidden" value="<?php echo $campo->campo_id ?>" id="campo_id" name="campo_id">
					<input type="hidden" id="lat" name="lat" value="<?php echo $campo->lat ?>">
					<input type="hidden" id="lng" name="lng" value="<?php echo $campo->lng ?>">
					<div class="box-body">
					<div class="row">
							<div class="col-xl-6">
								<div class="row">
									<div class="col-xl-12">
										<div class="form-group">
											<label for="nombre">Nombre</label>
											<input id="nombre" type="text" class="form-control" value="<?php echo $campo->nombre ?>" name="nombre" placeholder="Nombre">
										</div>
									</div>
								</div>
								
								<div class="row">
									<div class="col-xl-12">
										<div class="form-group">
											<label for="campo_estados">Estado</label>
											<select class="form-control" name="campo_estados" id="campo_estados">
												<option value="">Seleccione uno...</option>
												<?php
												foreach ($campo_estados as $estado) {
														echo '<option ' . ($campo->campo_estado_id == $estado->campo_estado_id  ? "selected" : "") . ' value="' . $estado->campo_estado_id . '">' . $estado->nombre . '</option>';
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-12">
										<div class="form-group">
											<label for="external_url">External URL</label>
											<input id="external_url" type="text" class="form-control" value="<?php echo $campo->external_url ?>" name="external_url" placeholder="Ej.: http://www.google.com">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-4">
										<div class="form-group">
											<label for="external_url">Departamento</label>
											<select class="form-control" name="campo_departamentos" id="campo_departamentos">
												<option value="">Seleccione uno...</option>
												<?php
												foreach ($departamentos as $departamento) {
														echo '<option ' . ($campo->ubdepa_id == $departamento->id  ? "selected" : "") . ' value="' . $departamento->id . '">' . $departamento->name . '</option>';
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-xl-4">
										<div class="form-group">
											<label for="external_url">Provincia</label>
											<select class="form-control" name="campo_provincias" id="campo_provincias">
												<option value="">Seleccione uno...</option>
												<?php
												foreach ($provincias as $provincia) {
														echo '<option ' . ($campo->ubprov_id == $provincia->id  ? "selected" : "") . ' value="' . $provincia->id . '">' . $provincia->name . '</option>';
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-xl-4">
										<div class="form-group">
											<label for="external_url">Distrito</label>
											<select class="form-control" name="campo_distritos" id="campo_distritos">
												<option value="">Seleccione uno...</option>
												<?php
												foreach ($distritos as $distrito) {
														echo '<option ' . ($campo->ubdistri_id == $distrito->id  ? "selected" : "") . ' value="' . $distrito->id . '">' . $distrito->name . '</option>';
												}
												?>
											</select>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-12">
										<div class="form-group">
											<label for="datos_adicionales">Datos Adicionales</label>
											<textarea id="datos_adicionales" name="datos_adicionales" rows="6" class="form-control" placeholder="Datos Adicionales"><?php echo $campo->datos_adicionales ?></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-12">
										<h4 class="card-title">Fotos</h4>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-12">
										<div class="table-responsive">
												<table id="dt-campo-fotos" class="table table-striped table-bordered table-vcenter" width="100%" style="width: 100%;">
														<thead>
																<tr>                                
																	<th width="20%">Principal</th>
																	<th width="30%">Foto</th>
																	<th width="40%">Url</th>
																	<th class="text-center" width="10%"></th>
																</tr>
														</thead>
														<tbody>
														
														</tbody>
												</table>
											</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6">
								<div class="row">
										<div class="col-xl-12">
											<div class="form-group">
												<label for="ubicacion">Ubicación</label>
												<input id="ubicacion" type="text" class="form-control" name="ubicacion" value="<?php echo $campo->ubicacion ?>" placeholder="Ubicación">
											</div>
										</div>
									</div>
				

								<div style="display: none" class="form-group">
									<input id="pac-input"
												class="form-control mt-2" style="background-color: white;width:50%;font-size: small;height: 35px;"
												type="text"
												placeholder="Ingresar una ubicación">
								</div>
								<div id="map" class="map map-big map-xl"></div>
							</div>
						</div>
					</div>
					<div class="box-footer">
						<button type="button" id="btnUpdate" class="btn btn-primary"><?php echo $this->lang->line('button_update'); ?></button>
						<button type="button" class="btn btn-primary" onclick='window.location="<?php echo base_url('listar-campos'); ?>"'>Regresar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<form role="form" id="frmCampoImagen" action="<?php echo base_url('agregar-campo'); ?>" method="POST">
			<div class="modal-content">
				<div class="modal-header justify-content-center">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<i class="now-ui-icons ui-1_simple-remove"></i>
					</button>
					<h4 class="title title-up">Agregar Foto</h4>
				</div>
				<div class="modal-body">
					<input type="hidden" value="0" id="id_campo" name="id_campo">
					<input type="hidden" value="0" id="campo_imagenes_id" name="campo_imagenes_id">
					<div class="row">
						<div class="col-xl-12">
							<h4 class="card-title custom-profile">Imágen</h4>
							<div class="fileinput text-center" id="previewFile" data-provides="fileinput">
								<div class="fileinput-new thumbnail">
									<img src="<?php echo base_url('assets/img') . "/placeholder.jpg";?>" alt="...">
								</div>
								<div class="fileinput-preview fileinput-exists thumbnail" id="divThuExists">
									<img src="" id="imgImagenEdit" alt="...">
								</div>
								<div>
									<span class="btn btn-round btn-rose btn-file">
											<span class="fileinput-new">Agregar Imágen</span>
											<span class="fileinput-exists">Cambiar</span>
											<input type="file" id="userfile" name="userfile" name="..." /></span>
									<a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Eliminar</a>
								</div>
							</div>
							
						</div>
					</div>
					<div class="row">
						<div class="col-xl-12">
							<div class="form-group">
								<label for="url">URL</label>
								<input id="url" type="text" class="form-control" name="url" placeholder="URL">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xl-12">
							<div class="form-check mt-3">
								<label class="form-check-label">
										<input class="form-check-input"  id="activado" name="activado" type="checkbox">
										<span class="form-check-sign"></span>
										Principal
								</label>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="btnGrabarImagen" class="btn btn-default">Grabar</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</form>
	</div>
</div>