<?php
class Archivo {
	/**
	 * Propiedades
	 */
	private $id;
	private $id_mod;
	private $modelo;
	private $nombre;
	private $ruta;
	private $id_u_reg;
	private $fh_reg;
	private $id_u_act;
	private $fh_act;
	/**
	 * Objetos
	 */
	private $_UsuReg;
	private $_UsuAct;
	/**
	 * Getters
	 */
	public function getId() {
		return $this->id;
	}
	public function getIdMod() {
		return $this->id_mod;
	}
	public function getModelo() {
		return $this->modelo;
	}
	public function getNombre() {
		return $this->nombre;
	}
	public function getRuta() {
		return $this->ruta;
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
	public function getUsuReg() {
		if (empty($this->_UsuReg)) {
			$this->_UsuReg = new Usuario($this->getIdUsuReg());
		}
		return $this->_UsuReg;
	}
	public function getUsuAct() {
		if (empty($this->_UsuAct)) {
			$this->_UsuAct = new Usuario($this->getIdUsuAct());
		}
		return $this->_UsuAct;
	}

	/**
	 * Inicia y llena propiedades del objeto archivo
	 * @param integer $id Id archivo
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
	 * Lee registros e inicia las propiedades del objeto
	 * @return boolean true Caso de éxito
	 * @return boolean false no se encontro el registro
	 */
	private function leeReg() {
		$_BD = new Database();
		$_BD->query('SELECT * FROM archivos WHERE id = :id');
		$_BD->bind(':id', $this->id);
		$row = $_BD->single();
		if ($_BD->rowCount() > 0) {
			$this->id = $row->id;
			$this->id_mod = $row->id_mod;
			$this->modelo = $row->modelo;
			$this->nombre = $row->nombre;
			$this->ruta = $row->ruta;
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