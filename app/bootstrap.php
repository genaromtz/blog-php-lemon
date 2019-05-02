<?php
//Se carga la configuración
require_once 'config/config.php';

//Se cargan librerías
spl_autoload_register(
	function($className) {
		require_once "libraries/{$className}.php";
	}
);