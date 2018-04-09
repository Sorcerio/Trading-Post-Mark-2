<?php
	// Create Path Parts
	$phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");
	$path_parts = pathinfo($phpSelf);

	// Set debug mode
	$debug = false;
	if(isset($_GET["debug"])) {
		$debug = true;
	}

	// Path Setup
	$domain = "//";
	$server = htmlentities($_SERVER["SERVER_NAME"], ENT_QUOTES, 'UTF-8');
	$domain .= $server;

	// Include Security
	require_once("assets/security.php");

	// Initialize Session
	session_start();

	// Set Session Canary
	if(!isset($_SESSION['canary'])) {
		// // Rehash session id
		// session_regenerate_id(true);

		// Set session initiation time
		$_SESSION['canary'] = time();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Trading Hub</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="author" content="">
    <meta name="description" content="">

	<!--<link rel="icon" type="image/png" href="images/icon.png">-->
	<link rel="stylesheet" type="text/css" href="css/mainStyle.css">
</head>

<body <?php print 'id="'.$path_parts['filename'].'"'?>>
	<!-- Navigation -->
	<nav class="topNav" id="mainTopNav">
		<a href="index.php" <?php if($path_parts['filename'] == "index"){print 'class="active"';} ?>>Home</a>
		<a href="submit.php" <?php if($path_parts['filename'] == "submit"){print 'class="active"';} ?>>Submit</a>
		<a href="browse.php" <?php if($path_parts['filename'] == "browse" or $path_parts['filename'] == "listing"){print 'class="active"';} ?>>Browse</a>
		<a href="login.php" <?php if($path_parts['filename'] == "account" or $path_parts['filename'] == "login"){print 'class="active"';} ?>>Account</a>
		<a href="javascript:void(0);" class="icon" onclick="setResponsiveNav()">&#9776;</a>
	</nav>

	<div id="mainContent">