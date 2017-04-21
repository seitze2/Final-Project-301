<?php

include('config.php');

include('functions.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$sql = file_get_contents('sql/attemptLogin.sql');
	$params = array(
		'username' => $username,
		'password' => $password
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$users = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	if(!empty($users)) {
		$user = $users[0];
		
		$_SESSION['userID'] = $user['userID'];
		
		header('location: mainPage.php');
	}
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Login</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/login.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
<body>

  <div class="LoginBox">
	<div class="LoginInputArea">
    <form method="POST">
      <input class="tdField" type="text" name="username" value="" placeholder="Username"></p>
      <input class="tdField" type="password" name="password" value="" placeholder="Password"></p>
      <div class="LoginBtn">
		<button class="action ICEButton" type="submit" name="Log In" value="Log In"><span>Login</span></button>
	  </div>
    </form>
  </div>
</div>

<div class="LoginBoxFade">
</div>


<div align="center"><img src="images/imgBackground.jpg" class="bg"></div>
</body>
</html>