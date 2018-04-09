<!-- Header -->
<?php include ("assets/header.php"); ?>

<?php
    // Logout Tag
    if(isset($_GET['logout'])) {
        session_unset();
        session_destroy();
    }
?>

<?php
    // Check for logged in redirect
    if(!isset($_SESSION['login'])) {
        // Relocate to account page because user is already logged in
        ob_start();
        header("Location: login.php");
        ob_end_flush();
        die();
    } else {
        // Include the account controls
        include "actions/accountControls.php";

        // Pull account data
        $data = $node->getAccountInfoFromIdPHP($_SESSION['login']);
    }
?>

<!-- Content Start -->
<h1 class="jumboHeader">Hello, <?php print $data['name']; ?></h1>

<div class="flexContainer accountBoxes">
    <div>
        <h2>User Info</h2>
        <p>Your Email:<br>
            <span><?php print $data['email']; ?></span>
        </p>
        <p>Your IP:<br>
            <span><?php print $_SERVER['REMOTE_ADDR']; ?></span>
        </p>
        <p>Active Products:<br>
            <span>-1</span>
        </p>
    </div>
    <div>
        <h2>Actions</h2>
        <button onclick="showProducts()">Show Products</button>
        <button onclick="showChat()">Show Chat</button>
    </div>
    <div>
        <h2>Controls</h2>
        <button onclick="showChangePass()">Change Password</button>
        <button onclick="logoutUser()">Log Out</button>
        <button onclick="deleteAccount()">Delete Account</button>
    </div>
</div>

<!-- Button Controls -->
<script>
    // Shows/Hides the Products list
    function showProducts() {
        alert("Products Triggered");
    }

    // Shows/Hides the Chat list
    function showChat() {
        alert("Chat Triggered");
    }

    // Shows/Hides the change password menu
    function showChangePass() {
        alert("Pass Triggered");
    }

    // Logs out the user
    function logoutUser() {
        alert("User Triggered");
    }

    // Shows/Hides the delete account menu
    function deleteAccount() {
        alert("Delete Triggered");
    }
</script>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>