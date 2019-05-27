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
				$this->view('usuarios/registro', $result);
			}
		} else {
			$this->view('usuarios/registro');
		}
	}
}