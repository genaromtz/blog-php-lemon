<?php
class Perfil {
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
	 * Permisos
	 */
	const P_SAC = 1; //Sin acceso
	const P_LEC = 2; //Solo lectura
	const P_EDI = 3; //Edición
	/**
	 * Listado de permisos
	 */
	const A_PER = [
		self::P_SAC => 'Sin Acceso',
		self::P_LEC => 'Solo Lectura',
		self::P_EDI => 'Edición'
	];
	/**
	 * Propiedades
	 */
	private $id;
	private $nombre;
	private $estado;
	private $m_usuarios;
	private $m_perfiles;
	private $m_articulos;
	private $id_u_reg;
	private $fh_reg;
	private $id_u_act;
	private $fh_act;
	/**
	 * Getters
	 */
	public function getId() {
		return $this->id;
	}
	public function getNombre() {
		return $this->nombre;
	}
	public function getEstado($mosDes = false) {
		if ($mosDes) {
			return self::A_EST[$this->estado];
		}
		return $this->estado;
	}
	public function getModUsu() {
		return $this->m_usuarios;
	}
	public function getModPer() {
		return $this->m_perfiles;
	}
	public function getModArt() {
		return $this->m_articulos;
	}
	public function getIdUsuReg() {
		return $this->id_u_reg;
	}
	public function getFecReg() {
		return $this->fh_reg;
	}
	public function getIdUsuAct() {
		return $this->id_u_act;
	}
	public function getFecAct() {
		return $this->fh_act;
	}

	/**
	 * Inicia y llena propiedades del objeto perfil
	 * @param integer $id Id perfil
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

	/**
	 * Determina si tiene acceso a un determiando
	 * módulo según el nombre del mismo y permiso
	 * @param string $mod Nombre de módulo
	 * @param string $per Permiso
	 * @return boolean true Tiene permiso
	 * @return boolean true No tiene permiso
	 */
	public function tienePermiso(string $mod, string $per) {
		switch ($mod) {
			case 'm_usuarios':
				$perMod = $this->getModUsu();
				break;
			case 'm_perfiles':
				$perMod = $this->getModPer();
				break;
			case 'm_articulos':
				$perMod = $this->getModArt();
				break;
			default:
				return false;
				break;
		}
		if ($perMod >= $per && $this->getEstado() == self::E_ACT) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Actualiza registro perfil
	 * @param Usuario $_Usuario Usuario en sesión
	 * @param array $aData Campos del formulario
	 * @return boolean true Perfil actualizado
	 * @return array Mensajes de validación
	 */
	public function editaPerfil(Usuario $_Usuario, array $aData) {
		$aErr = $aBD = [];
		$aCamEsp = ['nombre', 'estado', 'modUsu', 'modPer', 'modArt'];
		foreach ($aData as $key => $value) {
			if (in_array($key, $aCamEsp)) {
				$$key = trim($value);
			} else {
				$aErr['errGral'] = "El campo {$key} no es aceptado";
			}
		}
		$perEdi = $_Usuario->getPerfil()->tienePermiso('m_perfiles', self::P_EDI);
		if (!$perEdi) {
			$aErr['errGral'] = 'No tiene permiso para realizar esta acción';
		}
		if ($_Usuario->getId() <= 0) {
			$aErr['errGral'] = 'El usuario no es válido';
		} else {
			$aBD['id_u_act'] = $_Usuario->getId();
		}
		if (empty($nombre)) {
			$aErr['errNombre'] = 'El nombre es requerido';
		} else {
			if (strlen($nombre) > 50) {
				$aErr['errNombre'] = 'El nombre excedió el máximo de caracteres permitidos';
			} else {
				$aFil = ['id' => $this->getId(), 'nombre' => $nombre, 'actUnico' => true];
				$val = self::getPerfiles($_Usuario, $aFil, false);
				if (!empty($val)) {
					$aErr['errNombre'] = 'El nombre ya fue ocupado';
				} else {
					$aBD['nombre'] = $nombre;
				}
			}
		}
		if (empty($estado)) {
			$aErr['errEstado'] = 'El estado es requerido';
		} else {
			if (!array_key_exists($estado, self::A_EST)) {
				$aErr['errEstado'] = 'El estado no es válido';
			}
			$aBD['estado'] = $estado;
		}
		if (empty($modUsu)) {
			$aErr['errModUsu'] = 'El permiso de módulo de usuarios es requerido';
		} else {
			if (!array_key_exists($modUsu, self::A_PER)) {
				$aErr['errModUsu'] = 'El permiso no es válido';
			}
			$aBD['m_usuarios'] = $modUsu;
		}
		if (empty($modPer)) {
			$aErr['errModPer'] = 'El permiso de módulo de perfiles es requerido';
		} else {
			if (!array_key_exists($modPer, self::A_PER)) {
				$aErr['errModPer'] = 'El permiso no es válido';
			}
			$aBD['m_perfiles'] = $modPer;
		}
		if (empty($modArt)) {
			$aErr['errModArt'] = 'El permiso de módulo de artículos es requerido';
		} else {
			if (!array_key_exists($modArt, self::A_PER)) {
				$aErr['errModArt'] = 'El permiso no es válido';
			}
			$aBD['m_articulos'] = $modArt;
		}
		if (empty($aErr)) {
			$_BD = new Database();
			$_BD->query('UPDATE perfiles SET nombre = :nombre, estado = :estado, m_usuarios = :m_usuarios, m_perfiles = :m_perfiles, m_articulos = :m_articulos, id_u_act = :id_u_act WHERE id = :id');
			$_BD->bind(':id', $this->getId());
			$_BD->bind(':nombre', $aBD['nombre']);
			$_BD->bind(':estado', $aBD['estado']);
			$_BD->bind(':m_usuarios', $aBD['m_usuarios']);
			$_BD->bind(':m_perfiles', $aBD['m_perfiles']);
			$_BD->bind(':m_articulos', $aBD['m_articulos']);
			$_BD->bind(':id_u_act', $aBD['id_u_act']);
			return ($_BD->execute()) ? true : false;
		} else {
			return $aErr;
		}
	}

	/**
	 * Crea perfil
	 * @param object $_Usuario Autor del registro
	 * @param array $aData Campos del formulario
	 * @return boolean true Perfil creado con éxito
	 * @return array Mensajes de validación
	 */
	public static function creaPerfil(Usuario $_Usuario, array $aData) {
		$aErr = $aBD = [];
		$aCamEsp = ['nombre', 'estado', 'modUsu', 'modPer', 'modArt'];
		foreach ($aData as $key => $value) {
			if (in_array($key, $aCamEsp)) {
				$$key = trim($value);
			} else {
				$aErr['errGral'] = "El campo {$key} no es aceptado";
			}
		}
		if ($_Usuario->getId() <= 0) {
			$aErr['errGral'] = 'El usuario no es válido';
		} else {
			$aBD['id_u_reg'] = $_Usuario->getId();
			$aBD['id_u_act'] = $_Usuario->getId();
		}
		$perEdi = $_Usuario->getPerfil()->tienePermiso('m_perfiles', self::P_EDI);
		if (!$perEdi) {
			$aErr['errGral'] = 'No tiene permiso para realizar esta acción';
		}
		if (empty($nombre)) {
			$aErr['errNombre'] = 'El nombre es requerido';
		} else {
			if (strlen($nombre) > 50) {
				$aErr['errNombre'] = 'El nombre excedió el máximo de caracteres permitidos';
			} else {
				$val = self::getPerfiles($_Usuario, ['nombre' => $nombre], false);
				if (!empty($val)) {
					$aErr['errNombre'] = 'El nombre ya fue ocupado';
				}
				$aBD['nombre'] = $nombre;
			}
		}
		if (empty($estado)) {
			$aErr['errEstado'] = 'El estado es requerido';
		} else {
			if (!array_key_exists($estado, self::A_EST)) {
				$aErr['errEstado'] = 'El estado no es válido';
			}
			$aBD['estado'] = $estado;
		}
		if (empty($modUsu)) {
			$aErr['errModUsu'] = 'El permiso de módulo de usuarios es requerido';
		} else {
			if (!array_key_exists($modUsu, self::A_PER)) {
				$aErr['errModUsu'] = 'El permiso no es válido';
			}
			$aBD['m_usuarios'] = $modUsu;
		}
		if (empty($modPer)) {
			$aErr['errModPer'] = 'El permiso de módulo de perfiles es requerido';
		} else {
			if (!array_key_exists($modPer, self::A_PER)) {
				$aErr['errModPer'] = 'El permiso no es válido';
			}
			$aBD['m_perfiles'] = $modPer;
		}
		if (empty($modArt)) {
			$aErr['errModArt'] = 'El permiso de módulo de artículos es requerido';
		} else {
			if (!array_key_exists($modArt, self::A_PER)) {
				$aErr['errModArt'] = 'El permiso no es válido';
			}
			$aBD['m_articulos'] = $modArt;
		}
		if (empty($aErr)) {
			$aBD['fh_reg'] = date('Y-m-d H:i:s');
			$_BD = new Database();
			$_BD->query('INSERT INTO perfiles (nombre, estado, m_usuarios, m_perfiles, m_articulos, id_u_reg, fh_reg, id_u_act) VALUES(:nombre, :estado, :m_usuarios, :m_perfiles, :m_articulos, :id_u_reg, :fh_reg, :id_u_act)');
			$_BD->bind(':nombre', $aBD['nombre']);
			$_BD->bind(':estado', $aBD['estado']);
			$_BD->bind(':m_usuarios', $aBD['m_usuarios']);
			$_BD->bind(':m_perfiles', $aBD['m_perfiles']);
			$_BD->bind(':m_articulos', $aBD['m_articulos']);
			$_BD->bind(':id_u_reg', $aBD['id_u_reg']);
			$_BD->bind(':fh_reg', $aBD['fh_reg']);
			$_BD->bind(':id_u_act', $aBD['id_u_act']);
			return ($_BD->execute()) ? true : false;
		} else {
			return $aErr;
		}
	}

	/**
	 * Retorna registros de la tabla perfiles
	 * @param object $aFil Usuario en sesión
	 * @param array $aFil Retorna información en base al filtro
	 * @param array null Retorna toda la información
	 * @param boolean $aObj true Retorna una colección
	 * @param boolean $aObj false Retorna un arreglo
	 * @return array Arreglo o colección
	 */
	public static function getPerfiles(Usuario $_Usuario, array $aFil = null, $aObj = true) {
		$sql = self::sqlPerfiles($_Usuario, $aFil);
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
	private static function sqlPerfiles(Usuario $_Usuario, array $aFil = null) {
		$cond = '';
		if (isset($aFil['id']) && !empty($aFil['id'])) {
			if (isset($aFil['actUnico']) && $aFil['actUnico'] === true) {
				$cond .= " AND id <> {$aFil['id']} ";
			} else {
				$cond .= " AND id = {$aFil['id']} ";
			}
		}
		if (isset($aFil['estado']) && !empty($aFil['estado'])) {
			$cond .= " AND estado = {$aFil['estado']} ";
		}
		if (isset($aFil['nombre']) && !empty($aFil['nombre'])) {
			$cond .= " AND nombre = '{$aFil['nombre']}' ";
		}
		$sql = "SELECT * FROM perfiles WHERE 1 {$cond}";
		return $sql;
	}

	/**
	 * Lee registros e inicia las propiedades del objeto
	 * @return boolean true Caso de éxito
	 * @return boolean false no se encontro el registro
	 */
	private function leeReg() {
		$_BD = new Database();
		$_BD->query('SELECT * FROM perfiles WHERE id = :id');
		$_BD->bind(':id', $this->id);
		$row = $_BD->single();
		if ($_BD->rowCount() > 0) {
			$this->id = $row->id;
			$this->nombre = $row->nombre;
			$this->estado = $row->estado;
			$this->m_usuarios = $row->m_usuarios;
			$this->m_perfiles = $row->m_perfiles;
			$this->m_articulos = $row->m_articulos;
			$this->id_u_reg = $row->id_u_reg;
			$this->fh_reg = $row->fh_reg;
			$this->id_u_act = $row->id_u_act;
			$this->fh_act = $row->fh_act;
			return true;
		} else {
			$this->id = null;
			return false;
		}
	}
}