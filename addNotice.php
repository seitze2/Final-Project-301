<?php

include('config.php');

include('functions.php');

$action = get('action');

$noticeID = get('noticeID');

$postedMessage = null;

if(!empty($noticeID)) 
{
	$sql = file_get_contents('sql/getSpecificNotice.sql');
	$params = array(
		'noticeID' => $noticeID
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$postedMessages = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	$postedMessage = $postedMessages[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	$dateOfNotice = $_POST['dateOfNotice'];
	$message = $_POST['message'];
	
	if($action == 'add') 
	{	
		$sql = file_get_contents('sql/insertNotice.sql');
		$params = array(
			'dateOfNotice' => $dateOfNotice,
			'message' => $message
		);
		$statement = $database->prepare($sql);
		$statement->execute($params);
	}
	elseif ($action == 'edit') 
	{
		$sql = file_get_contents('sql/updateNotice.sql');
        $params = array( 
			'noticeID' => $noticeID,
			'dateOfNotice' => $dateOfNotice,
			'message' => $message
        );
        
        $statement = $database->prepare($sql);
        $statement->execute($params);
	}
	header('location: mainPage.php');
}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Notice</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/addNoticeStyle.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div>
		<header role="banner">
			<h1>Notice</h1>
			<div class="topcorner">
				<p>Currently logged in as: <?php echo $user->getName(); ?> </p>
			</div>
			<div class="topcornerlogout">
				<p><a href="logout.php">Log Out</a></p>
			</div>
		</header>
	
		<ul id="nav">
			<li><a href="mainPage.php" style="color: #000000">Home</a></li>
			<li><a href="employees.php" style="color: #000000">Employees</a></li>
			<li><a href="form.php?action=add" style="color: #000000">Add Employee</a></li>
			<?php if($user->isAdmin() == true) :?>
				<li><a href="addNotice.php?action=add" style="color: #000000">Add Notice</a></li>
			<?php endif ?>
		</ul>
	</div>
	
	<div class="subject">
		<div class="page">
			<form action="" method="POST">
				<div class="form-element">
					<label>Date:</label>
					<input type="text" name="dateOfNotice" class="textbox" value="<?php echo $postedMessage['dateOfNotice']; ?>" />
				</div>
				<div class="form-element">
					<label>Message:</label><h6>Max 255 characters</h6>
					<textarea name="message" rows="15" cols="60"><?php echo $postedMessage['message']; ?></textarea>
				</div>
				<div class="form-element">
					<input type="submit" class="button" />&nbsp;
					<input type="reset" class="button" />
				</div>
			</form>
		</div>
	</div>	
</body>
</html>