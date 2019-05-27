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
}