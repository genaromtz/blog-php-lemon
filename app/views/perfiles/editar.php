<?php require APPROOT . '/views/inc/header.php'; ?>
<div id="appPerfil" class="row">
	<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-3">
			<h2>Actualizar perfil</h2>
			<form @submit.prevent="editaPerfil" v-cloak>
				<input type="hidden" name="id" value="<?=$_Perfil->getId()?>">
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
						<input <?=$dis?> type="text" class="form-control form-control-sm" value="<?=$_Perfil->getNombre()?>" name="nombre">
						<span v-if="mNombre" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mNombre}}
						</span>
					</div>
					<div class="form-group col-md-6">
						<label>Estado</label>
						<select <?=$dis?> class="form-control form-control-sm" name="estado">
							<?php foreach (Perfil::A_EST as $key => $value) {
								$sel = ($key == $_Perfil->getEstado()) ? 'selected' : ''; ?>
								<option <?=$sel?> value="<?=$key?>"><?=$value?></option>
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
						<select <?=$dis?> class="form-control form-control-sm" name="modUsu">
							<?php foreach (Perfil::A_PER as $key => $value) {
								$sel = ($key == $_Perfil->getModUsu()) ? 'selected' : ''; ?>
								<option <?=$sel?> value="<?=$key?>"><?=$value?></option>
							<?php } ?>
						</select>
						<span v-if="mModUsu" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mModUsu}}
						</span>
					</div>
					<div class="form-group col-md-6">
						<label>Módulo perfiles</label>
						<select <?=$dis?> class="form-control form-control-sm" name="modPer">
							<?php foreach (Perfil::A_PER as $key => $value) {
								$sel = ($key == $_Perfil->getModPer()) ? 'selected' : ''; ?>
								<option <?=$sel?> value="<?=$key?>"><?=$value?></option>
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
						<select <?=$dis?> class="form-control form-control-sm" name="modArt">
							<?php foreach (Perfil::A_PER as $key => $value) {
								$sel = ($key == $_Perfil->getModArt()) ? 'selected' : ''; ?>
								<option <?=$sel?> value="<?=$key?>"><?=$value?></option>
							<?php } ?>
						</select>
						<span v-if="mModArt" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mModArt}}
						</span>
					</div>
				</div>
				<?php if ($perEdi && $_Perfil->getId() >= 11) { ?>
				<button class="btn btn-primary btn-sm" v-if="procesando"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...
				</button>
				<button type="submit" class="btn btn-primary btn-sm" v-else="procesando" v-on:click="proBtn">Aceptar</button>
				<?php } ?>
			</form>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>