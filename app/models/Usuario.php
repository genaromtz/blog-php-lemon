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

	//Objeto perfil
	private $_Perfil;

	public function getId() {
		return $this->id;
	}
	public function getIdPerfil() {
		return $this->id_perfil;
	}
	public function getNombre() {
		return $this->nombre;
	}
	public function getApellido() {
		return $this->apellido;
	}
	public function getCorreo() {
		return $this->correo;
	}
	public function getClave() {
		return $this->clave;
	}
	public function getEstado() {
		return $this->estado;
	}
	public function getImagen() {
		return $this->imagen;
	}
	public function getCreatedAt() {
		return $this->created_at;
	}
	public function getUpdatedAt() {
		return $this->updated_at;
	}
	public function getPerfil() {
		if (empty($this->_Perfil)) {
			$this->_Perfil = new Perfil($this->getIdPerfil());
		}
		return $this->_Perfil;
	}

	/**
	 * [Inicia y llena propiedades del objeto usuario]
	 * @param [integer] $id [Id usuario]
	 * @return [boolean] [false no se pudo iniciar el objeto]
	 */
	public function __construct($id) {
		$id = filter_var($id, FILTER_VALIDATE_INT);
		if ($id > 0) {
			$this->id = $id;
			$result = $this->leeRegUsuario();
			if ($result !== true) {
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * [Verifica claves de usuario e inicia la sesión]
	 * @param [string] $correo [description]
	 * @param [string] $clave [description]
	 * @return [array] [Mensajes de validación]
	 * @return [boolean] [true en caso de exito]
	 */
	public static function iniciaSesion(array $aData) {
		$aErrores = [];
		$aEsperados = ['correo', 'clave'];
		foreach ($aData as $key => $value) {
			if (in_array($key, $aEsperados)) {
				$$key = trim($value);
			} else {
				$aErrores['errDato'] = "El campo {$key} no es aceptado";
			}
		}
		if (empty($correo)) {
			$aErrores['errCorreo'] = 'Ingresa tu correo electrónico';
		}
		$result = filter_var($correo, FILTER_VALIDATE_EMAIL);
		if (empty($result)) {
			$aErrores['errCorreo'] = 'Tu correo electrónico no es válido';
		}
		if (empty($clave)) {
			$aErrores['errClave'] = 'Ingresa tu contraseña';
		}
		if (empty($aErrores)) {
			$result = self::correoUnico($correo);
			if (is_numeric($result) && $result > 0) {
				$_Usuario = new self($result);
				$verificaClave = password_verify($clave, $_Usuario->getClave());
				if ($verificaClave === true) {
					if ($_Usuario->getEstado() == self::USUARIO_ACTIVO) {
						$_SESSION['id'] = $_Usuario->getId();
						return true;
					} else {
						$aErrores['errDato'] = 'Su cuenta esta inactiva';
					}
				} else {
					$aErrores['errCorreo'] = 'El correo electrónico y/o contraseña no son válidos';
					$aErrores['errClave'] = 'El correo electrónico y/o contraseña no son válidos';
				}
			} else {
				$aErrores['errCorreo'] = 'El correo electrónico y/o contraseña no son válidos';
				$aErrores['errClave'] = 'El correo electrónico y/o contraseña no son válidos';
			}
		}
		return $aErrores;
	}

	/**
	 * [Crea usuario en e sistema]
	 * @param [array] $aData [Campos del formuario]
	 * @return [boolean] [true caso exitoso]
	 * @return [boolean] [false fallo en la base de datos]
	 * @return array [Mensajes de validación]
	 */
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
			$result = filter_var($correo, FILTER_VALIDATE_EMAIL);
			if (empty($result)) {
				$aErrores['errCorreo'] = 'Tu correo electrónico no es válido';
			} else {
				$result = self::correoUnico($correo);
				if (is_numeric($result) && $result > 0) {
					$aErrores['errCorreo'] = 'El correo ya fue ocupado';
				} else {
					$aBD['correo'] = $correo;
				}
			}
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

	/**
	 * [Determina si existe un correo duplicado]
	 * @param [string] $correo [Correo electrónico]
	 * @return [integer] [id usuario se encontro el correo electrónico]
	 * @return [boolean] [false no se encontro el correo electrónico]
	 */
	private static function correoUnico(string $correo) {
		$_BD = new Database();
		$_BD->query('SELECT id FROM usuarios WHERE correo = :correo');
		$_BD->bind(':correo', $correo);
		$row = $_BD->single();
		if ($_BD->rowCount() > 0) {
			return $row->id;
		} else {
			return false;
		}
	}

	/**
	 * [Lee registros e inicia las propiedades del objeto]
	 * @return [boolean] [true caso de exito]
	 * @return [boolean] [false no se encontro el registro]
	 */
	private function leeRegUsuario() {
		$_BD = new Database();
		$_BD->query('SELECT * FROM usuarios WHERE id = :id');
		$_BD->bind(':id', $this->id);
		$row = $_BD->single();
		if ($_BD->rowCount() > 0) {
			$this->id = $row->id;
			$this->id_perfil = $row->id_perfil;
			$this->nombre = $row->nombre;
			$this->apellido = $row->apellido;
			$this->correo = $row->correo;
			$this->clave = $row->clave;
			$this->estado = $row->estado;
			$this->imagen = $row->imagen;
			$this->created_at = $row->created_at;
			$this->updated_at = $row->updated_at;
			return true;
		} else {
			return false;
		}
	}
}