<?php

require_once "IActiveRecord.php";
require_once "PDOWrapper.php";

class Verein implements IActiveRecord {

        private $id;
	private $name;
	private $logo;
	private $adresse;
	private $stadt;
	
	public function __construct($name) {
		$this->name = $name;
	}
	
	public function read() {
		$sql = "SELECT * FROM verein_info WHERE ID = (SELECT ID FROM verein WHERE vereinsname = ':name');";
		$result = PDOWrapper::selectInfo("verein",array("name"=>$this->name));
		$this->logo = $result["logo"];
		$this->adresse = $result["adresse"];
		$this->stadt = $result["stadt"];
	}
	
	public function update() {
		PDOWrapper::update("verein",array("vereinsname"=>$this->name));
		PDOWrapper::updateInfo("verein", array("logo"=>$this->logo, "adresse"=>$this->adresse, "stadt"=>$this->stadt));
	}
	
	public function insert() {
		PDOWrapper::insert("verein",array("vereinsname"=>$this->name));
		PDOWrapper::insertInfo("verein",array("logo"=>$this->logo, "adresse"=>$this->adresse, "stadt"=>$this->stadt));
	}
	public function delete() {
		PDOWrapper::delete("verein",array("vereinsname"=>$this->name));
		PDOWrapper::deleteInfo("verein",array("vereinsname"=>$this->name));
	}
	
	public function setName($name) {
		$this->name = $name;
	}
	
	public function setLogo($logo) {
		$this->logo = $logo;
	}
	
	public function setAdresse($adresse) {
		$this->adresse = $adresse;
	}
	
	public function setStadt($stadt) {
		$this->stadt = $stadt;
	}
}

?>