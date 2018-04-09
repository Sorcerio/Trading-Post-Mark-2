<!-- Header -->
<?php include ("assets/header.php"); ?>

<?php
    // TESTING INFO. REMOVE WHEN DONE WITH TESTING.
    if(isset($_SESSION['login'])) {
        print 'AccountID: '.$_SESSION['login'];
    } else {
        print 'AccountID: NO DATA';
    }

    if(isset($_GET['logout'])) {
        session_unset();
        session_destroy();
    }
?>

<?php
    // Include the account controls
    include "actions/accountControls.php";

    // Pull account data
    $data = $node->getAccountInfoFromIdPHP(4);
?>

<!-- Content Start -->
<h1 class="jumboHeader">Hello, <?php print $data['name']; ?></h1>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>