<?php

interface ActiveRecord {
	public function read();
	public function insert();
	public function update();
	public function delete();
}

?>