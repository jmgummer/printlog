<?php
// This Class Handles DB Queries
class Dbmethods{
	public static function RmDbconnect(){
		$config2 = (object)array(
    		'server'=>'192.168.0.5',
    		//'server'=>'197.248.27.6',
    		'database'=>'reelmedia',
    		'username'=>'root',
    		'password'=>'Pambazuka08',
    		'port'=>'3307'
		);

		$con = new mysqli($config2->server, $config2->username, $config2->password, $config2->database);
		if ($con->connect_error) {
		    die("Connection failed: " . $con->connect_error);
		}else{
			return $con;
		}
	}

	public static function AnvilDbconnect(){
		$config1 = (object)array(
    		'server'=>'192.168.0.4',
    		//'server'=>'197.248.27.6',
    		'database'=>'forgedb',
    		'username'=>'root',
    		'password'=>'Pambazuka08'
		);

		$con = new mysqli($config1->server, $config1->username, $config1->password, $config1->database);
		if ($con->connect_error) {
		    die("Connection failed: " . $con->connect_error);
		}else{
			return $con;
		}
	}

	public static function RPPDbconnect(){
		
		$config6 = (object)array(
    		'server'=>'192.168.0.5',
    		//'server'=>'197.248.27.6',
    		'database'=>'rpp',
    		'username'=>'root',
    		'password'=>'Pambazuka08',
    		'port'=>'3307'
		);

		$con = new mysqli($config6->server, $config6->username, $config6->password, $config6->database);
		if ($con->connect_error) {
		    die("Connection failed: " . $con->connect_error);
		}else{
			return $con;
		}
	}
}