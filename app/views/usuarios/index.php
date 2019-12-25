<?php require APPROOT . '/views/inc/header.php'; ?>

<?php if ($perEdi) { ?>
<div class="container mt-3">
	<div class="row">
		<div class="col-md-3">
			<a href="<?=URLROOT?>/usuarios/nuevo" title="Nuevo usuario" class="btn btn-primary btn-block">Nuevo</a>
		</div>
	</div>
</div>
<?php } ?>

<div class="container mt-3">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4>Catálogo de usuarios</h4>
				</div>
				<table class="table table-striped">
					<thead class="thead-dark">
						<tr>
							<th>Fecha de registro</th>
							<th>Nombre</th>
							<th>Estado</th>
							<th>Acciones</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($colUsu as $_Usuario) { ?>
							<tr>
								<td class="text-wrap"><?=$_Usuario->getFecReg()?></td>
								<td class="text-wrap"><?=$_Usuario->getNombre().' '.$_Usuario->getApellido()?></td>
								<td class="text-wrap"><?=$_Usuario->getEstado(true)?></td>
								<td>
									<a href="<?=URLROOT?>/usuarios/editar/<?=$_Usuario->getId()?>">
										<i class="fa fa-eye"></i>
									</a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>