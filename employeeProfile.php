<?php

include('config.php');

include('functions.php');

$employeeID = get('employeeID');

$sql = file_get_contents('sql/getEmployee.sql');
$params = array(
	'employeeID' => $employeeID
);
$statement = $database->prepare($sql);
$statement->execute($params);
$employees = $statement->fetchAll(PDO::FETCH_ASSOC);

$employee = $employees[0];
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title><?php echo $employee['fullname']; ?></title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/employeeStyle.css">
</head>
<body>
	<div>
		<header role="banner">
			<h1>Employee Profile</h1>
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
			<h1><?php echo $employee['fullname']; ?> </h1>
			<p>
				<strong>Employee ID: </strong> <?php echo $employee['employeeID']; ?><br />
				<strong>Address: </strong><?php echo $employee['address']; ?><br />
				<strong>City: </strong><?php echo $employee['city']; ?><br />
				<strong>State: </strong><?php echo $employee['stateOfResidence']; ?><br />
				<strong>Zip Code: </strong><?php echo $employee['zipCode']; ?><br />
				<strong>Pay Grade: </strong><?php echo $employee['payGrade']; ?><br />
				<?php if($user->isAdmin() == true) :?>
					<strong>Pay Salary: </strong><?php echo $employee['paySalary']; ?><br />
				<?php endif ?>
				<strong>Job Position: </strong><?php echo $employee['jobPosition']; ?><br />
			</p>
		</div>
	</div>
</body>
</html>