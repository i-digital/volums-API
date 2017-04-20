<?php
require_once 'API.class.php';
require_once 'Firebase-JWT/src/JWT.php';

use \Firebase\JWT\JWT;

class MyAPI extends API
{
    protected $User;

    public function __construct($request, $origin) {
        parent::__construct($request);

        // Abstracted out for example
        //$APIKey = new Models\APIKey();
        //$User = new Models\User();
		/*
        if (!array_key_exists('apiKey', $this->request)) {
            throw new Exception('No API Key provided');
        } else if (!$APIKey->verifyKey($this->request['apiKey'], $origin)) {
            throw new Exception('Invalid API Key');
        } else if (array_key_exists('token', $this->request) &&
             !$User->get('token', $this->request['token'])) {

            throw new Exception('Invalid User Token');
        }
		*/
		$token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxODA0MTk2OCIsIm5hbWUiOiJBZG1pbiIsImFkbWluIjp0cnVlfQ.yeSVFnyoAPVP2oT94cOkOy6QbODBn-6xSViwD5HN6U0';
		$key = 'blessing';
		$decoded = JWT::decode($token, $key, array('HS256'));
		//echo json_encode( (array) $decoded);

        //$this->User = $User;
    }

    /**
     * Example of an Endpoint
     */
     protected function volunteers() {
        if ($this->method == 'GET') {
            return Volunteer::getList();
        } else {
            return "Only accepts GET requests";
        }
     }

	 protected function volunteer($id) {
		if ($this->method == 'GET') {
            return Volunteer::getById($id);
        } else {
            return "Only accepts GET requests";
        }
	 }
 }

 class Volunteer
 {
	static public function getConnection() {
		// open connection
		$myDb = new mysqli("localhost", "root", "", "mysql");
		if ($myDb->connect_errno) {
			// TODO: Put this in log file
			echo "Failed to connect to MySQL: (" . $myDb->connect_errno . ") " . $myDb->connect_error;
		}
		return $myDb;
	}

	static public function getList() {
		$res = self::getConnection()->query("SELECT 1, 'Test Volunteer 1', 10.4, 'Active' FROM DUAL");
		return $res->fetch_all();
	} 

	static public function getById($id) {
		//$res = self::getConnection()->query("SELECT id, name, total_hours, status FROM Volunteer WHERE id=".$id[0]);
		$res = self::getConnection()->query("SELECT id, name, total_hours, status FROM Volunteer WHERE id=2");
		return $res->fetch_assoc();
	} 
 }
 ?>