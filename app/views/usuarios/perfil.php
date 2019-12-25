<?php require APPROOT . '/views/inc/header.php'; ?>
<div id="appUsuario" class="row">
	<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-3">
			<h2>Actualizar usuario</h2>
			<form @submit.prevent="actPerfil" v-cloak>
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
						<input type="text" class="form-control form-control-sm" name="nombre" value="<?=$_Usuario->getNombre()?>">
						<span v-if="mNombre" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mNombre}}
						</span>
					</div>
					<div class="form-group col-md-6">
						<label>Apellido</label>
						<input type="text" class="form-control form-control-sm" name="apellido" value="<?=$_Usuario->getApellido()?>">
						<span v-if="mApellido" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mApellido}}
						</span>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-6">
						<label>Correo electrónico</label>
						<input type="text" class="form-control form-control-sm" name="correo" value="<?=$_Usuario->getCorreo()?>">
						<span v-if="mCorreo" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mCorreo}}
						</span>
					</div>
				</div>
				<hr>
				<div class="alert alert-primary" role="alert"><i class="fas fa-info-circle"></i> Si no quieres cambiar tu contraseña deja los siguientes campos en blanco</div>
				<div class="form-row">
					<div class="form-group col-md-6">
						<label>Contraseña actual</label>
						<input type="password" class="form-control form-control-sm" name="claveAct">
						<span v-if="mContraAct" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mContraAct}}
						</span>
					</div>
					<div class="form-group col-md-6">
						<label>Nueva contraseña</label>
						<input type="password" class="form-control form-control-sm" name="clave">
						<span v-if="mContra" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mContra}}
						</span>
					</div>
				</div>
				<div class="form-row">
					<div class="form-group col-md-6">
						<label>Vuelve a escribir la nueva contraseña</label>
						<input type="password" class="form-control form-control-sm" name="claveCon">
						<span v-if="mContraCon" class="text-danger">
							<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mContraCon}}
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