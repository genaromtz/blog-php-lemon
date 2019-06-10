<?php
require_once APPROOT . '/models/Usuario.php';
require_once APPROOT . '/models/Perfil.php';
require_once APPROOT . '/helpers/global.php';
require_once APPROOT . '/models/CsrfToken.php';

class Usuarios extends Controller {

	public function registro() {
		//Verifica sesión
		if (tieneSesion()) redirect('articulos/');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$nombre = filter_input(INPUT_POST, 'nombre');
			$apellido = filter_input(INPUT_POST, 'apellido');
			$correo = filter_input(INPUT_POST, 'correo');
			$clave = filter_input(INPUT_POST, 'clave');
			$claveCon = filter_input(INPUT_POST, 'claveCon');
			$token = filter_input(INPUT_POST, 'token');

			$aData = [
				'nombre' => $nombre,
				'apellido' => $apellido,
				'correo' => $correo,
				'clave' => $clave,
				'claveCon' => $claveCon
			];

			if (CsrfToken::varificaToken($token)) {
				$result = Usuario::creaUsuario($aData);
				if ($result === true) {
					redirect('usuarios/login');
				} else {
					$aData['token'] = CsrfToken::generaToken();
					$aVista = array_merge($aData, $result);
					$this->view('usuarios/registro', $aVista);
				}
			} else {
				$aData['token'] = CsrfToken::generaToken();
				$this->view('usuarios/registro', $aData);
			}
		} else {
			$aData = [
				'nombre' => '',
				'apellido' => '',
				'correo' => '',
				'clave' => '',
				'claveCon' => '',
				'token' => CsrfToken::generaToken()
			];
			$this->view('usuarios/registro', $aData);
		}
	}

	public function login() {
		//Verifica sesión
		if (tieneSesion()) redirect('articulos/');
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$correo = filter_input(INPUT_POST, 'correo');
			$clave = filter_input(INPUT_POST, 'clave');
			$token = filter_input(INPUT_POST, 'token');

			$aData = ['correo' => $correo, 'clave' => $clave];
			if (CsrfToken::varificaToken($token)) {
				$result = Usuario::iniciaSesion($aData);
				if ($result === true) {
					redirect('articulos/');
				} else {
					$aData['token'] = CsrfToken::generaToken();
					$aVista = array_merge($aData, $result);
					$this->view('usuarios/login', $aVista);
				}
			} else {
				$aData['token'] = CsrfToken::generaToken();
				$this->view('usuarios/login', $aVista);
			}
		} else {
			$aData = [
				'correo' => '',
				'clave' => '',
				'token' => CsrfToken::generaToken()
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