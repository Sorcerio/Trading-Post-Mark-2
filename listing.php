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
                                print '<img src="'.$image['path'].'" alt="'.$data['title'].' Image '.$tick.'" onerror="this.src = \'images/noImage.png\';" id="Image_'.$tick.'">';
                            } else {
                                // Print image hidden
                                print '<img src="'.$image['path'].'" alt="'.$data['title'].' Image '.$tick.'" onerror="this.src = \'images/noImage.png\';" id="Image_'.$tick.'" style="display: none;">';
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
        <div id="imageControls" <?php if($ready){if(!(count($images) > 1)){print 'style="display: none;"';}} ?>>
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

        <button class="listingButton contactButton" onclick="alert('Button Pressed')">Contact Seller</button>
    </div>
</div>

<!-- Button Control Script -->
<script>
    // Variables
    <?php
        if($ready) {
            print 'var totalImages = '.(count($images)-1).';';
        } else {
            print 'var totalImages = -1';
        }
    ?>
    
    var curImage = 0;

    // Change the currently displayed image
    function changeImage(direction) {
        // Check if images were loaded
        if(totalImages != -1) {
            // Move the current image index
            if(direction == "<") {
                // Previous
                if(curImage == 0) {
                    curImage = totalImages;
                } else {
                    curImage--;
                }
            } else if(direction == ">") {
                // Forward
                if(curImage == totalImages) {
                    curImage = 0;
                } else {
                    curImage++;
                }
            }

            // Loop through and show correct image
            for(var i = 0; i <= totalImages; i++) {
                // Decide if image should be shown
                if(i == curImage) {
                    // It should
                    document.getElementById("Image_"+i).style.display = "initial";
                } else {
                    // It shouldn't
                    document.getElementById("Image_"+i).style.display = "none";
                }
            }
        }
    }
</script>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>