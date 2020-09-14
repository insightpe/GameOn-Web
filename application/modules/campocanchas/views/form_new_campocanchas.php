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
				<form role="form" id="frmCampoCancha" action="" method="POST">
					<input type="hidden" value="0" id="id" name="id">
					<div class="box-body">
					<div class="row">
							<div class="col-xl-4">
								<div class="form-group">
									<label for="nombre">Nombre</label>
									<input id="nombre" type="text" class="form-control" name="nombre" placeholder="Nombre">
								</div>
							</div>
							<div class="col-xl-4">
								<div class="form-group">
									<label for="campo_id">Centro Deportivo</label>
									<select class="form-control" name="campo_id" id="campo_id">
									<?php if($_SESSION['user_role'] == CAMPO_ROLE_ID){ ?>
										<?php
										foreach ($campos as $campo) {
											if($_SESSION['campo_id'] ==  $campo->campo_id){
												echo '<option selected value="' . $campo->campo_id . '">' . $campo->nombre . '</option>';
											break;
											}
										}
										?>
									<?php } else { ?>
										<option value="">Seleccione uno...</option>
										<?php
										foreach ($campos as $campo) {
												echo '<option ' . ($_SESSION['campo_id'] ==  $campo->campo_id ? "selected" : "") .  ' value="' . $campo->campo_id . '">' . $campo->nombre . '</option>';
										}
										?>
									<?php } ?>

										
									</select>
								</div>
							</div>
							<div class="col-xl-4">
								<div class="form-group">
									<label for="deporte">Deporte</label>
									<select class="form-control" name="deporte_id" id="deporte_id">
										<option value="">Seleccione uno...</option>
										<?php
										foreach ($deportes as $deporte) {
												echo '<option value="' . $deporte->deporte_id . '">' . $deporte->nombre . '</option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-4">
								<div class="form-group">
									<label for="campo_estado_id">Estado</label>
									<select class="form-control" name="campo_estado_id" id="campo_estado_id">
										<option value="">Seleccione uno...</option>
										<?php
										foreach ($campo_estados as $estado) {
												echo '<option value="' . $estado->campo_estado_id . '">' . $estado->nombre . '</option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-12">
								<h4 class="card-title">Configurar Horario y Costo</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xl-12">
								<div class="table-responsive">
									<table class="table tblHorario" style="width:2980px">
										<thead>
											<tr>
												<th scope="col" style="width:100px">Día</th>
												<th scope="col" class="text-center" style="width:120px">00:00</th>
												<th scope="col" class="text-center" style="width:120px">01:00</th>
												<th scope="col" class="text-center" style="width:120px">02:00</th>
												<th scope="col" class="text-center" style="width:120px">03:00</th>
												<th scope="col" class="text-center" style="width:120px">04:00</th>
												<th scope="col" class="text-center" style="width:120px">05:00</th>
												<th scope="col" class="text-center" style="width:120px">06:00</th>
												<th scope="col" class="text-center" style="width:120px">07:00</th>
												<th scope="col" class="text-center" style="width:120px">08:00</th>
												<th scope="col" class="text-center" style="width:120px">09:00</th>
												<th scope="col" class="text-center" style="width:120px">10:00</th>
												<th scope="col" class="text-center" style="width:120px">11:00</th>
												<th scope="col" class="text-center" style="width:120px">12:00</th>
												<th scope="col" class="text-center" style="width:120px">13:00</th>
												<th scope="col" class="text-center" style="width:120px">14:00</th>
												<th scope="col" class="text-center" style="width:120px">15:00</th>
												<th scope="col" class="text-center" style="width:120px">16:00</th>
												<th scope="col" class="text-center" style="width:120px">17:00</th>
												<th scope="col" class="text-center" style="width:120px">18:00</th>
												<th scope="col" class="text-center" style="width:120px">19:00</th>
												<th scope="col" class="text-center" style="width:120px">20:00</th>
												<th scope="col" class="text-center" style="width:120px">21:00</th>
												<th scope="col" class="text-center" style="width:120px">22:00</th>
												<th scope="col" class="text-center" style="width:120px">23:00</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row">Lunes</th>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
											</tr>
											<tr>
												<th scope="row">Martes</th>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
											</tr>
											<tr>
												<th scope="row">Miércoles</th>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
											</tr>
											<tr>
												<th scope="row">Jueves</th>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
											</tr>
											<tr>
												<th scope="row">Viernes</th>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
											</tr>
											<tr>
												<th scope="row">Sábado</th>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
											</tr>
											<tr>
												<th scope="row">Domingo</th>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
												<td>
													<div class="input-group">
														<div class="input-group-prepend">
															<div class="input-group-text">
																<input type="checkbox" name="chkhourday">
															</div>
														</div>
														<input type="number" name="txthourday" value="" readonly class="form-control form-control-sm text-center" />
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div><!-- /.box-body -->

					<div class="box-footer">

						<button type="button" id="btnNewCampoCancha" class="btn btn-primary"><?php echo $this->lang->line('button_create'); ?></button>
						<button type="button" class="btn btn-primary" onclick='window.location="<?php echo base_url('listar-campocanchas'); ?>"'>Regresar</button>

					</div>
				</form>
			</div>
		</div>
	</div>
</div>