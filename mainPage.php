<?php

include('config.php');

include('functions.php');

$sql = file_get_contents('sql/getNotice.sql');

$statement = $database->prepare($sql);
$statement->execute();
$notices = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Human Resources Homepage</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/mainPageStyle.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div>
		<header role="banner">
			<h1>Welcome to the Human Resources Homepage! </h1>
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
		<h2>Notices from Administration: </h2>
		
		<?php foreach($notices as $notice) : ?>
		<h4>Notice <?php echo $notice['dateOfNotice'];?>: </h4>
		<p><span id="tab">
			<?php echo $notice['message']; ?>
		</span></p>
		<?php if($user->isAdmin() == true) :?>
			<a href="addNotice.php?action=edit&noticeID=<?php echo $notice['noticeID'] ?>">Edit Notice</a><br />
			<a href="removeNotice.php?noticeID=<?php echo $notice['noticeID'] ?>">Remove Notice</a><br />
		<?php endif ?>
		<?php endforeach ?>
	</div>
</body>
</html>