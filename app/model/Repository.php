<?php

namespace GHSS\Model;

use Nette;

/**
 * Description of KurzRepository
 *
 * @author Alexandr Makaric <alexandr@makaric.name>
 */
abstract class Repository extends Nette\Object {

	protected $connection;

	public function __construct(Nette\Database\Context $db) {
		$this->connection = $db;
	}

	/**
	 * 
	 * @return Nette\Database\Table\Selection
	 */
	protected function getTable() {// název tabulky odvodíme z názvu třídy
		preg_match('#(\w+)Repository$#', get_class($this), $m);
		return $this->connection->table($m[1]);
	}

	/**
	 * 
	 * @return Nette\Database\Table\Selection
	 */
	public function findAll() {
		return $this->getTable();
	}

	/**
	 * 
	 * @return Nette\Database\Table\Selection
	 */
	public function findBy(array $by) {
		return $this->getTable()->where($by);
	}

	/**
	 * 
	 * @param int $id
	 * @return \Nette\Database\Table\ActiveRow
	 */
	public function findById($id) {
		return $this->findBy(array('id' => $id))->fetch();
	}

	/**
	 * 
	 * @param type $data
	 * @return \Nette\Database\Table\ActiveRow
	 */
	public function create($data) {
		return $this->getTable()->insert($data);
	}

}
