<!-- Header -->
<?php include ("assets/header.php"); ?>

<?php
    // Check Logout Tag
    if(isset($_GET['logout'])) {
        if($_GET['logout'] == $_SESSION['login']) {
            session_unset();
            session_destroy();
        }
    }

    // Check for logged in redirect
    if(!isset($_SESSION['login'])) {
        // Relocate to account page because user is already logged in
        ob_start();
        header("Location: login.php");
        ob_end_flush();
        die();
    } else {
        // Include the listings from account id fetcher
        include "actions/getListingsByAccountId.php";

        // Pull all user listings
        $listingData = $node->getListingsByAccountPHP($_SESSION['login']);

        // Include the account controls
        include "actions/accountControls.php";

        // Pull account data
        $accountNode = $node;
        $accountData = $accountNode->getAccountInfoFromIdPHP($_SESSION['login']);

        // Javascript variables
        $showProducts = false;
        $showChat = false;
        $showChangePass = false;
        $showDeleteAcc = false;

        // Check if any form submits are found
        if(isset($_POST["changePassword"]) or isset($_POST["deleteAccount"])) {
            // Variables
            $errorText = "";
            $errorMsg = array();

            // Include validation functions
            include "assets/validationFunctions.php";

            // Build This URL
            $thisURL = $domain.$phpSelf;

            // Run link security check
            if(!securityCheck($thisURL)) {
                // Failed security
                // TODO: Log to Database infraction w/ user info

                // Inform user they're bad people
                $out = "<h1>You do not have permission for this page.</h1>";
                die($out);
            }

            // Decide mode
            if(isset($_POST["changePassword"])) {
                // Password Change form was submitted
                // Change Javascript Variables
                $showChangePass = true;

                // Sanitize Input
                $oldPass = htmlentities($_POST["currentPassword"], ENT_QUOTES, "UTF-8");
                $newPassA = htmlentities($_POST["newPasswordA"], ENT_QUOTES, "UTF-8");
                $newPassB = htmlentities($_POST["newPasswordB"], ENT_QUOTES, "UTF-8");

                // Check for validation
                if($oldPass == $errorText) {
                    $errorMsg[] = "Please enter your old password.";
                }

                if($newPassA == $errorText) {
                    $errorMsg[] = "Please enter your new password.";
                }

                if($newPassB == $errorText) {
                    $errorMsg[] = "Please confirm your new password.";
                }

                if($newPassA != $newPassB) {
                    $errorMsg[] = "New passwords do not match.";
                }

            } else {
                // Delete Account form was submitted
                // Change Javascript Variables
                $showDeleteAcc = true;

                // Sanitize Input
                $password = htmlentities($_POST["password"], ENT_QUOTES, "UTF-8");
                $confirmation = htmlentities($_POST["textConfirmation"], ENT_QUOTES, "UTF-8");

                // Check for validation
                if($password == $errorText) {
                    $errorMsg[] = "Please enter your password.";
                }

                if($confirmation == $errorText) {
                    $errorMsg[] = "Please enter the confirmation.";
                }

                if($confirmation != "Please delete my account") {
                    $errorMsg[] = "Confirmation is not correct.";
                }
            }

            // Check for errors to attempt actions
            if(empty($errorMsg)) {
                if(isset($_POST["changePassword"])) {
                    // Change Password execute
                    $isGood = $accountNode->changeUserPasswordPHP($_SESSION['login'],$oldPass,$newPassA);

                    // Display possible errors
                    if($isGood) {
                        print '<h1 class="centerText">Password successfully changed.</h1>';
                    } else {
                        print '<h1 class="centerText">Password change failed. Check your password.</h1>';
                    }
                } else {
                    // Delete Account execute
                    $isGood = $accountNode->deleteAccountPHP($_SESSION['login'],$password);

                    // Display possible errors
                    if($isGood) {
                        // Exit session
                        session_unset();
                        session_destroy();

                        // Redirect
                        ob_start();
                        header("Location: login.php");
                        ob_end_flush();
                        die();
                    } else {
                        print '<h1 class="centerText">Account deletion failed. Check your password.</h1>';
                    }
                }
            } else {
                // Errors present
                // Print top of div
                print '<div class="forumErrors">';

                // Choose correct header
                if(isset($_POST["changePassword"])) {
                    // Account Creation
                    print '<h3>Change Password Failed</h3>';
                } else {
                    // Login
                    print '<h3>Account Delete Failed</h3>';
                }

                // Print all errors
                foreach($errorMsg as $e) {
                    print '<p>'.$e.'</p>';
                }

                // Print end of div
                print '</div>';
            }
        }
    }
?>

<!-- Content Start -->
<h1 class="jumboHeader">Hello, <?php print $accountData['name']; ?></h1>

<div class="flexContainer accountBoxes">
    <div>
        <h2>User Info</h2>
        <p>Your Email:<br>
            <span><?php print $accountData['email']; ?></span>
        </p>
        <p>Your IP:<br>
            <span><?php print $_SERVER['REMOTE_ADDR']; ?></span>
        </p>
        <p>Active Products:<br>
            <span><?php print count($listingData); ?></span>
        </p>
        <p>Session Began:<br>
            <span><?php print date("m/d/Y g:i A",$_SESSION['canary']); ?></span>
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
            <?php
                foreach($listingData as $listing) {
                    print '<li>';
                    print '<a href="listing.php?id='.$listing['listingID'].'">';
                    print '<h3>'.$listing['title'].'</h3>';
                    print '<p>$'.$listing['price'].' | '.date_format(date_create($listing['date']),"d/m/Y").'</p>';
                    print '</a>';
                    print '</li>';
                }
            ?>
        </ol>
    </div>
    <div id="chatPanel">
        <h2>Your Chat</h2>
        <p>Chat is not yet implemented.</p>
    </div>
    <div>
        <h2>Controls</h2>
        <button onclick="showChangePass()" id="changePassButton">Show Change Password</button>
        <button onclick="logoutUser()" id="logoutButton">Log Out</button>
        <button onclick="showDeleteAccount()" id="deltAccButton">Show Delete Account</button>
    </div>
    <div id="changePasswordPanel">
        <h2>Change Password</h2>
        <form action="<?php print $phpSelf; ?>" method="post" class="accountForm">
            <div>
                <div>
                    <h3 class="instruction">Current Password:</h3>
                    <input type="password" name="currentPassword" placeholder="Password">
                </div>
                <div>
                    <h3 class="instruction">New Password:</h3>
                    <p class="details">A unique password with any characters.</p>
                    <input type="password" name="newPasswordA" placeholder="Password">
                    <input type="password" name="newPasswordB" placeholder="Confirm Password" class="secondInput">
                </div>
            </div>

            <input type="submit" value="Confirm" id="changePassword" name="changePassword">
        </form>
    </div>
    <div id="deleteAccountPanel">
        <h2>Delete Account</h2>
        <form action="<?php print $phpSelf; ?>" method="post" class="accountForm">
            <div>
                <div>
                    <h3 class="instruction">Your Password:</h3>
                    <input type="password" name="password" placeholder="Password">
                </div>
                <div>
                    <h3 class="instruction">Text Confirmation:</h3>
                    <p class="details">Type 'Please delete my account' to confirm.</p>
                    <input type="text" name="textConfirmation" placeholder="Please delete my account">
                </div>
            </div>

            <input type="submit" value="Confirm" id="deleteAccount" name="deleteAccount">
        </form>
    </div>
</div>

<!-- Button Controls -->
<script>
    // Variables
    var products = <?php if($showProducts){print 'true';}else{print 'false';} ?>;
    var chat = <?php if($showChat){print 'true';}else{print 'false';} ?>;
    var changePass = <?php if($showChangePass){print 'true';}else{print 'false';} ?>;
    var deleteAcc = <?php if($showDeleteAcc){print 'true';}else{print 'false';} ?>;

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
        } else {
            document.getElementById("productsButton").innerHTML = "Hide Products";
        }

        if(!chat) {
            document.getElementById("chatPanel").style.display = "none";
        } else {
            document.getElementById("chatButton").innerHTML = "Hide Chat";
        }

        if(!changePass) {
            document.getElementById("changePasswordPanel").style.display = "none";
        } else {
            document.getElementById("changePassButton").innerHTML = "Hide Change Password";
        }

        if(!deleteAcc) {
            document.getElementById("deleteAccountPanel").style.display = "none";
        } else {
            document.getElementById("deltAccButton").innerHTML = "Hide Delete Account";
        }
    }
</script>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>