<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class PDOWrapper {
    
    private static $pdo;
    
    private function __construct() {}
    
    private static function getInstance() {
        if(self::$pdo == null) {
            try {
                self::$pdo = new PDO("mysql:dbname=clubadmin;host=127.0.0.1",'clubadmin','clubadmin');
            } catch (Exception $ex) {
                echo "Exception: ".$ex->getMessage();
            }
        }
    }
    
    public static function read($query,$values) {
        self::$pdo->prepare()
    }
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

