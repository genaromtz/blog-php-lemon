<?php
class Controller {
	/**
	 * [Carga el modelo]
	 * @param  [string] $model [Nombre del modelo]
	 * @return [object] $model [Objeto modelo]
	 */
	public function model($model) {
		require_once "../app/models/{$model}.php";
		return new $model();
	}

	/**
	 * [Carga la vista]
	 * @param [string] $view [Nombre de la vista]
	 * @param [array] $data [Datos del controlador]
	 * @return [Vista html]
	 */
	public function view($view) {
		if (file_exists("../app/views/{$view}.php")) {
			require_once "../app/views/{$view}.php";
		} else {
			die('La vista no existe');
		}
	}
}