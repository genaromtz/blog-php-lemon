<?php require APPROOT . '/views/inc/header.php'; ?>
<div id="appUsuario" class="row">
	<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-3">
			<h2>Actualizar usuario</h2>
			<form @submit.prevent="editaUsuario" v-cloak>
				<input type="hidden" name="id" value="<?=$_Usuario->getId()?>">
				<transition name="fade">
					<span class="text-success u-flexColumnCenter alert alert-success" v-if="success">
						<i class="fas fa-check-circle fa-sm mr-1"></i>{{success}}
					</span>
				</transition>
				<span v-if="mGral">
					<div class="alert alert-danger" role="alert">
						<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mGral}}
					</div>
				</span>
				<div class="form-row">
					<div class="form-group col-md-6">
						<label>Nombre</label>
						<input <?=$dis?> type="text" class="form-control form-control-sm" name="nombre" value="<?=$_Usuario->getNombre()?>">
						<span v-if="mNombre" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mNombre}}
						</span>
					</div>
					<div class="form-group col-md-6">
						<label>Apellido</label>
						<input <?=$dis?> type="text" class="form-control form-control-sm" name="apellido" value="<?=$_Usuario->getApellido()?>">
						<span v-if="mApellido" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mApellido}}
						</span>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-12">
						<label>Correo electrónico</label>
						<input <?=$dis?> type="text" class="form-control form-control-sm" name="correo" value="<?=$_Usuario->getCorreo()?>">
						<span v-if="mCorreo" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mCorreo}}
						</span>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-6">
						<label>Perfil</label>
						<select <?=$dis?> class="form-control form-control-sm" name="perfil">
							<?php foreach ($aPer as $key => $_Perfil) {
								$sel = ($key == $_Usuario->getPerfil()->getId()) ? 'selected' : ''; ?>
								<option <?=$sel?> value="<?=$_Perfil->getId()?>"><?=$_Perfil->getNombre()?></option>
							<?php } ?>
						</select>
						<span v-if="mPerfil" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mPerfil}}
						</span>
					</div>
					<div class="form-group col-md-6">
						<label>Estado</label>
						<select <?=$dis?> class="form-control form-control-sm" name="estado">
							<?php foreach (Usuario::A_EST as $key => $value) {
								$sel = ($key == $_Usuario->getEstado()) ? 'selected' : ''; ?>
								<option <?=$sel?> value="<?=$key?>"><?=$value?></option>
							<?php } ?>
						</select>
						<span v-if="mEstado" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mEstado}}
						</span>
					</div>
				</div>
				<?php if ($perEdi && $_Usuario->getId() >= 11) { ?>
				<button class="btn btn-primary btn-sm" v-if="procesando"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...
				</button>
				<button type="submit" class="btn btn-primary btn-sm" v-else="procesando" v-on:click="proBtn">Aceptar</button>
				<?php } ?>
			</form>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>