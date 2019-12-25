<?php
if (tieneSesion()) {
	$_SESSION['usuario'] = new Usuario($_SESSION['id']);
	/**
	 * Cerramos sesión si:
	 * - El estado del usuario esta inactivo
	 * - El estado del perfil del usuario esta inactivo
	 */
	$estadoPer = $_SESSION['usuario']->getPerfil()->getEstado();
	$estadoUsu = $_SESSION['usuario']->getEstado();
	if ($estadoPer == Perfil::E_INA || $estadoUsu == Usuario::E_INA) {
		unset($_SESSION['id']);
		session_destroy();
		redirect('usuarios/login');
	}
}