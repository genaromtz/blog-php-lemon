<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
	<div class="col-md-6 mx-auto">
		<div class="card card-body bg-light mt-5">
			<h2>Crear cuenta</h2>
			<form action="<?=URLROOT?>/usuarios/registro" method="post">
				<div class="form-group">
					<label>Nombre</label>
					<input type="text" class="form-control" name="nombre">
				</div>
				<div class="form-group">
					<label>Apellido</label>
					<input type="text" class="form-control" name="apellido">
				</div>
				<div class="form-group">
					<label for="exampleInputEmail1">Correo electrónico</label>
					<input type="email" class="form-control" name="correo">
				</div>
				<div class="form-group">
					<label>Contraseña</label>
					<input type="password" class="form-control" name="clave">
				</div>
				<div class="form-group">
					<label>Vuelve a escribir la contraseña</label>
					<input type="password" class="form-control" name="claveCon">
				</div>
				<button type="submit" class="btn btn-primary">Crea tu cuenta</button>
			</form>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>