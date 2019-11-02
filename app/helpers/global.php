<?php
if (tieneSesion()) {
	$_SESSION['usuario'] = new Usuario($_SESSION['id']);
	//Si el perfil esta inactivo cerramos sesión
	$estado = $_SESSION['usuario']->getPerfil()->getEstado();
	if ($estado == Perfil::E_INA) {
		unset($_SESSION['id']);
		session_destroy();
		redirect('usuarios/login');
	}
}