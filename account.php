<!-- Header -->
<?php include ("assets/header.php"); ?>

<?php
    // Logout Tag
    if(isset($_GET['logout'])) {
        if($_GET['logout'] == $_SESSION['login']) {
            session_unset();
            session_destroy();
        }
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
        <button onclick="showProducts()" id="productsButton">Show Products</button>
        <button onclick="showChat()" id="chatButton">Show Chat</button>
    </div>
    <div id="productsPanel">
        <h2>Your Products</h2>
        <ol>
            <li>
                <a href="listing.php?id=PRODUCT_ID">
                    <h3>PRODUCT_NAME</h3>
                    <p>PRODUCT_PRICE | PRODUCT_DATE</p>
                </a>
            </li>
        </ol>
    </div>
    <div id="chatPanel">
        <h2>Your Chat</h2>
    </div>
    <div>
        <h2>Controls</h2>
        <button onclick="showChangePass()" id="changePassButton">Show Change Password</button>
        <button onclick="logoutUser()" id="logoutButton">Log Out</button>
        <button onclick="showDeleteAccount()" id="deltAccButton">Show Delete Account</button>
    </div>
    <div id="changePasswordPanel">
        <h2>Change Password</h2>
        <form action="">
        </form>
    </div>
    <div id="deleteAccountPanel">
        <h2>Delete Account</h2>
        <form action="">
        </form>
    </div>
</div>

<!-- Button Controls -->
<script>
    // Variables
    var products = false;
    var chat = false;
    var changePass = false;
    var deleteAcc = false;

    // Startup Protocol
    startUpProtocol();

    // Shows/Hides the Products list
    function showProducts() {
        if(products) {
            products = false;
            document.getElementById("productsPanel").style.display = "none";
            document.getElementById("productsButton").innerHTML = "Show Products";
        } else {
            products = true;
            document.getElementById("productsPanel").style.display = "block";
            document.getElementById("productsButton").innerHTML = "Hide Products";
        }
    }

    // Shows/Hides the Chat list
    function showChat() {
        if(chat) {
            chat = false;
            document.getElementById("chatPanel").style.display = "none";
            document.getElementById("chatButton").innerHTML = "Show Chat";
        } else {
            chat = true;
            document.getElementById("chatPanel").style.display = "block";
            document.getElementById("chatButton").innerHTML = "Hide Chat";
        }
    }

    // Shows/Hides the change password menu
    function showChangePass() {
        if(changePass) {
            changePass = false;
            document.getElementById("changePasswordPanel").style.display = "none";
            document.getElementById("changePassButton").innerHTML = "Show Change Password";
        } else {
            changePass = true;
            document.getElementById("changePasswordPanel").style.display = "block";
            document.getElementById("changePassButton").innerHTML = "Hide Change Password";
        }
    }

    // Logs out the user
    function logoutUser() {
        // Redirect to logout function on this page
        window.location = "account.php?logout="+<?php print '"'.$_SESSION['login'].'"'; ?>;
    }

    // Shows/Hides the delete account menu
    function showDeleteAccount() {
        if(deleteAcc) {
            deleteAcc = false;
            document.getElementById("deleteAccountPanel").style.display = "none";
            document.getElementById("deltAccButton").innerHTML = "Show Delete Account";
        } else {
            deleteAcc = true;
            document.getElementById("deleteAccountPanel").style.display = "block";
            document.getElementById("deltAccButton").innerHTML = "Hide Delete Account";
        }
    }

    // Runs when the page is started
    function startUpProtocol() {
        if(!products) {
            document.getElementById("productsPanel").style.display = "none";
        }

        if(!chat) {
            document.getElementById("chatPanel").style.display = "none";
        }

        if(!changePass) {
            document.getElementById("changePasswordPanel").style.display = "none";
        }

        if(!deleteAcc) {
            document.getElementById("deleteAccountPanel").style.display = "none";
        }
    }
</script>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>