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
		$perLec = $_SESSION['usuario']->getPerfil()->tienePermiso('m_perfiles', Perfil::P_LEC);
		$perEdi = $_SESSION['usuario']->getPerfil()->tienePermiso('m_perfiles', Perfil::P_EDI);
		if (!$perLec) redirect('articulos/'); //No tiene permiso lectura
		$colPer = Perfil::getPerfiles($_SESSION['usuario']);
		require_once APPROOT . '/views/perfiles/index.php';
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
			$perLec = $_SESSION['usuario']->getPerfil()->tienePermiso('m_perfiles', Perfil::P_LEC);
			$perEdi = $_SESSION['usuario']->getPerfil()->tienePermiso('m_perfiles', Perfil::P_EDI);
			if (!$perLec) redirect('articulos/'); //No tiene permiso lectura
			$dis = ($perEdi) ? '' : 'disabled';
			require_once APPROOT . '/views/perfiles/nuevo.php';
		}
	}

	public function editar($id) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
			$aData = [
				'nombre' => filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'estado' => filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'modUsu' => filter_input(INPUT_POST, 'modUsu', FILTER_VALIDATE_INT),
				'modPer' => filter_input(INPUT_POST, 'modPer', FILTER_VALIDATE_INT),
				'modArt' => filter_input(INPUT_POST, 'modArt', FILTER_VALIDATE_INT)
			];
			$_Perfil = new Perfil($id);
			if ($_Perfil->getId() <= 0) { //Si el id perfil no existe
				$result = ['errGral' => 'El perfil no es válido'];
			} else {
				$result = $_Perfil->editaPerfil($_SESSION['usuario'], $aData);
			}
			if ($result !== true) {
				echo json_encode(['tipo' => 2, 'msg' => $result]);
			} else {
				echo json_encode(['tipo' => 1, 'msg' => 'Perfil actualizado con éxito']);
			}
		} else {
			$perLec = $_SESSION['usuario']->getPerfil()->tienePermiso('m_perfiles', Perfil::P_LEC);
			$perEdi = $_SESSION['usuario']->getPerfil()->tienePermiso('m_perfiles', Perfil::P_EDI);
			if (!$perLec) redirect('articulos/'); //No tiene permiso lectura
			$dis = ($perEdi) ? '' : 'disabled';

			if (filter_var($id, FILTER_VALIDATE_INT) <= 0) redirect('articulos/'); //El id tiene que ser integer
			$_Perfil = new Perfil($id);
			if ($_Perfil->getId() <= 0) redirect('articulos/'); //Si el id perfil no existe
			if ($_Perfil->getId() <= 10) $dis = 'disabled'; //10 primeros registros protegidos
			require_once APPROOT . '/views/perfiles/editar.php';
		}
	}
}