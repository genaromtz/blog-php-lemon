<?php
//Se carga la configuración
require_once 'config/config.php';

//Funciones generales
require_once 'helpers/funciones.php';

//Se cargan librerías
spl_autoload_register(
	function($className) {
		require_once "libraries/{$className}.php";
	}
);