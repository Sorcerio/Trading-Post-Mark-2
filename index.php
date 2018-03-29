<!-- Header -->
<?php include ("assets/header.php"); ?>

<!-- Content Start -->
<h1 class="jumboHeader">Welcome to the Trading Hub</h1>

<!-- Top 5 Items -->
<h2>Recent Additions</h2>
<div class="flexContainer" id="top5Container">
	<?php
		// Load the 5 most recent listings
		// Retrieve data
		include ("actions/getMostRecentListings.php");
		$data = $node->getMostRecentListingsPHP();

		// Print Cards
		foreach($data as $listing) {
			print '<a href="listing.php?id='.$listing['listingId'].'">';
			print '<div class="leftPanel">';
			print '<img src="LISTING_ADDRESS" alt="'.$listing['title'].' Image 1" onerror="this.src = \'images/noImage.png\';">';
			print '</div>';
			print '<div class="rightPanel">';
			print '<h2>'.$listing['title'].'</h2>';
			print '<p>'.$listing['description'].'</p>';
			print '</div>';
			print '</a>';
		}
	?>
</div>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>