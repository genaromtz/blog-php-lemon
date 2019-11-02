<?php
class Usuario {
	/**
	 * Estados
	 */
	const E_ACT = 1;
	const E_INA = 2;
	/**
	 * Arreglo de estados
	 */
	const A_EST = [
		self::E_ACT => 'Activo',
		self::E_INA => 'Inactivo'
	];
	/**
	 * Propiedades
	 */
	private $id;
	private $id_perfil;
	private $nombre;
	private $apellido;
	private $correo;
	private $clave;
	private $estado;
	private $fh_reg;
	private $fh_act;
	/**
	 * Objetos
	 */
	private $_Perfil;
	/**
	 * Getters
	 */
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
	public function getEstado($mosDes = false) {
		if ($mosDes) {
			return self::A_EST[$this->estado];
		}
		return $this->estado;
	}
	public function getFecReg() {
		return $this->fh_reg;
	}
	public function getFecAct() {
		return $this->fh_act;
	}
	public function getPerfil() {
		if (empty($this->_Perfil)) {
			$this->_Perfil = new Perfil($this->getIdPerfil());
		}
		return $this->_Perfil;
	}

	/**
	 * Inicia y llena propiedades del objeto usuario
	 * @param integer $id Id usuario
	 * @return boolean false No se pudo iniciar el objeto
	 */
	public function __construct($id) {
		$id = filter_var($id, FILTER_VALIDATE_INT);
		if ($id > 0) {
			$this->id = $id;
			$result = $this->leeReg();
			if ($result !== true) {
				return false;
			}
		} else {
			return false;
		}
	}

	public function editaUsuario(Usuario $_Usuario, Perfil $_Perfil, $aData) {
		$aErr = $aBD = [];
		$aCamEsp = ['nombre', 'apellido', 'correo', 'estado', 'clave', 'claveCon'];
		foreach ($aData as $key => $value) {
			if (in_array($key, $aCamEsp)) {
				$$key = trim($value);
			} else {
				$aErr['errGral'] = "El campo {$key} no es aceptado";
			}
		}
		if (empty($nombre)) {
			$aErr['errNombre'] = 'Ingresa el nombre';
		} else {
			if ($this->getNombre() != $nombre) {
				$aBD['nombre'] = $nombre;
			}
		}
		if (empty($apellido)) {
			$aErr['errApellido'] = 'Ingresa el apellido';
		} else {
			if ($this->getApellido() != $apellido) {
				$aBD['apellido'] = $apellido;
			}
		}
		if (empty($correo)) {
			$aErr['errCorreo'] = 'Ingresa el correo electrónico';
		} else {
			if ($this->getCorreo() != $correo) {
				$result = filter_var($correo, FILTER_VALIDATE_EMAIL);
				if (empty($result)) {
					$aErr['errCorreo'] = 'El correo electrónico no es válido';
				} else {
					$aFil = ['id' => $this->getId(), 'correo' => $correo, 'actUnico' => true];
					$result = self::getUsuarios($aFil, false);
					if (!empty($result)) {
						$aErr['errCorreo'] = 'El correo ya fue ocupado';
					} else {
						$aBD['correo'] = $correo;
					}
				}
			}
		}
		if ($_Perfil->getId() <= 0) {
			$aErr['errPerfil'] = 'El perfil no es válido';
		} else {
			if ($this->getIdPerfil() != $_Perfil->getId()) {
				$aBD['id_perfil'] = $_Perfil->getId();
			}
		}
		if (empty($estado)) {
			$aErr['errEstado'] = 'El estado es requerido';
		} else {
			if ($this->getEstado() != $estado) {
				if (!array_key_exists($estado, self::A_EST)) {
					$aErr['errEstado'] = 'El estado no es válido';
				}
				$aBD['estado'] = $estado;
			}
		}
		if (empty($aErr)) {
			return $this->actReg($aBD);
		} else {
			return $aErr;
		}
	}

	/**
	 * Inicia sesión (acceso al sistema)
	 * @param array $aData Campos del formulario
	 * @return boolean true Usuario creado con éxito
	 * @return array Mensajes de validación
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
		} else {
			$result = filter_var($correo, FILTER_VALIDATE_EMAIL);
			if (empty($result)) {
				$aErrores['errCorreo'] = 'Tu correo electrónico no es válido';
			}
		}
		if (empty($clave)) {
			$aErrores['errClave'] = 'Ingresa tu contraseña';
		}
		if (empty($aErrores)) {
			$_Usuario = current(self::getUsuarios(['correo' => $correo]));
			if ($_Usuario instanceof Usuario) {
				$verificaClave = password_verify($clave, $_Usuario->getClave());
				if ($verificaClave === true) {
					if ($_Usuario->getEstado() == self::E_ACT) {
						$_SESSION['id'] = $_Usuario->getId();
						return true;
					} else {
						$aErrores['errGral'] = 'Su cuenta esta inactiva';
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
	 * Crea usuario en el sistema
	 * @param array $aData Campos del formulario
	 * @return boolean true Usuario creado con éxito
	 * @return array Mensajes de validación
	 */
	public static function creaUsuario(array $aData) {
		$aErr = $aBD = [];
		$aCamEsp = ['id_perfil', 'nombre', 'apellido', 'correo', 'clave', 'claveCon'];
		foreach ($aData as $key => $value) {
			if (in_array($key, $aCamEsp)) {
				$$key = trim($value);
			} else {
				$aErr['errDato'] = "El campo {$key} no es aceptado";
			}
		}
		if (empty($nombre)) {
			$aErr['errNombre'] = 'Ingresa tu nombre';
		} else {
			$aBD['nombre'] = $nombre;
		}
		if (empty($apellido)) {
			$aErr['errApellido'] = 'Ingresa tu apellido';
		} else {
			$aBD['apellido'] = $apellido;
		}
		if (empty($correo)) {
			$aErr['errCorreo'] = 'Ingresa tu correo electrónico';
		} else {
			$result = filter_var($correo, FILTER_VALIDATE_EMAIL);
			if (empty($result)) {
				$aErr['errCorreo'] = 'Tu correo electrónico no es válido';
			} else {
				$result = self::getUsuarios(['correo' => $correo], false);
				if (!empty($result)) {
					$aErr['errCorreo'] = 'El correo ya fue ocupado';
				} else {
					$aBD['correo'] = $correo;
				}
			}
		}
		if (empty($clave)) {
			$aErr['errClave'] = 'Ingresa una contraseña';
		}
		if (empty($claveCon)) {
			$aErr['errClaveCon'] = 'Confirma tu contraseña';
		} else {
			if ($clave != $claveCon) {
				$aErr['errClave'] = 'Las contraseñas no coinciden';
				$aErr['errClaveCon'] = 'Las contraseñas no coinciden';
			}
		}
		if (empty($aErr)) {
			$aBD['id_perfil'] = 10;
			$aBD['clave'] = password_hash($clave, PASSWORD_DEFAULT);
			$aBD['fh_reg'] = date('Y-m-d H:i:s');

			$_BD = new Database();
			$_BD->query('INSERT INTO usuarios (id_perfil, nombre, apellido, correo, clave, fh_reg) VALUES(:id_perfil, :nombre, :apellido, :correo, :clave, :fh_reg)');
			$_BD->bind(':id_perfil', $aBD['id_perfil']);
			$_BD->bind(':nombre', $aBD['nombre']);
			$_BD->bind(':apellido', $aBD['apellido']);
			$_BD->bind(':correo', $aBD['correo']);
			$_BD->bind(':clave', $aBD['clave']);
			$_BD->bind(':fh_reg', $aBD['fh_reg']);
			return ($_BD->execute()) ? true : false;
		} else {
			return $aErr;
		}
	}

	/**
	 * Retorna registros de la tabla usuarios
	 * @param array $aFil Retorna información en base al filtro
	 * @param array null Retorna toda la información
	 * @param boolean $aObj true Retorna una colección
	 * @param boolean $aObj false Retorna un arreglo
	 * @return array Arreglo o colección
	 */
	public static function getUsuarios(array $aFil = null, $aObj = true) {
		$sql = self::sqlUsuarios($aFil);
		$_BD = new Database();
		$_BD->query($sql);
		$aDatos = $_BD->resultSet();
		if (!empty($aDatos) && $aObj) {
			$aObjetos = [];
			foreach ($aDatos as $row) {
				$aObjetos[$row->id] = new self($row->id);
			}
			return $aObjetos;
		} else {
			return $aDatos;
		}
	}

	/**
	 * Crea consulta en base al filtro
	 * @param array $aFil Crea consulta en base al filtro
	 * @param array null Crea sulta sin condiciones (retorna todo)
	 * @return string Consulta
	 */
	private static function sqlUsuarios(array $aFil = null) {
		$cond = '';
		if (isset($aFil['id']) && !empty($aFil['id'])) {
			if (isset($aFil['actUnico']) && $aFil['actUnico'] === true) {
				$cond .= " AND id <> {$aFil['id']} ";
			} else {
				$cond .= " AND id = {$aFil['id']} ";
			}
		}
		if (isset($aFil['correo']) && !empty($aFil['correo'])) {
			$cond .= " AND correo = '{$aFil['correo']}' ";
		}
		$sql = "SELECT * FROM usuarios WHERE 1 {$cond}";
		return $sql;
	}

	private function actReg(array $aData) {
		$cond = '';
		if (isset($aData['id_perfil'])) $cond .= "id_perfil = :id_perfil,";
		if (isset($aData['nombre'])) $cond .= "nombre = :nombre,";
		if (isset($aData['apellido'])) $cond .= "apellido = :apellido,";
		if (isset($aData['correo'])) $cond .= "correo = :correo,";
		if (isset($aData['clave'])) $cond .= "clave = :clave,";
		if (isset($aData['estado'])) $cond .= "estado = :estado,";
		if (!empty($cond)) {
			$cond = trim($cond, ','); //Se elimina última coma
			$_BD = new Database();
			$_BD->query("UPDATE usuarios SET {$cond} WHERE id = :id");
			$_BD->bind(':id', $this->getId());
			if (isset($aData['id_perfil'])) $_BD->bind(':id_perfil', $aData['id_perfil']);
			if (isset($aData['nombre'])) $_BD->bind(':nombre', $aData['nombre']);
			if (isset($aData['apellido'])) $_BD->bind(':apellido', $aData['apellido']);
			if (isset($aData['correo'])) $_BD->bind(':correo', $aData['correo']);
			if (isset($aData['clave'])) $_BD->bind(':clave', $aData['clave']);
			if (isset($aData['estado'])) $_BD->bind(':estado', $aData['estado']);
			return ($_BD->execute()) ? true : false;
		}
		return true;
	}

	/**
	 * Lee registros e inicia las propiedades del objeto
	 * @return boolean true Caso de éxito
	 * @return boolean false no se encontro el registro
	 */
	private function leeReg() {
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
			$this->fh_reg = $row->fh_reg;
			$this->fh_act = $row->fh_act;
			return true;
		} else {
			$this->id = null;
			return false;
		}
	}
}