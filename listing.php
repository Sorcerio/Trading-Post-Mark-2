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

<div>
    <div>
        <h1 class="loadingText" id="product_loadingText">Loading Images</h1>
        <div id="product_image_container">
            <img src="images/noImage.png" alt="TITLE_OF_CONTENT" id="product_image_DEFAULT">
            
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
                            // Print image
                            print '<img src="'.$image['path'].'" alt="'.$data['title'].' Image 1" onerror="this.src = \'images/noImage.png\';">';

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
            <button class="buyPage_Button" onclick="changeImage('<')">Back</button>
            <button class="buyPage_Button" onclick="changeImage('>')">Next</button>
        </div>
    </div>
    <div>
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
    </div>

    <button class="buyPage_Button" onclick="">Contact Seller</button>
</div>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>