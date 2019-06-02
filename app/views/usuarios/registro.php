<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
	<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-5">
			<h2>Crear cuenta</h2>
			<form action="<?=URLROOT?>/usuarios/registro" method="post">
				<div class="form-group">
					<label>Nombre</label>
					<input type="text" class="form-control <?=isset($data['errNombre']) ? 'is-invalid' : ''?>" value="<?=$data['nombre']?>" name="nombre">
					<div class="invalid-feedback"><?=isset($data['errNombre']) ? $data['errNombre'] : ''?></div>
				</div>
				<div class="form-group">
					<label>Apellido</label>
					<input type="text" class="form-control <?=isset($data['errApellido']) ? 'is-invalid' : ''?>" value="<?=$data['apellido']?>" name="apellido">
					<div class="invalid-feedback"><?=isset($data['errApellido']) ? $data['errApellido'] : ''?></div>
				</div>
				<div class="form-group">
					<label>Correo electrónico</label>
					<input type="email" class="form-control <?=isset($data['errCorreo']) ? 'is-invalid' : ''?>" value="<?=$data['correo']?>" name="correo">
					<div class="invalid-feedback"><?=isset($data['errCorreo']) ? $data['errCorreo'] : ''?></div>
				</div>
				<div class="form-group">
					<label>Contraseña</label>
					<input type="password" class="form-control <?=isset($data['errClave']) ? 'is-invalid' : ''?>" value="<?=$data['clave']?>" name="clave">
					<div class="invalid-feedback"><?=isset($data['errClave']) ? $data['errClave'] : ''?></div>
				</div>
				<div class="form-group">
					<label>Vuelve a escribir la contraseña</label>
					<input type="password" class="form-control <?=isset($data['errClaveCon']) ? 'is-invalid' : ''?>" value="<?=$data['claveCon']?>" name="claveCon">
					<div class="invalid-feedback"><?=isset($data['errClaveCon']) ? $data['errClaveCon'] : ''?></div>
				</div>
				<button type="submit" class="btn btn-primary">Crea tu cuenta</button>
			</form>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>