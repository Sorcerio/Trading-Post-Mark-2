<!-- Header -->
<?php include ("assets/header.php"); ?>

<!-- Content Start -->
<h1>Welcome to the Trading Hub</h1>

<!-- Top 5 Items -->
<div class="flexContainer" id="top5Container">
	<?php
		// Load the 5 most recent listings
		// Set number
		$loadNum = 5;

		// Retrieve data
		//...

		// Print Cards
		print '<a href="listing.php?id=LISTING_ID">';
		print '<div class="leftPanel">';
		print '<img src="LISTING_ADDRESS" alt="LISTING_TITLE Image 1" onerror="this.src = \'images/noImage.png\';">';
		print '</div>';
		print '<div class="rightPanel">';
		print '<h2>LISTING_TITLE</h2>';
		print '<p>LISTING_DESCRIPTION</p>';
		print '</div>';
		print '</a>';
	?>
</div>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>