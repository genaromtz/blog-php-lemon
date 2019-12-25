<?php
require_once APPROOT . '/models/Usuario.php';
require_once APPROOT . '/models/Perfil.php';
require_once APPROOT . '/helpers/global.php';

class Usuarios extends Controller {

	public function index() {
		if (!tieneSesion()) redirect('usuarios/login'); //Necesita sesión
		$perLec = $_SESSION['usuario']->getPerfil()->tienePermiso('m_usuarios', Perfil::P_LEC);
		$perEdi = $_SESSION['usuario']->getPerfil()->tienePermiso('m_usuarios', Perfil::P_EDI);
		if (!$perLec) redirect('articulos/'); //No tiene permiso lectura
		$colUsu = Usuario::getUsuarios();
		require_once APPROOT . "/views/usuarios/index.php";
	}

	public function editar($id) {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
			$idPerfil = filter_input(INPUT_POST, 'perfil', FILTER_VALIDATE_INT);
			$aData = [
				'nombre' => filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'apellido' => filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'correo' => filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'estado' => filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
			];
			$_Usuario = new Usuario($id);
			$_Perfil = new Perfil($idPerfil);
			if ($_Usuario->getId() <= 0) { //Si el id perfil no existe
				$result = ['errGral' => 'El usuario no es válido'];
			} else {
				$result = $_Usuario->editaUsuario($_SESSION['usuario'], $_Perfil, $aData);
			}
			if ($result !== true) {
				echo json_encode(['tipo' => 2, 'msg' => $result]);
			} else {
				echo json_encode(['tipo' => 1, 'msg' => 'Usuario actualizado con éxito']);
			}
		} else {
			if (!tieneSesion()) redirect('usuarios/login'); //Necesita sesión
			$perLec = $_SESSION['usuario']->getPerfil()->tienePermiso('m_usuarios', Perfil::P_LEC);
			$perEdi = $_SESSION['usuario']->getPerfil()->tienePermiso('m_usuarios', Perfil::P_EDI);
			if (!$perLec) redirect('articulos/'); //No tiene permiso lectura
			$dis = ($perEdi) ? '' : 'disabled';

			if (filter_var($id, FILTER_VALIDATE_INT) <= 0) redirect('articulos/'); //El id tiene que ser integer
			$_Usuario = new Usuario($id);
			if ($_Usuario->getId() <= 0) redirect('articulos/'); //Si el id usuario no existe
			if ($_Usuario->getId() <= 10) $dis = 'disabled'; //10 primeros registros protegidos
			$aPer = Perfil::getPerfiles($_SESSION['usuario'], ['estado' => Perfil::E_ACT], false);
			require_once APPROOT . '/views/usuarios/editar.php';
		}
	}

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
			require_once APPROOT . '/views/usuarios/registro.php';
		}
	}

	public function nuevo() {
		if (!tieneSesion()) redirect('usuarios/login'); //Necesita sesión
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$idPerfil = filter_input(INPUT_POST, 'perfil', FILTER_VALIDATE_INT);
			$aData = [
				'nombre' => filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'apellido' => filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'correo' => filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'clave' => filter_input(INPUT_POST, 'clave', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'claveCon' => filter_input(INPUT_POST, 'claveCon', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
			];
			$_Perfil = new Perfil($idPerfil);
			$result = Usuario::creaUsuario($aData, $_SESSION['usuario'], $_Perfil);
			if ($result !== true) {
				echo json_encode(['tipo' => 2, 'msg' => $result]);
			} else {
				echo json_encode(['tipo' => 1, 'msg' => 'Usuario creado con éxito']);
			}
		} else {
			$perLec = $_SESSION['usuario']->getPerfil()->tienePermiso('m_usuarios', Perfil::P_LEC);
			$perEdi = $_SESSION['usuario']->getPerfil()->tienePermiso('m_usuarios', Perfil::P_EDI);
			if (!$perLec) redirect('articulos/'); //No tiene permiso lectura
			$dis = ($perEdi) ? '' : 'disabled';
			$aPer = Perfil::getPerfiles($_SESSION['usuario'], ['estado' => Perfil::E_ACT], false);
			require_once APPROOT . '/views/usuarios/nuevo.php';
		}
	}

	public function perfil() {
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$aData = [
				'nombre' => filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'apellido' => filter_input(INPUT_POST, 'apellido', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'correo' => filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'claveAct' => filter_input(INPUT_POST, 'claveAct', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'clave' => filter_input(INPUT_POST, 'clave', FILTER_SANITIZE_FULL_SPECIAL_CHARS),
				'claveCon' => filter_input(INPUT_POST, 'claveCon', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
			];
			$_Usuario = $_SESSION['usuario'];
			$result = $_Usuario->editaUsuario(null, null, $aData);
			if ($result !== true) {
				echo json_encode(['tipo' => 2, 'msg' => $result]);
			} else {
				echo json_encode(['tipo' => 1, 'msg' => 'Usuario actualizado con éxito']);
			}
		} else {
			if (!tieneSesion()) redirect('usuarios/login'); //Necesita sesión
			$_Usuario = $_SESSION['usuario'];
			require_once APPROOT . '/views/usuarios/perfil.php';
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
			require_once APPROOT . '/views/usuarios/login.php';
		}
	}

	public function logout() {
		unset($_SESSION['id']);
		session_destroy();
		redirect('usuarios/login');
	}
}