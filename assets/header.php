<?php
	$phpSelf = htmlentities($_SERVER['PHP_SELF'], ENT_QUOTES, "UTF-8");
	$path_parts = pathinfo($phpSelf);
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
		<a href="browse.php" <?php if($path_parts['filename'] == "browse"){print 'class="active"';} ?>>Browse</a>
		<a href="account.php" <?php if($path_parts['filename'] == "account"){print 'class="active"';} ?>>Account</a>

		<?php print $path_parts; ?>

		<a href="javascript:void(0);" class="icon" onclick="setResponsiveNav()">&#9776;</a>
	</nav>

	<div id="mainContent">