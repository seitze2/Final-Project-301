<?php

include('config.php');

include('functions.php');

$noticeID = get('noticeID');

$sql = file_get_contents('sql/deleteNotice.sql');
$params = array(
		'noticeID' => $noticeID
	);
$statement = $database->prepare($sql);
$statement->execute($params);


header('location: mainPage.php');
?>