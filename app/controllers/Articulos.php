<?php
require_once APPROOT . '/models/Usuario.php';
require_once APPROOT . '/models/Perfil.php';
require_once APPROOT . '/helpers/global.php';

class Articulos extends Controller {
	public function __construct() {
		if (!tieneSesion()) {
			redirect('usuarios/login');
		}
	}

	public function index() {
		$this->view('articulos/index');
	}
}