<?php
require_once APPROOT . '/models/Usuario.php';
require_once APPROOT . '/helpers/global.php';

class Usuarios extends Controller {

	public function registro() {
		if (tieneSesion()) redirect('articulos/'); //Verifica sesión
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$aData = [
				'nombre' => filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'apellido' => filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'correo' => filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'clave' => filter_input(INPUT_POST, 'clave', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'claveCon' => filter_input(INPUT_POST, 'claveCon', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
			];
			$result = Usuario::creaUsuario($aData);
			if ($result !== true) {
				echo json_encode(['tipo' => 2, 'msg' => $result]);
			} else {
				echo json_encode(['tipo' => 1, 'msg' => 'Cuenta creada con éxito']);
			}
		} else {
			$this->view('usuarios/registro');
		}
	}

	public function login() {
		if (tieneSesion()) redirect('articulos/'); //Verifica sesión
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$aData = [
				'correo' => filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'clave' => filter_input(INPUT_POST, 'clave', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
			];
			$result = Usuario::iniciaSesion($aData);
			if ($result !== true) {
				echo json_encode(['tipo' => 2, 'msg' => $result]);
			} else {
				$enlace = URLROOT.'/articulos/';
				echo json_encode(['tipo' => 1, 'msg' => $enlace]);
			}
		} else {
			$this->view('usuarios/login');
		}
	}

	public function logout() {
		unset($_SESSION['id']);
		session_destroy();
		redirect('usuarios/login');
	}
}