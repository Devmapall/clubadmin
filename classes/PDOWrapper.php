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
				$stmt = $pdo->prepare("INSERT INTO :table (key,value) VALUES (:key, :value);");
				$stmt->execute(array(":table"=>$table."_info", ":key"=>$key, ":value"=>$value));
			}
		} else {
			throw new Exception("PDOWrapper: InsertInfo: second statement is either not an array or an empty one.");
		}
	}
	
	public static function update($table, $id, $keyvalue) {
            if(is_int($key) && is_array($keyvalue)) {
                $pdo = self::getInstance();
                
                foreach($keyvalue as $key=>$val) {
                    $stmt = $pdo->prepare("UPDATE :table SET :key = :val WHERE ID = :primary");
                    $stmt->execute(array(":table"=>$table,":key"=>$key,":val"=>$val,":primary"=>$id));
                }
            } else {
                if(!is_int($key))
                    throw new Exception("PDOWrapper: update: ID is not an integer value");
                
                if(!is_array($keyvalue))
                    throw new Exception("PDOWrapper: update: Keyvalue is not an array");
            }
        }
        
        public static function updateInfo($table, $id, $keyvalue) {
            if(is_int($key) && is_array($keyvalue)) {
                $pdo = self::getInstance();
                
                foreach($keyvalue as $key=>$val) {
                    $stmt = $pdo->prepare("UPDATE :table SET :key = :val WHERE ID = :primary");
                    $stmt->execute(array(":table"=>$table."_info",":key"=>$key,":val"=>$val,":primary"=>$id));
                }
            } else {
                if(!is_int($key))
                    throw new Exception("PDOWrapper: updateInfo: ID is not an integer value");
                
                if(!is_array($keyvalue))
                    throw new Exception("PDOWrapper: updateInfo: Keyvalue is not an array");
            }
        }
        
        public static function delete($table, $id) {
            if(is_int($id)) {
                $pdo = self::getInstance();
                
                $stmt = $pdo->prepare("DELETE FROM :table WHERE ID = :id");
                $stmt->execute(array(":table"=>$table,":id"=>$id));
            }
        }
}

?>