<?php
require_once APPROOT . '/models/Usuario.php';

class Usuarios extends Controller {

	public function registro() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$nombre = filter_input(INPUT_POST, 'nombre');
			$apellido = filter_input(INPUT_POST, 'apellido');
			$correo = filter_input(INPUT_POST, 'correo');
			$clave = filter_input(INPUT_POST, 'clave');
			$claveCon = filter_input(INPUT_POST, 'claveCon');

			$aData = [
				'nombre' => $nombre,
				'apellido' => $apellido,
				'correo' => $correo,
				'clave' => $clave,
				'claveCon' => $claveCon
			];

			$result = Usuario::creaUsuario($aData);
			if ($result === true) {
				redirect('usuarios/registro');
			} else {
				$aVista = array_merge($aData, $result);
				$this->view('usuarios/registro', $aVista);
			}
		} else {
			$aData = [
				'nombre' => '',
				'apellido' => '',
				'correo' => '',
				'clave' => '',
				'claveCon' => ''
			];
			$this->view('usuarios/registro', $aData);
		}
	}

	public function login() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$correo = filter_input(INPUT_POST, 'correo');
			$clave = filter_input(INPUT_POST, 'clave');

			$aData = ['correo' => $correo, 'clave' => $clave];

			$result = Usuario::iniciaSesion($aData);
			if ($result === true) {
				redirect('articulos/');
			} else {
				$aVista = array_merge($aData, $result);
				$this->view('usuarios/login', $aVista);
			}
		} else {
			$aData = [
				'correo' => '',
				'clave' => '',
			];
			$this->view('usuarios/login', $aData);
		}
	}

	public function logout() {
		unset($_SESSION['id']);
		session_destroy();
		redirect('usuarios/login');
	}
}