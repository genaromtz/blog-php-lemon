<?php
class Perfil {
	/**
	 * Permisos del sistema
	 */
	const PERMISO_ACTIVO = 1;
	const PERMISO_SIN_ACCESO = 0;
	const PERMISO_SOLO_LECTURA = 1;
	const PERMISO_EDICION = 2;

	/**
	 * Listado de permisos
	 */
	const A_PERMISOS = [
		self::PERMISO_SIN_ACCESO => 'Sin Acceso',
		self::PERMISO_SOLO_LECTURA => 'Solo Lectura',
		self::PERMISO_EDICION => 'Edición'
	];

	private $id;
	private $nombre;
	private $estado;
	private $m_usuarios;
	private $created_at;
	private $updated_at;

	public function getId() {
		return $this->id;
	}
	public function getNombre() {
		return $this->nombre;
	}
	public function getEstado() {
		return $this->estado;
	}
	public function getModUsuarios() {
		return $this->m_usuarios;
	}
	public function getCreatedAt() {
		return $this->created_at;
	}
	public function getUpdatedAt() {
		return $this->updated_at;
	}

	/**
	 * [Inicia y llena propiedades del objeto perfil]
	 * @param [integer] $id [Id perfil]
	 * @return [boolean] [false no se pudo iniciar el objeto]
	 */
	public function __construct($id) {
		$id = filter_var($id, FILTER_VALIDATE_INT);
		if ($id > 0) {
			$this->id = $id;
			$result = $this->leeRegPerfil();
			if ($result !== true) {
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * [Lee registros e inicia las propiedades del objeto]
	 * @return [boolean] [true caso de exito]
	 * @return [boolean] [false no se encontro el registro]
	 */
	private function leeRegPerfil() {
		$_BD = new Database();
		$_BD->query('SELECT * FROM perfiles WHERE id = :id');
		$_BD->bind(':id', $this->id);
		$row = $_BD->single();
		if ($_BD->rowCount() > 0) {
			$this->id = $row->id;
			$this->nombre = $row->nombre;
			$this->estado = $row->estado;
			$this->m_usuarios = $row->m_usuarios;
			$this->created_at = $row->created_at;
			$this->updated_at = $row->updated_at;
			return true;
		} else {
			return false;
		}
	}
}