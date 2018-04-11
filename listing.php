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
            // Data is usable
            $ready = true;
        } else {
            // Data is not usable
            $ready = false;

            // Redirect
            ob_start();
            header("Location: 404.php");
            ob_end_flush();
            die();
        }
    } else {
        // Redirect to 404
        ob_start();
        header("Location: 404.php");
        ob_end_flush();
        die();
    }

    // Check for Post
    if(isset($_POST['contactSeller'])) {
        // Print info
        print '<div class="centerText">';
        print '<h1>An email to \''.$_POST['sellName'].'\' has been sent on your behalf.</h1>';
        print '<p>If they choose to respond, you will recieve an email at \''.$_POST['buyEmail'].'\' from them.</p>';
        print '</div>';

        // Print footer
        include ("assets/footer.php");

        // Check for response mode
        if($emailMode) {
            // Email Mode
            // Build Message
            $message = "<h1>".$_POST['sellName'].",<h1><br>";
            $message .= "<p>".$_POST['buyName']." would like to contact you about your product named '".$data['title']."'.<br>
                            If you wish to contact them, please send an email to: ".$_POST['buyEmail']."</p>";

            // Send Email
            mail($_POST['sellEmail'],"Trading Post: Contact Request for ".$data['title'],$message);
        } else {
            // Chat Mode
            // TODO: Implement Chat Features
        }

        // Exit
        die();
    }
?>

<h1 class="jumboHeader"><?php if($ready){print $data['title'];} ?></h1>
<h2>Posted on <?php if($ready){print date_format(date_create($data['date']),"d/m/Y");} ?></h2>

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
                            // Decide image binding class
                            $imgData = getimagesize($image['path']); // '0' is Width, '1'is Height
                            if($imgData[0] >= $imgData[1]) {
                                // It's wide
                                $imgType = "wide";
                            } else {
                                // It's tall
                                $imgType = "tall";
                            }

                            // Check to see if first image
                            if($tick == 0) {
                                // Print image
                                print '<img src="'.$image['path'].'" alt="'.$data['title'].' Image '.$tick.'" onerror="this.src = \'images/noImage.png\';" id="Image_'.$tick.'" class="'.$imgType.'">';
                            } else {
                                // Print image hidden
                                print '<img src="'.$image['path'].'" alt="'.$data['title'].' Image '.$tick.'" onerror="this.src = \'images/noImage.png\';" id="Image_'.$tick.'" class="'.$imgType.'" style="display: none;">';
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
                    if($data['barter'] == 1) {
                        print 'Yes';
                    } else { 
                        print 'No';
                    }
                }
            ?>
        </p>
        
        <h3>Description:</h3>
        <p id="product_description"><?php if($ready){print $data['description'];} ?></p>

        <!-- Contact Buttons -->
        <button class="listingButton contactButton" onclick="window.location='login.php';" <?php if(isset($_SESSION['login'])){print 'style="display:none;"';} ?>>Login to Contact Seller</button>
        <form action="<?php print $phpSelf."?id=".$_GET['id']; ?>" method="post" <?php if(!isset($_SESSION['login'])){print 'style="display:none;"';} ?>>
            <?php
                // Get appropriate information for the form
                if(isset($_SESSION['login'])) {
                    // Include account controls
                    include 'actions/accountControls.php';

                    // Get Seller's name and email
                    $sellData = $node->getAccountInfoFromIdPHP($node->getAccountIdByListingIdPHP($_GET['id']));
                    $sellName = $sellData['name'];
                    $sellEmail = $sellData['email'];

                    // Get Buyer's name email
                    $buyData = $node->getAccountInfoFromIdPHP($_SESSION['login']);
                    $buyName = $buyData['name'];
                    $buyEmail = $buyData['email'];
                }
            ?>

            <input type="hidden" name="sellName" value="<?php print $sellName; ?>">
            <input type="hidden" name="sellEmail" value="<?php print $sellEmail; ?>">
            <input type="hidden" name="buyName" value="<?php print $buyName; ?>">
            <input type="hidden" name="buyEmail" value="<?php print $buyEmail; ?>">
            <input type="submit" value="Contact Seller" id="contactSeller" name="contactSeller">
        </form>
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