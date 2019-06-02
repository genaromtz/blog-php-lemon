<?php
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