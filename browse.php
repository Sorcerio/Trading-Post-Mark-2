<!-- Header -->
<?php include ("assets/header.php"); ?>

<?php
    // Check to make sure page and limit parameters are set
    if(isset($_GET['page']) and isset($_GET['limit'])) {
        // They're set
        $curPage = $_GET['page'];
        $limit = $_GET['limit'];
    } else {
        // Not set
        // Redirect to browse.php, but with page and limit parameters
        ob_start();
        header("Location: browse.php?page=1&limit=15");
        ob_end_flush();
        die();
    }
?>

<!-- Content Start -->
<h1 class="jumboHeader">Browse</h1>

<!-- Search Bar -->
<form action="/action_page.php">
    <input type="text" placeholder="Search.." name="search">
    <button type="submit">Search</button>
</form>

<!-- Displayed Content -->
<ul class="listingObjectContainer">
    <?php
        // Include get listing code
        include ("actions/getAllListingData.php");

        // Pull the listings
        $listings = $node->getAllListingDataPHP($curPage,$limit);

        // Display the contents
        foreach($listings as $listing) {
            // Print Listing
            print '<li>';
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
            print '</li>';
        }
    ?>
    <li>It's the start of the thing</li>
</ul>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>