<!-- Header -->
<?php include ("assets/header.php"); ?>

<!-- Content Start -->
<h1 class="jumboHeader">Join the Trading Hub</h1>

<!-- Panels -->
<div>
    <div class="leftPanel">
        <h2>Login</h2>
        <form action="" method="post">
            <input type="text" name="username" placeholder="Username">
            <input type="password" name="password" placeholder="Password">

            <input type="submit" value="Log In">
        </form>
    </div>
    
    <div class="rightPanel">
        <h2>Create Account</h2>
        <form action="" method="post">
            <div>
                <div>
                    <h3 class="instruction">Enter a Username:</h3>
                    <p class="details">A unique username with any characters.</p>
                    <input type="text" name="usernameA" placeholder="Username">
                    <input type="text" name="usernameB" placeholder="Confirm Username">
                </div>

                <div>
                    <h3 class="instruction">Enter a Password:</h3>
                    <p class="details">A unique password with any characters.</p>
                    <input type="password" name="passwordA" placeholder="Password">
                    <input type="password" name="passwordB" placeholder="Confirm Password">
                </div>

                <div>
                    <h3 class="instruction">Enter your Email:</h3>
                    <p class="details">Your email. It is used to allow contact between you and possible buyers.</p>
                    <input type="password" name="emailA" placeholder="Email">
                    <input type="password" name="emailB" placeholder="Confirm Email">
                </div>
            </div>

            <input type="submit" value="Create Account">
        </form>
    </div>
</div>

<!-- Footer -->
<?php include ("assets/footer.php"); ?>