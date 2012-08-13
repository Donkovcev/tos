<?php

abstract class LEASE_base {

	public $user_info = array();

	public abstract function select();

	public abstract function insert();

	public abstract function delete();

	public abstract function update();

	public function getUserInfo() {
		$this->user_info['IP'] = $_SERVER['REMOTE_ADDRESS'];
		$this->user_info['Agent'] = $_SERVER['HTTP_USER_AGENT'];
	}

}

class LEASE extends LEASE_base {

	CONST table_id = 227;

	private $lease_specification_id;

	public function __construct($lease_specification_id) {
		$this->lease_specification_id = (int) $lease_specification_id;
	}

	public function select() {

	}

	public function insert() {

	}

	public function delete() {

	}

	public function update() {

	}

}

class LEASE_specification extends LEASE_base {

	CONST table_id = 226;

	public function __construct() {

	}

	public function select() {

	}

	public function insert() {

	}

	public function delete() {

	}

	public function update() {

	}

}

class LEASE_revenue extends LEASE_base {

	CONST table_id = 229;

	private $LEASE_ID;

	public function __construct($LEASE_ID) {
		$this->LEASE_ID = $LEASE_ID;
	}

	public function select() {

	}

	public function insert() {

	}

	public function delete() {

	}

	public function update() {

	}

}

class LEASE_expense extends LEASE_base {

	CONST table_id = 230;

	private $LEASE_ID;

	public function __construct($LEASE_ID) {
		$this->LEASE_ID = $LEASE_ID;
	}

	public function select() {
		//self::table_id
	}

	public function insert() {
		global $AUTH_USER_ID;

		$item = new MayerCRUD(self::table_id, 350, 357);

		$fields = array('leas_id', 'account_number', 'account_name', 'expense');
		$values = array(1, 1, 'Dmitriy', 200);

		$query = $item->insert($AUTH_USER_ID, $_SERVER['REMOTE_ADDR'], $fields, $values);

		echo $query;
	}

	public function delete() {
		$query = "DELETE FROM Message" . self::table_id . " WHERE Message_ID = ";
	}

	public function update() {

	}

}

?>