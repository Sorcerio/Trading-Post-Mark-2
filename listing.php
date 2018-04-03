<!-- Header -->
<?php include ("assets/header.php"); ?>

<!-- Content Start -->
<?php
    // Attempt to get data
    if(isset($_GET['id'])) {
        // Retrieve listing data
        include ("actions/getListingById.php");
        $data = $node->getListingByIdPHP($_GET['id'])[0];

        // Label data usable
        if(!empty($data)) {
            $ready = true;
        } else {
            $ready = false;
        }
    }
?>

<h1 class="jumboHeader"><?php if($ready){print $data['title'];} ?></h1>
<h2>Posted on: <?php if($ready){print $data['date'];} ?></h2>

<div class="listingPanel flexContainer">
    <div class="leftPanel">
        <!-- <h1 class="loadingText" id="product_loadingText">Loading Images</h1> -->
        <div id="product_image_container">
            <?php
                // Ready check
                if($ready) {
                    // Attempt to retrieve images
                    include ("actions/getImageByListingId.php");
                    $images = $node->getImageByListingId($_GET['id']);

                    // Check for images
                    if(!empty($images)) {
                        // Images are present
                        $tick = 0;
                        foreach($images as $image) {
                            // Check to see if first image
                            if($tick == 0) {
                                // Print image
                                print '<img src="'.$image['path'].'" alt="'.$data['title'].' Image '.$tick.'" onerror="this.src = \'images/noImage.png\';">';
                            } else {
                                // Print image hidden
                                print '<img src="'.$image['path'].'" alt="'.$data['title'].' Image '.$tick.'" onerror="this.src = \'images/noImage.png\';" style="display: none;">';
                            }
                            
                            // Iterate
                            $tick++;
                        }
                    } else {
                        // No images are present
                        print '<img src="images/noImage.png" alt="'.$data['title'].' Placeholder Image">';
                    }
                }
            ?>
        </div>
        <div id="imageControls">
            <button class="imageButton listingButton" onclick="changeImage('<')">Back</button>
            <button class="imageButton listingButton" onclick="changeImage('>')">Next</button>
        </div>
    </div>
    <div class="rightPanel">
        <h3>Price:</h3>
        <p id="product_price">$<?php if($ready){print $data['price'];} ?></p>

        <h3>Quantity:</h3>
        <p id="product_barter"><?php if($ready){print $data['quantity'];} ?></p>

        <h3>Will Barter:</h3>
        <p id="product_quantity">
            <?php 
                if($ready) {
                    if(isset($data['barter'])) {
                        print 'Yes';
                    } else { 
                        print 'No';
                    }
                }
            ?>
        </p>
        
        <h3>Description:</h3>
        <p id="product_description"><?php if($ready){print $data['description'];} ?></p>

        <button class="listingButton contactButton" onclick="">Contact Seller</button>
    </div>
</div>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>