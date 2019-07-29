<?php
require_once APPROOT . '/models/Usuario.php';
require_once APPROOT . '/models/Perfil.php';
require_once APPROOT . '/helpers/global.php';

class Perfiles extends Controller {

	public function __construct() {
		if (!tieneSesion()) {
			redirect('usuarios/login');
		}
	}

	public function index() {
		$colPer = Perfil::getPerfiles($_SESSION['usuario']);
		require_once APPROOT . "/views/perfiles/index.php";
	}

	public function nuevo() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$aData = [
				'nombre' => filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'estado' => filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'modUsu' => filter_input(INPUT_POST, 'modUsu', FILTER_VALIDATE_INT),
				'modPer' => filter_input(INPUT_POST, 'modPer', FILTER_VALIDATE_INT),
				'modArt' => filter_input(INPUT_POST, 'modArt', FILTER_VALIDATE_INT)
			];
			$result = Perfil::creaPerfil($_SESSION['usuario'], $aData);
			if ($result !== true) {
				echo json_encode(['tipo' => 2, 'msg' => $result]);
			} else {
				echo json_encode(['tipo' => 1, 'msg' => 'Perfil creado con éxito']);
			}
		} else {
			$this->view('perfiles/nuevo');
		}
	}
}