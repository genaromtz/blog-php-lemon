<?php require APPROOT . '/views/inc/header.php'; ?>

<?php if ($perEdi) { ?>
<div class="container mt-3">
	<div class="row">
		<div class="col-md-3">
			<a href="<?=URLROOT?>/perfiles/nuevo" title="Nuevo perfil" class="btn btn-primary btn-block">Nuevo</a>
		</div>
	</div>
</div>
<?php } ?>

<div class="container mt-3">
	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					<h4>Catálogo de perfiles</h4>
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
						<?php foreach ($colPer as $_Perfil) { ?>
							<tr>
								<td class="text-wrap"><?=$_Perfil->getFecReg()?></td>
								<td class="text-wrap"><?=$_Perfil->getNombre()?></td>
								<td class="text-wrap"><?=$_Perfil->getEstado()?></td>
								<td>
									<a href="<?=URLROOT?>/perfiles/editar/<?=$_Perfil->getId()?>">
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