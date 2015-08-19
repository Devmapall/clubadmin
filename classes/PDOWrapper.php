<?php

class PDOWrapper {

	private static $pdo;
	
	private static function getInstance() {
		if(self::$pdo == null) {
			try {
				self::$pdo = new PDO("mysql:dbname=clubadmin;host=127.0.0.1",'clubadmin','clubadmin');
			} catch(PDOException $e) {
				echo 'PDO Error: ' . $e->getMessage();
			}
		} 
		
		return self::$pdo;
	}

	public static function select($table, $keyvalue) {
		if(is_array($keyvalue) && count($keyvalue) == 2) {
			$pdo = self::getInstance();
			
			$stmt = $pdo->prepare("SELECT * FROM :table WHERE :key = :value");
			$stmt->execute(array(":table"=>$table,":key"=>$keyvalue[0],":value"=>$keyvalue[1]));
			return $stmt->fetchObject();
			
		} else {
			throw new Exception("PDOWrapper: Select: second statement is not an array or is not equal to two entries (key->value)");
		}
	}
	
	public static function selectInfo($table, $keyvalue) {
		if(is_array($keyvalue) && count($keyvalue) == 2) {
			$pdo = self::getInstance();
			
			$stmt = $pdo->prepare("SELECT * FROM :info_table WHERE ID = (SELECT ID FROM :table WHERE :key = :value);");
			$stmt->execute(array(":table"=>$table,":info_table"=>$table."_info",":key"=>$keyvalue[0],":value"=>$keyvalue[1]));
			return $stmt->fetchAll();
		} else {
			throw new Exception("PDOWrapper: SelectInfo: second statement is not an array or is not equal to two entries (key->value)");
		}
	}
	
	public static function insert($table, $keyvalue) {
		if(is_array($keyvalue) && count($keyvalue) == 2) {
			$pdo = self::getInstance();
			
			$stmt = $pdo->prepare("INSERT INTO :table (:key) VALUES (:value);");
			$stmt->execute(array(":table"=>$table, ":key"=>$keyvalue[0], ":value"=>$keyvalue[1]));
			return $pdo->lastInsertId();
		} else {
			throw new Exception("PDOWrapper: Insert: second statement is not an array or is not equal to two entries (key->value)");
		}
	}
	
	public static function insertInfo($table, $id, $keyvalue) {
		if(is_array($keyvalue) && count($keyvalue) > 0) {
			$pdo = self::getInstance();
			
			foreach($keyvalue as $key=>$value) {
				$stmt = $pdo->("INSERT INTO :table (key,value) VALUES (:key, :value);";
				$stmt->execute(array(":table"=>$table."_info", ":key"=>$key, ":value"=>$value));
			}
		} else {
			throw new Exception("PDOWrapper: InsertInfo: second statement is either not an array or an empty one.");
		}
	}
	
	public static function update($table, $
}

?>