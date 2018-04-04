<!-- Header -->
<?php include ("assets/header.php"); ?>

<!-- Content Start -->
<h1 class="jumboHeader">Welcome to the Trading Hub</h1>

<!-- Top 5 Items -->
<h2>Recent Additions</h2>
<div class="flexContainer listingObjectContainer">
	<?php
		// Load the 5 most recent listings
		// Retrieve listing data
		include ("actions/getMostRecentListings.php");
		$data = $node->getMostRecentListingsPHP();

		// Include image grabber
		include ("actions/getImageByListingId.php");

		// Print Cards
		if(!empty($data)) {
			foreach($data as $listing) {
				// Check for images
				$images = $node->getImageByListingId($listing['listingID']);

				// Print HTML
				print '<a href="listing.php?id='.$listing['listingID'].'">';
				print '<div class="leftPanel">';
				if(empty($images)) {
					// No custom image
					print '<img src="images/noImage.png" alt="'.$listing['title'].' Image 1">';
				} else {
					// Custom image
					print '<img src="'.$images[0]['path'].'" alt="'.$listing['title'].' Image 1" onerror="this.src = \'images/noImage.png\';">';
				}
				print '</div>';
				print '<div class="rightPanel">';
				print '<h2>'.$listing['title'].'</h2>';
				print '<p>'.$listing['description'].'</p>';
				print '</div>';
				print '</a>';
			}
		} else {
			print '<h2>No Recent Products</h2>';
		}

	?>
</div>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>