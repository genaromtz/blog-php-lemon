<?php require APPROOT . '/views/inc/header.php'; ?>
<div id="appUsuario" class="row">
	<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-5">
			<h2>Iniciar sesión</h2>
			<form @submit.prevent="iniciaSesion" v-cloak>
				<span v-if="mGral">
					<div class="alert alert-danger" role="alert">
						<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mGral}}
					</div>
				</span>
				<div class="form-group">
					<label>Correo electrónico</label>
					<input type="text" class="form-control form-control-sm" name="correo">
					<span v-if="mCorreo" class="text-danger">
						<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mCorreo}}
					</span>
				</div>
				<div class="form-group">
					<label>Contraseña</label>
					<input type="password" class="form-control form-control-sm" name="clave">
					<span v-if="mContra" class="text-danger">
						<i class="fas fa-exclamation-circle fa-sm mr-1"></i>{{mContra}}
					</span>
				</div>
				<button class="btn btn-primary btn-sm" v-if="procesando"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...
				</button>
				<button type="submit" class="btn btn-primary btn-sm" v-else="procesando" v-on:click="proBtn">Aceptar</button>
			</form>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>