<!-- Header -->
<?php include ("assets/header.php"); ?>

<!-- Content Start -->
<?php
    // Include the validation functions
    include "assets/validationFunctions.php";

    // Security
    $thisURL = $domain.$phpSelf;

    // Forum Variables
    $errorText = "Forum_Failed";
    $title = $errorText;
    $desc = $errorText;
    $quantity = $errorText;
    $price = $errorText;
    $barter = false;
    $terms = false;

    // Forum Error Flags
    $title_Error = false;
    $desc_Error = false;
    $quantity_Error = false;
    $price_Error = false;
    $barter_Error = false;
    $terms_Error = false;

    // Misc Variables
    // $mailed = false;
    $errorMsg = array();
    $dataRecord = array();

    // Process Submitted Form
    if(isset($_POST["submit"])) {
        // Check security
        if(!securityCheck($thisURL)) {
            // Failed security
            // TODO: Log to Database infraction w/ user info

            // Inform user they're bad people
            $out = "<h1>You do not have permission for this page.</h1>";
            die($out);
        }

        // Sanitize inputs
        // Sanitize text inputs
        $title = htmlentities($_POST["title"], ENT_QUOTES, "UTF-8");
        $desc = htmlentities($_POST["description"], ENT_QUOTES, "UTF-8");
        $quantity = htmlentities($_POST["description"], ENT_QUOTES, "UTF-8");
        $price = htmlentities($_POST["description"], ENT_QUOTES, "UTF-8");

        // Sanitize check box inputs
        if(isset($_POST["barter"])) {
            $barter = true;
        }

        if(isset($_POST["terms"])) {
            $terms = true;
        }

        // Add data to record
        $dataRecord[] = $title;
        $dataRecord[] = $desc;
        $dataRecord[] = $quantity;
        $dataRecord[] = $price;
        $dataRecord[] = $barter;
        $dataRecord[] = $terms;

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
        }

        if($price == "") {
            $errorMsg[] = "Please enter a price.";
            $price_Error = true;
        }

        if($terms == false) {
            $errorMsg[] = "Please agree to the terms or discontinue use.";
            $terms_Error = true;
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

    if(isset($_POST['submit']) and empty($errorMsg)) {
        // Display submit header
        print '<h1 class="jumboHeader">Thanks for your Listing</h1>';
        print '<p class="jumboSubtitle">Your listing of \''.$title.'\' has been published <a href="LISTING_LINK" id="productPageLink">here</a>.</p>';

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
            <input type="text" name="title" placeholder="Title" <?php if($debug){print 'value="DEBUG_MODE_TITLE"';} ?>>
        </div>

        <div>
            <h3 class="instruction">Description of your Listing</h3>
            <p class="details">A more descriptive blob of text about your listing with details like condition or size.</p>
            <textarea name="description" placeholder="Description"><?php if($debug){print 'DEBUG_MODE_DESCRIPTION';} ?></textarea>
        </div>

        <div>
            <h3 class="instruction">Quantity Avalible</h3>
            <p class="details">How many of this item do you have?</p>
            <input type="number" name="quantity" placeholder="Quantity" <?php if($debug){print 'value="100"';} ?>>
        </div>

        <div>
            <h3 class="instruction">Price of Listing</h3>
            <p class="details">How much is this listing worth?</p>
            <input type="number" name="price" placeholder="Price" <?php if($debug){print 'value="100"';} ?>>
        </div>

        <div>
            <h3 class="instruction">Barter Availability</h3>
            <p class="details">Are you willing to take alternative offers on price.</p>
            <p class="checkboxWrapper"><input type="checkbox" name="barter" value="yes" <?php if($debug){print 'checked';} ?>>Yes, I will barter.</p>
        </div>

        <div>
            <h3 class="instruction">Images of your Listing</h3>
            <p class="details">Optional. Accepts IMAGE_FILES_ACCEPTED up to IMAGE_SIZE_ACCEPTED.</p>
            <input type="file" name="image1" id="image1" class="inputFile"><br>
            <!-- <label for="image1">Choose an Image</label> -->
            <input type="file" name="image2" id="image2" class="inputFile"><br>
            <!-- <label for="image2">Choose an Image</label> -->
            <input type="file" name="image3" id="image3" class="inputFile"><br>
            <!-- <label for="image3">Choose an Image</label> -->
        </div>

        <div>
            <h3 class="instruction">Agree to Trading Hub Terms</h3>
            <p class="details">Terms can be found here: <a href="disclaimer.php#termsOfListing" target="_blank">Terms of Listing</a>.</p>
            <p class="checkboxWrapper"><input type="checkbox" name="terms" value="agreed" <?php if($debug){print 'checked';} ?>>Yes, I agree with the terms.</p>
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