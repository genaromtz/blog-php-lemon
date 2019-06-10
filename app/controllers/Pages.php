<?php
require_once APPROOT . '/models/Usuario.php';
require_once APPROOT . '/models/Perfil.php';
require_once APPROOT . '/helpers/global.php';

class Pages extends Controller {
	public function index() {
		$aData = [
			'titulo' => 'Blog Lemon',
			'description' => 'Simple Blog'
		];
		$this->view('pages/index', $aData);
	}
}