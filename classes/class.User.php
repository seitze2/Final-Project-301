<?php

class User
{
	private $userName;
	private $userID;
	private $database; 
	private $isAdmin;
	
	function __construct($userID, $database)
	{
	
		$sql = file_get_contents('sql/getUser.sql');
		$params = array(
			'userID' => $userID
		);
		$statement = $database->prepare($sql);
		$statement->execute($params);
		$users = $statement->fetchAll(PDO::FETCH_ASSOC);
		$user = $users[0];
		
		$this->userID = $user['userID'];
		$this->userName = $user['name'];
		$this->isAdmin = $user['isAdmin'];
		$this->database = $database;
	}
	
	function getName()
	{
		return $this->userName; 
	}
	
	function isAdmin()
	{
		return $this->isAdmin;
	}
	
	
	
}

?>