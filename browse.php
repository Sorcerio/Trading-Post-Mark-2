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

            // // Print previous link
            // if(!($curPage-1 <= 0)) {
            //     $prevNum = $curPage-1;
            // } else {
            //     $prevNum = $curPage;
            // }
            // print '<li><a href="'.$links[$prevNum]['link'].'"><</a></li>';

            // Calculate link bar Offset
            $offset = $curPage-ceil($maxPages/2);
            print $offset;
            if($offset < 0) {
                $offset = 0;
            }

            // Build link bar
            $tick = 1;
            foreach(array_splice($links,$offset,$maxPages) as $link) {
                // Print link
                if($link['page'] == $curPage) {
                    // Current page
                    print '<li><a href="'.$link['link'].'" class="current">'.$link['page'].'</a></li>';
                } else {
                    // Not current page
                    print '<li><a href="'.$link['link'].'">'.$link['page'].'</a></li>';
                }
            }

            // // Print last page link
            // print '<li><a href="'.$links[count($links)].'">'.count($links).'</a></li>';

            // // Print next link
            // if(!($curPage+1 > count($links)) and isset($links[$curPage+1])) {
            //     $nextNum = $curPage+1;
            // } else {
            //     $nextNum = $curPage;
            // }
            // print '<li><a href="'.$links[$nextNum]['link'].'">></a></li>';
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