<!-- Header -->
<?php include ("assets/header.php"); ?>

<!-- Content Start -->
<h1>Trading Hub Mark 2 : Account</h1>
<p>
    <?php
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
</p>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>