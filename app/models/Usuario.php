<?php
class Usuario {
	const USUARIO_ACTIVO = 1;

	private $id;
	private $id_perfil;
	private $nombre;
	private $apellido;
	private $correo;
	private $clave;
	private $estado;
	private $imagen;
	private $created_at;
	private $updated_at;

	public static function creaUsuario(array $aData) {
		$aErrores = $aBD = [];
		$aEsperados = ['id_perfil', 'nombre', 'apellido', 'correo', 'clave', 'claveCon'];
		foreach ($aData as $key => $value) {
			if (in_array($key, $aEsperados)) {
				$$key = trim($value);
			} else {
				$aErrores['errDato'] = "El campo {$key} no es aceptado";
			}
		}

		if (empty($nombre)) {
			$aErrores['errNombre'] = 'Ingresa tu nombre';
		} else {
			$aBD['nombre'] = $nombre;
		}

		if (empty($apellido)) {
			$aErrores['errApellido'] = 'Ingresa tu apellido';
		} else {
			$aBD['apellido'] = $apellido;
		}

		if (empty($correo)) {
			$aErrores['errCorreo'] = 'Ingresa tu correo electrónico';
		} else {
			$aBD['correo'] = $correo;
		}

		if (empty($clave)) {
			$aErrores['errClave'] = 'Ingresa una contraseña';
		}

		if (empty($claveCon)) {
			$aErrores['errClaveCon'] = 'Confirma tu contraseña';
		} else {
			if ($clave != $claveCon) {
				$aErrores['errClave'] = 'Las contraseñas no coinciden';
				$aErrores['errClaveCon'] = 'Las contraseñas no coinciden';
			}
		}

		if (empty($aErrores)) {
			$aBD['id_perfil'] = 1;
			$aBD['clave'] = password_hash($clave, PASSWORD_DEFAULT);
			$aBD['created_at'] = date('Y-m-d H:i:s');

			$_BD = new Database();
			$_BD->query('INSERT INTO usuarios (id_perfil, nombre, apellido, correo, clave, created_at) VALUES(:id_perfil, :nombre, :apellido, :correo, :clave, :created_at)');
			$_BD->bind(':id_perfil', $aBD['id_perfil']);
			$_BD->bind(':nombre', $aBD['nombre']);
			$_BD->bind(':apellido', $aBD['apellido']);
			$_BD->bind(':correo', $aBD['correo']);
			$_BD->bind(':clave', $aBD['clave']);
			$_BD->bind(':created_at', $aBD['created_at']);
			return ($_BD->execute()) ? true : false;
		} else {
			return $aErrores;
		}
	}
}