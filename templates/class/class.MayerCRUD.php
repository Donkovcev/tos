<?php

class MayerCRUD {

	private $table;
	private $subdivision;
	private $subclass;

	public function __construct($table, $subdivision, $subclass) {
		$this->table = (int) $table;
		$this->subdivision = (int) $subdivision;
		$this->subclass = (int) $subclass;
	}

	public function insert($user, $IP, $fields, $values) {
		$query = "INSERT INTO `Message" . $this->table . "` (`Message_ID`, `User_ID`,`Subdivision_ID`,
       `Sub_Class_ID`, `Priority`, `Keyword`,
       `ncTitle`, `ncKeywords`, `ncDescription`,
       `Checked`, `TimeToDelete`, `TimeToUncheck`,
       `IP`, `UserAgent`, `Parent_Message_ID`,
       `Created`, `LastUpdated`, `LastUser_ID`,
       `LastIP`, `LastUserAgent`";


		if (is_array($fields) && count($fields) > 0) {
			foreach ($fields as $field) {
				$query .= ", `$field`";
			}
		}


		$query .= ") VALUES(
       NULL, $user, " . $this->subdivision . ",
       " . $this->subclass . ", 1, '',
       '', '', '',
       1, NULL, NULL,
       '$IP', '', 0,
       NOW(), NOW(), 0,
       NULL, NULL";


		if (is_array($values) && count($values) > 0) {
			foreach ($values as $value) {
				$query .= ", $value";
			}
		}


		$query .= ");";

		return $query;
	}
	
	public function update() {
	
	}
	
	public function delete() {
	
	}
	

}

?>