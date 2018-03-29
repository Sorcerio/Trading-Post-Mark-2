<?php
print "<h1>Triggered the form</h1><br>";

// Check to see if data was submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {
    print_r($_POST);

    // Check to see if agreement was agreed
    if($_POST['terms'] == "agreed") {
        // Terms were agreed to
        // Establish Variables
        $title = $desc = $quantity = $price = $barter = "";

    } else {
        // Terms were not agreed to
        // Redirect to form
    }
}
?>