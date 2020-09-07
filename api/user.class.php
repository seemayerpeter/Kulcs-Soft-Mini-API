<?php
class User
{
	//Attributes
	private $userId;
	private $db;
	public $incomingApiKey = '';
	public $action = '';
	function __construct($action = '',$userId = '',$apiKey = '')
	{
		# Construct the class and set the values in the attributes.
		$this->db = new SQLite3('users.db');
		$this->userId = $userId;
		$this->action = $action;
		$this->incomingApiKey = $apiKey;
	}

	function verifyMethod(){
		if (self::verifyApiKey()){
			switch ($this->action) {
				case 'GET':
					# When the method is GET, returns the user
					return self::doGet();
					break;
				case 'DELETE':
					# When the method is DELETE, deletes an existing user.
					return self::doDelete(); 
					break;		
				default:
					# Not allowed
					return array('status' => 0);
					break;
			}
		} else {
			return array('status' => 0);
		}
	}

	function doGet(){
		//GET method
		$sql = 'SELECT * FROM users WHERE userId = :id';
		$stmt = $this->db->prepare($sql);
	    $stmt->bindValue(":id", $this->userId);
	    $result = $stmt->execute();

		$row  = $result->fetchArray(1);
		if ($row == false){
			$arr = array('status' => 0);
		} else {
			$arr = array('ActionType' => $this->action, 'status' => 1, 'user' => $row);
		}

		
		return $arr;
	}

	function doDelete(){
		//DELETE method
		$sql = 'DELETE FROM users WHERE userId = :id';
	    $stmt = $this->db->prepare($sql);
	    $stmt->bindValue(":id", $this->userId);
		$stmt->execute()->finalize();
		if ($this->db->changes() === 1){
			$arr = array('ActionType' => $this->action, 'status' => 1);
		} else {
			$arr = array('status' => 0);
		}
		
		return $arr;
	}

	function verifyApiKey(){
		return "e3ecc8f0-6d44-4fd1-ad4d-0ee0817e2027" === $this->incomingApiKey;
	}
}
?>