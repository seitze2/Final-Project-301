<?php

include('config.php');

include('functions.php');

$action = get('action');

$employeeID = get('employeeID');

$employee = null;

if(!empty($employeeID)) 
{
	$sql = file_get_contents('sql/getEmployee.sql');
	$params = array(
		'employeeID' => $employeeID
	);
	$statement = $database->prepare($sql);
	$statement->execute($params);
	$employees = $statement->fetchAll(PDO::FETCH_ASSOC);
	
	$employee = $employees[0];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
	$employeeID = $_POST['employeeID'];
	$fullname = $_POST['fullname'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$stateOfResidence = $_POST['stateOfResidence'];
	$zipCode = $_POST['zipCode'];
	$payGrade = $_POST['payGrade'];
	$paySalary = $_POST['paySalary'];
	$jobPosition = $_POST['jobPosition'];
	
	if($action == 'add') 
	{
		$sql = file_get_contents('sql/insertEmployee.sql');
		$params = array(
			'employeeID' => $employeeID,
			'fullname' => $fullname,
			'address' => $address,
			'city' => $city,
			'stateOfResidence' => $stateOfResidence,
			'zipCode' => $zipCode,
			'payGrade' => $payGrade,
			'paySalary' => $paySalary,
			'jobPosition' => $jobPosition
		);
	
		$statement = $database->prepare($sql);
		$statement->execute($params);
	}
	
	elseif ($action == 'edit') 
	{
		$sql = file_get_contents('sql/updateEmployee.sql');
        $params = array( 
			'employeeID' => $employeeID,
			'fullname' => $fullname,
			'address' => $address,
			'city' => $city,
			'stateOfResidence' => $stateOfResidence,
			'zipCode' => $zipCode,
			'payGrade' => $payGrade,
			'jobPosition' => $jobPosition
        );
        
        $statement = $database->prepare($sql);
        $statement->execute($params);
		
		$sql = file_get_contents('sql/updateEmployeePay.sql');
        $params = array( 
			'employeeID' => $employeeID,
			'paySalary' => $paySalary
        );
        
        $statement = $database->prepare($sql);
        $statement->execute($params);
		
	}
	header('location: employees.php');
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Manage Employee</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/employeeFormStyle.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div>
		<header role="banner">
			<h1>Manage Employee</h1>
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
				<label>Employee ID:</label>
				<?php if($action == 'add') : ?>
					<input type="text" name="employeeID" class="textbox" value="<?php echo $employee['employeeID'] ?>" />
				<?php else : ?>
					<input readonly type="text" name="employeeID" class="textbox" value="<?php echo $employee['employeeID'] ?>" />
				<?php endif; ?>
			</div>
			<div class="form-element">
				<label>Name:</label>
				<input type="text" name="fullname" class="textbox" value="<?php echo $employee['fullname'] ?>" />
			</div>
			<div class="form-element">
				<label>Address:</label>
					<input type="text" name="address" class="textbox" value="<?php echo $employee['address'] ?>" />
			</div>
			<div class="form-element">
				<label>City:</label>
				<input type="text" name="city" class="textbox" value="<?php echo $employee['city'] ?>" />
			</div>
			<div class="form-element">
				<label>State:</label>
				<input type="text" name="stateOfResidence" class="textbox" value="<?php echo $employee['stateOfResidence'] ?>" />
			</div>
			<div class="form-element">
				<label>Zip Code:</label>
				<input type="text" name="zipCode" class="textbox" value="<?php echo $employee['zipCode'] ?>" />
			</div>
			<div class="form-element">
				<label>Pay Grade:</label>
				<input type="text" name="payGrade" class="textbox" value="<?php echo $employee['payGrade'] ?>" />
			</div>
			<?php if($user->isAdmin() == true) :?>
				<div class="form-element">
					<label>Pay Salary:</label>
					<input type="text" name="paySalary" class="textbox" value="<?php echo $employee['paySalary'] ?>" />
				</div>
			<?php endif ?>
			<div class="form-element">
				<label>Job Position:</label>
				<input type="text" name="jobPosition" class="textbox" value="<?php echo $employee['jobPosition'] ?>" />
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