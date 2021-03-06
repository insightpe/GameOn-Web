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
				<!-- form start -->
				<form role="form" id="frmPromocion" action="<?php echo base_url('agregar-deporte'); ?>" method="POST" enctype="multipart/form-data">
					<div class="box-body">
						<div class="row">
							<div class="col-xl-6">
								<div class="row">
									<div class="col-xl-12">
										<div class="form-group">
											<label for="titulo">Título</label>
											<input id="titulo" type="text" class="form-control" name="titulo" placeholder="Título">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xl-12">
										<div class="form-group">
											<label for="subtitulo">Subtítulo</label>
											<input id="subtitulo" type="text" class="form-control" name="subtitulo" placeholder="Subtítulo">
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
														Activado
												</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6">
								<div class="row">
									<div class="col-md-6">
										<h4 class="card-title custom-profile">Imágen</h4>
										<div class="fileinput text-center fileinput-new" data-provides="fileinput">
											<div class="fileinput-new thumbnail">
									
												<img src="<?php echo base_url('assets/img') . "/image_placeholder.jpg";?>" alt="...">
							
											</div>
											<div class="fileinput-preview fileinput-exists thumbnail">
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
							</div>
						</div><!-- /.box-body -->
					<div class="box-footer">
						<button type="button" id="btnNewPromocion" class="btn btn-primary"><?php echo $this->lang->line('button_create'); ?></button>
						<button type="button" class="btn btn-primary" onclick='window.location="<?php echo base_url('listar-promociones'); ?>"'>Regresar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>