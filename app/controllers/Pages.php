<?php
class Pages extends Controller {
	public function index() {
		$aData = [
			'titulo' => 'Blog Lemon',
			'description' => 'Simple Blog'
		];
		$this->view('pages/index', $aData);
	}
}