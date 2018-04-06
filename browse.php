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
        header("Location: browse.php?page=1&limit=14");
        ob_end_flush();
        die();
    }
?>

<!-- Content Start -->
<h1 class="jumboHeader">Browse</h1>

<!-- Toolbar -->
<div class="browseToolbar">
    <!-- Search Bar -->
    <form action="browse.php" method="get">
        <input type="hidden" name="page" value="1">
        <input type="hidden" name="limit" <?php print 'value="'.$limit.'"'; ?>>

        <input type="text" placeholder="Search" name="search">
        <button type="submit">Search</button>
    </form>

    <!-- Page Bar -->
    <ol>
        <?php
            // Include get listing code
            include ("actions/getAllListingData.php");

            // Pull the links
            $links = $node->getAllListingLinksPHP($limit);

            // Set Max Pages
            $maxPages = 5;

            // Print Previous Link
            // NOTE: $curPage is begins index with 1, not 0
            if(isset($links[$curPage-2])) {
                $prevNum = $curPage-2;
            } else {
                $prevNum = 0;
            }
            print '<li><a href="'.$links[$prevNum]['link'].'"><</a></li>';

            // Calculate link bar Offset
            $offset = $curPage-ceil($maxPages/2);
            if($offset < 0) {
                $offset = 0;
            }

            // Build link bar
            $tick = 1;
            $splice = $links;
            foreach(array_splice($splice,$offset,$maxPages) as $link) {
                // Print link
                if($link['page'] == $curPage) {
                    // Current page
                    print '<li><a href="'.$link['link'].'" class="current">'.$link['page'].'</a></li>';
                } else {
                    // Not current page
                    print '<li><a href="'.$link['link'].'">'.$link['page'].'</a></li>';
                }
            }

            // Print Next Link
            // NOTE: $curPage is begins index with 1, not 0
            if(isset($links[$curPage])) {
                $nextNum = $curPage;
            } else {
                $nextNum = count($links)-1;
            }
            print '<li><a href="'.$links[$nextNum]['link'].'">></a></li>';
        ?>
    </ol>
</div>

<!-- Displayed Content -->
<div class="listingObjectContainer flexContainer">
    <?php
        // Pull the listings
        $listings = $node->getAllListingDataPHP($curPage,$limit);

        // Include get image from id code
        include ("actions/getImageByListingId.php");

        // Display the contents
        foreach($listings as $listing) {
            // Pull image for listing
            $images = $node->getImageByListingIdPHP($listing['listingID']);

            // Print Listing
            print '<a href="listing.php?id='.$listing['listingID'].'" class="browseListing">';
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
            print '<p><span class="boldText">$'.$listing['price'].'</span>, '.date_format(date_create($listing['date']),"d/m/Y").'</p>';
            print '<p>'.$listing['description'].'</p>';
            print '</div>';
            print '</a>';
        }
    ?>
</div>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>