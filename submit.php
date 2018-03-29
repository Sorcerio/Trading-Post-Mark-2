<!-- Header -->
<?php include ("assets/header.php"); ?>

<!-- Content Start -->
<?php
    // Include the validation functions
    include "assets/validationFunctions.php";

    // Security
    $thisURL = $domain.$phpSelf;

    // Forum Variables
    $title = "";
    $desc = "";
    $quantity = "";
    $price = "";
    $barter = "";
    $terms = "";

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
        // ...
    }
?>

<h1 class="jumboHeader">Submit Listing to the Trading Hub</h1>

<form action="actions/createListing.php" method="post" enctype="multipart/form-data">
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
            <p class="details">Terms can be found here: <a href="disclaimer.php#termsOfListing">Terms of Listing</a>.</p>
            <p class="checkboxWrapper"><input type="checkbox" name="terms" value="agreed" <?php if($debug){print 'checked';} ?>>Yes, I agree with the terms.</p>
        </div>
    </div>
    
    <input type="submit" value="Submit" id="submit" name="submit">
</form>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>