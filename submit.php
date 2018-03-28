<!-- Header -->
<?php include ("assets/header.php"); ?>

<!-- Content Start -->
<!-- listingId, accountId, date, title, description, quantity, price, barter, image -->
<h1>Submit Listing to the Trading Hub</h1>

<form action="actions/createListing.php" method="post">
    <h3 class="instruction">Title of your Listing:</h3>
    <p class="details">Something that quickly describes your listing.</p>
    <input type="text" name="title" placeholder="Title">

    <h3 class="instruction">Description of your Listing</h3>
    <p class="details">A more descriptive blob of text about your listing with details like condition or size</p>
    <textarea name="description" rows="10" cols="30" placeholder="Description"></textarea>

    <h3 class="instruction">Quantity Avalible</h3>
    <p class="details">How many of this item do you have?</p>
    <input type="number" name="quantity" placeholder="Quantity">

    <h3 class="instruction">Price of Listing</h3>
    <p class="details">How much is this listing worth?</p>
    <input type="number" name="price" placeholder="Price">

    <h3 class="instruction">Barter Availability</h3>
    <p class="details">Are you willing to take alternative offers on price.</p>
    <p><input type="checkbox" name="barter" value="barter">Yes, I will barter.</p>
    
    <h3 class="instruction">Images of your Listing</h3>
    <p class="details">Optional. Accepts IMAGE_FILES_ACCEPTED up to IMAGE_SIZE_ACCEPTED.</p>
    <input type="file" name="image1" id="image1">
    <input type="file" name="image2" id="image2">
    <input type="file" name="image3" id="image3">

    <h3 class="instruction">Barter Availability</h3>
    <p class="details">Terms can be found here: <a href="#">Terms of Listing</a>.</p>
    <p><input type="checkbox" name="barter" value="barter">Yes, I agree with the terms.</p>

    <input type="submit" value="Submit">
</form>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>