<!-- Header -->
<?php include ("assets/header.php"); ?>

<!-- Content Start -->
<?php
    // Include the validation functions
    include "assets/validationFunctions.php";

    // Security
    $thisURL = $domain.$phpSelf;

    // Forum Variables
    $errorText = "";
    $title = $errorText;
    $desc = $errorText;
    $quantity = $errorText;
    $price = $errorText;
    $barter = false;
    $terms = false;
    $image1 = "";
    $image2 = "";
    $image3 = "";

    // Forum Error Flags
    $title_Error = false;
    $desc_Error = false;
    $quantity_Error = false;
    $price_Error = false;
    $barter_Error = false;
    $terms_Error = false;
    $image1_Error = false;
    $image2_Error = false;
    $image3_Error = false;

    // Misc Variables
    // $mailed = false;
    $errorMsg = array();
    $dataRecord = array();

    // Process Submitted Form
    if(isset($_POST["submit"])) {
        // // Check security
        // if(!securityCheck($thisURL)) {
        //     // Failed security
        //     // TODO: Log to Database infraction w/ user info

        //     // Inform user they're bad people
        //     $out = "<h1>You do not have permission for this page.</h1>";
        //     die($out);
        // }

        // Sanitize inputs
        // Sanitize text inputs
        $title = htmlentities($_POST["title"], ENT_QUOTES, "UTF-8");
        $desc = htmlentities($_POST["description"], ENT_QUOTES, "UTF-8");
        $quantity = htmlentities($_POST["quantity"], ENT_QUOTES, "UTF-8");
        $price = htmlentities($_POST["price"], ENT_QUOTES, "UTF-8");

        // Sanitize check box inputs
        if(isset($_POST["barter"])) {
            $barter = true;
        }

        if(isset($_POST["terms"])) {
            $terms = true;
        }

        // Build Images

        print_r($_FILES);

        $imgDirectory = "uploads/images/";
        if($_FILES['image1']['error'] == 0) {
            // Set target image
            $image1 = $imgDirectory.basename($_FILES['image1']['name']);
        }

        if($_FILES['image2']['error'] == 0) {
            // Set target image
            $image1 = $imgDirectory.basename($_FILES['image1']['name']);
        }

        if($_FILES['image3']['error'] == 0) {
            // Set target image
            $image1 = $imgDirectory.basename($_FILES['image1']['name']);
        }
        

        // Add data to record
        $dataRecord[] = $title;
        $dataRecord[] = $desc;
        $dataRecord[] = $quantity;
        $dataRecord[] = $price;
        $dataRecord[] = $barter;
        $dataRecord[] = $terms;
        $dataRecord[] = $image1;
        $dataRecord[] = $image2;
        $dataRecord[] = $image3;

        // Validate user input
        if($title == "") {
            $errorMsg[] = "Please enter a title.";
            $title_Error = true;
        }

        if($desc == "") {
            $errorMsg[] = "Please enter a description.";
            $desc_Error = true;
        }

        if($quantity == "") {
            $errorMsg[] = "Please enter a quantity.";
            $quantity_Error = true;
        } else if(intval($quantity) <= 0) {
            $errorMsg[] = "Your quantity must be at least 1.".$quantity;
            $quantity_Error = true;
        }

        if($price == "") {
            $errorMsg[] = "Please enter a price.";
            $price_Error = true;
        } else if(intval($price) < 0) {
            $errorMsg[] = "Your price cannot be negative.";
            $price_Error = true;
        }

        if($terms == false) {
            $errorMsg[] = "Please agree to the terms or discontinue use.";
            $terms_Error = true;
        }

        // Validate Images
        // Check image size to see if it's a fake image
        if(getimagesize($_FILES['image1']['tmp_name']) == false) {
            $errorMsg[] = "Image 1 appears to not be a real image.";
            $image1_Error = true;

            // TODO: Log infraction as fake images could be disguised runtimes
        }

        if(getimagesize($_FILES['image2']['tmp_name']) == false) {
            $errorMsg[] = "Image 2 appears to not be a real image.";
            $image2_Error = true;

            // TODO: Log infraction as fake images could be disguised runtimes
        }

        if(getimagesize($_FILES['image3']['tmp_name']) == false) {
            $errorMsg[] = "Image 3 appears to not be a real image.";
            $image3_Error = true;

            // TODO: Log infraction as fake images could be disguised runtimes
        }

        // Check if file exists
        if(file_exists($image1)) {
            // TODO: Rename the image with time code appended
        }

        if(file_exists($image2)) {
            // TODO: Rename the image with time code appended
        }

        if(file_exists($image3)) {
            // TODO: Rename the image with time code appended
        }

        // Check file size
        $maxUploadSize = 3*1024;
        if ($_FILES['image1']['size'] > $maxUploadSize) {
            $errorMsg[] = "Image 1 is greater than 3 MBs.";
            $image1_Error = true;
        }

        if ($_FILES['image2']['size'] > $maxUploadSize) {
            $errorMsg[] = "Image 2 is greater than 3 MBs.";
            $image2_Error = true;
        }

        if ($_FILES['image3']['size'] > $maxUploadSize) {
            $errorMsg[] = "Image 3 is greater than 3 MBs.";
            $image3_Error = true;
        }

        // Check file type
        $image1_type = strtolower(pathinfo($image1,PATHINFO_EXTENSION));
        if($image1_type != "jpg" && $image1_type != "png" && $image1_type != "jpeg"&& $image1_type != "gif") {
            $errorMsg[] = "Image 1 is not the correct file type.";
            $image1_Error = true;
        }

        $image2_type = strtolower(pathinfo($image2,PATHINFO_EXTENSION));
        if($image2_type != "jpg" && $image2_type != "png" && $image2_type != "jpeg"&& $image2_type != "gif") {
            $errorMsg[] = "Image 1 is not the correct file type.";
            $image2_Error = true;
        }

        $image3_type = strtolower(pathinfo($image3,PATHINFO_EXTENSION));
        if($image3_type != "jpg" && $image3_type != "png" && $image3_type != "jpeg"&& $image3_type != "gif") {
            $errorMsg[] = "Image 1 is not the correct file type.";
            $image3_Error = true;
        }

        // Forum Processing
        if(!$errorMsg) {
            // Forum passed validation
            if($debug) {
                print "<h3>Forum passed validation</h3><p>";
                print_r($dataRecord);
                print "</p>";
            }
        }
    }

    // Move images to uploads file
    if(empty($errorMsg)) {
        if($image1 != "") {
            if(!move_uploaded_file($_FILES['image1']['tmp_name'], $image1)) {
                $errorMsg[] = "Image 1's upload encountered an error. Please try again.";
                $image1_Error = true;
            }
        }

        if($image2 != "") {
            if(!move_uploaded_file($_FILES['image2']['tmp_name'], $image2)) {
                $errorMsg[] = "Image 2's upload encountered an error. Please try again.";
                $image2_Error = true;
            }
        }

        if($image3 != "") {
            if(!move_uploaded_file($_FILES['image3']['tmp_name'], $image3)) {
                $errorMsg[] = "Image 3's upload encountered an error. Please try again.";
                $image3_Error = true;
            }
        }
    }

    // Final check of submission validation
    if(isset($_POST['submit']) and empty($errorMsg)) {
        // Get Account ID
        // TODO: GET ACCOUNT ID
        $accId = 0;

        // Import listing creator
        include ("actions/createListing.php");

        // Submit data to database
        $listingId = $node->createNewListingPHP($title,$desc,$quantity,$price,$barter,$accId);

        // Add images to database
        // ...

        // Display submit header
        print '<h1 class="jumboHeader">Thanks for your Listing</h1>';
        print '<p class="jumboSubtitle">Your listing of \''.$title.'\' has been published <a href="listing.php?id='.$listingId.'" id="productPageLink">here</a>.</p>';

    } else {
        // Display standard header
        print '<h1 class="jumboHeader">Submit Listing to the Trading Hub</h1>';

        // Display Error Messages if present
        if($errorMsg) {
            // Print top of div
            print '<div class="forumErrors">';
            print '<h3>Forum Validation Failed</h3>';
            
            // Print all errors
            foreach($errorMsg as $e) {
                print '<p>'.$e.'</p>';
            }

            // Print end of div
            print '</div>';
        }

    // 'ELSE' closed below to encompass form HTML
?>

<form action="<?php print $phpSelf; ?>" method="post" enctype="multipart/form-data">
    <div>
        <div>
            <h3 class="instruction">Title of your Listing:</h3>
            <p class="details">Something that quickly describes your listing.</p>
            <input type="text" name="title" placeholder="Title" <?php if($debug){print 'value="DEBUG_MODE_TITLE"';} print 'value='.$title; ?>>
        </div>

        <div>
            <h3 class="instruction">Description of your Listing</h3>
            <p class="details">A more descriptive blob of text about your listing with details like condition or size.</p>
            <textarea name="description" placeholder="Description"><?php if($debug){print 'DEBUG_MODE_DESCRIPTION';} print $desc; ?></textarea>
        </div>

        <div>
            <h3 class="instruction">Quantity Avalible</h3>
            <p class="details">How many of this item do you have?</p>
            <input type="number" name="quantity" placeholder="Quantity" min="1" <?php if($debug){print 'value="100"';} print 'value='.$quantity; ?>>
        </div>

        <div>
            <h3 class="instruction">Price of Listing</h3>
            <p class="details">How much is this listing worth? Enter '0.00' to mark it as free.</p>
            <input type="number" name="price" placeholder="Price" min="0" <?php if($debug){print 'value="100"';} print 'value='.$price; ?>>
        </div>

        <div>
            <h3 class="instruction">Barter Availability</h3>
            <p class="details">Are you willing to take alternative offers on price.</p>
            <p class="checkboxWrapper"><input type="checkbox" name="barter" value="yes" <?php if($debug){print 'checked';} if($barter){print 'checked';} ?>>Yes, I will barter.</p>
        </div>

        <div>
            <h3 class="instruction">Images of your Listing</h3>
            <p class="details">Optional. We accept JPG, JPEG, PNG, and GIF files up to 3 MBs each.</p>
            <input type="file" name="image1" id="image1" class="inputFile"><br>
            <input type="file" name="image2" id="image2" class="inputFile"><br>
            <input type="file" name="image3" id="image3" class="inputFile"><br>
        </div>

        <div>
            <h3 class="instruction">Agree to Trading Hub Terms</h3>
            <p class="details">Terms can be found here: <a href="disclaimer.php#termsOfListing" target="_blank">Terms of Listing</a>.</p>
            <p class="checkboxWrapper"><input type="checkbox" name="terms" value="agreed" <?php if($debug){print 'checked';} if($terms){print 'checked';} ?>>Yes, I agree with the terms.</p>
        </div>
    </div>
    
    <input type="submit" value="Submit" id="submit" name="submit">
</form>

<?php
    // Close 'ELSE' from above
    }
?>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>