<?php require APPROOT . '/views/inc/header.php'; ?>
<div id="appPerfil" class="row">
	<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-3">
			<h2>Nuevo perfil</h2>
			<form @submit.prevent="creaPerfil" v-cloak>
				<transition name="fade">
					<span class="text-success u-flexColumnCenter alert alert-success" v-if="success">
						<i class="fas fa-check-circle fa-sm mr-1"></i>{{success}}
					</span>
				</transition>
				<div class="form-row">
					<div class="form-group col-md-6">
						<label>Nombre</label>
						<input type="text" class="form-control form-control-sm" name="nombre">
						<span v-if="mNombre" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mNombre}}
						</span>
					</div>
					<div class="form-group col-md-6">
						<label>Estado</label>
						<select class="form-control form-control-sm" name="estado">
							<?php foreach (Perfil::EST_PFL as $key => $value) { ?>
								<option value="<?=$key?>"><?=$value?></option>
							<?php } ?>
						</select>
						<span v-if="mEstado" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mEstado}}
						</span>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-6">
						<label>Módulo usuarios</label>
						<select class="form-control form-control-sm" name="modUsu">
							<?php foreach (Perfil::A_PER as $key => $value) { ?>
								<option value="<?=$key?>"><?=$value?></option>
							<?php } ?>
						</select>
						<span v-if="mModUsu" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mModUsu}}
						</span>
					</div>
					<div class="form-group col-md-6">
						<label>Módulo perfiles</label>
						<select class="form-control form-control-sm" name="modPer">
							<?php foreach (Perfil::A_PER as $key => $value) { ?>
								<option value="<?=$key?>"><?=$value?></option>
							<?php } ?>
						</select>
						<span v-if="mModPer" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mModPer}}
						</span>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-6">
						<label>Módulo artículos</label>
						<select class="form-control form-control-sm" name="modArt">
							<?php foreach (Perfil::A_PER as $key => $value) { ?>
								<option value="<?=$key?>"><?=$value?></option>
							<?php } ?>
						</select>
						<span v-if="mModArt" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mModArt}}
						</span>
					</div>
				</div>
				<button class="btn btn-primary btn-sm" v-if="procesando"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...
				</button>
				<button type="submit" class="btn btn-primary btn-sm" v-else="procesando" v-on:click="proBtn">Aceptar</button>
			</form>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>