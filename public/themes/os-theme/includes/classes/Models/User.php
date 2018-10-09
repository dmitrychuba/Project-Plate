<?php

namespace OS\Models;

use \WeDevs\ORM\Eloquent\Model;

class User extends Model {

	/**
	 * Name for table without prefix
	 *
	 * @var string
	 */
	protected $table = 'users';

	protected $primaryKey = 'ID';

	public $timestamps = false;

	public function getTable() {
		if ( isset( $this->table ) ) {
			$prefix = $this->getConnection()->db->prefix;

			return $prefix . $this->table;

		}

		return parent::getTable();
	}

}