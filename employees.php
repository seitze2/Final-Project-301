<?php

include('config.php');

include('functions.php');

$term = get('search-term');

$employees = searchUsers($term, $database);


$sql = "(SELECT * FROM final_employees JOIN final_paysalaries ON final_employees.employeeID = final_paysalaries.employeeID ";

if(isset ($_POST['apply']))
{
	if(isset($_POST['paygrade']) && isset($_POST['jobposition']))
	{
		$sql .= " WHERE payGrade";
		$clause = "";
		foreach($_POST['paygrade'] as $pays)
		{
			if(!empty($pays))
			{
				$sql .= $clause." LIKE '%{$pays}'";
                $clause = " OR payGrade ";
			}
		}
		
		$sql .= ") UNION ALL (SELECT * FROM final_employees JOIN final_paysalaries ON final_employees.employeeID = final_paysalaries.employeeID ";;
		$clause = " WHERE jobPosition";
		
		foreach($_POST['jobposition'] as $jobs)
		{
			if(!empty($jobs))
			{
				$sql .= $clause." LIKE '%{$jobs}%'";
                $clause = " OR jobPosition ";
			}
		}
		$sql .= ")";
	}
	else
	{
		if(isset($_POST['paygrade']))
		{
			$sql .= " WHERE payGrade";
			$clause = "";
			foreach($_POST['paygrade'] as $pays)
			{
				if(!empty($pays))
				{
					$sql .= $clause." LIKE '%{$pays}'";
					$clause = " OR payGrade ";
				}
			}
			$sql .= ")";
		}
		else if(isset($_POST['jobposition']))
		{
			$sql .= " WHERE jobPosition";
			$clause = "";
			foreach($_POST['jobposition'] as $jobs)
			{
				if(!empty($jobs))
				{
					$sql .= $clause." LIKE '%{$jobs}%'";
					$clause = " OR jobPosition ";
				}
			}
			$sql .= ")";
		}				
	}
	$statement = $database->prepare($sql);
	$statement->execute();
	$employees = $statement->fetchAll(PDO::FETCH_ASSOC);
}


?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
  	<title>Employees</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link rel="stylesheet" href="css/employeeStyle.css">

	<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  	<![endif]-->
</head>
<body>
	<div>
		<header role="banner">
			<h1>Employees</h1>
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
	
		<form method="GET">
			<div class="search">
			<input size="45" type="text" name="search-term" placeholder="Search by name" />
			<input type="submit" />
			</div>
		</form>
			
			<div class="filter">			
					<div class="dropdown">
						<button onclick="myFunction()" class="dropbtn">Filters</button>
							<div id="myDropdown" class="dropdown-content">
								<form action="" method="POST">
									<h4>Pay Grades:</h4>
										<input type="checkbox" name="paygrade[]" value="PG1"> PG1 
										<input type="checkbox" name="paygrade[]" value="PG2"> PG2 
										<input type="checkbox" name="paygrade[]" value="PG3"> PG3 
										<input type="checkbox" name="paygrade[]" value="PG4"> PG4
										<input type="checkbox" name="paygrade[]" value="PG5"> PG5 <br>
										<input type="checkbox" name="paygrade[]" value="PG6"> PG6 
										<input type="checkbox" name="paygrade[]" value="PG7"> PG7 
										<input type="checkbox" name="paygrade[]" value="PG8"> PG8 
										<input type="checkbox" name="paygrade[]" value="PG9"> PG9 
										<input type="checkbox" name="paygrade[]" value="PG10"> PG10 
									<h4>Job Positions: </h4>
										<input type="checkbox" name="jobposition[]" value="Human Resources Associate"> Human Resources Associate<br>
										<input type="checkbox" name="jobposition[]" value="Human Resources Manager"> Human Resources Manager<br>
										<input type="checkbox" name="jobposition[]" value="IT (Team A)"> IT (Team A)<br>
										<input type="checkbox" name="jobposition[]" value="IT (Team B)"> IT (Team B)<br>
										<input type="checkbox" name="jobposition[]" value="IT Team Manager"> IT Team Manager<br>
										<input type="checkbox" name="jobposition[]" value="IT Supervisor"> IT Supervisor<br>
										<input type="checkbox" name="jobposition[]" value="Network Administrator"> Network Administrator<br>
										<input type="checkbox" name="jobposition[]" value="Janitor"> Janitor<br>
									<input type="submit" value="Apply" name="apply">
								</form>
							</div>
					</div>
			</div>
		<?php foreach($employees as $employee) : ?>
			<div class="column">
				<strong>Name:</strong> <?php echo $employee['fullname']; ?><br />
				<strong>Pay Grade: </strong><?php echo $employee['payGrade']; ?> <br />
				<strong>Job Position: </strong><?php echo $employee['jobPosition']; ?> <br />
				<a href="form.php?action=edit&employeeID=<?php echo $employee['employeeID'] ?>">Edit Employee</a><br />
				<a href="employeeProfile.php?employeeID=<?php echo $employee['employeeID'] ?>">View Employee</a>
			</div>
		<?php endforeach; ?>
	</div>
	
	<script>
	function myFunction() 
	{
		document.getElementById("myDropdown").classList.toggle("show");	
	}	
	</script>
</body>
</html>