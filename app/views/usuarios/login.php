<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
	<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-5">
			<h2>Iniciar sesión</h2>
			<form action="<?=URLROOT?>/usuarios/login" method="post">
				<?php if (isset($data['errDato'])) { ?>
					<div class="alert alert-danger" role="alert"><?=$data['errDato']?></div>
				<?php } ?>
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
				<input type="hidden" name="token" value="<?=$data['token']?>">
				<button type="submit" class="btn btn-primary">Inicia sesión</button>
			</form>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>