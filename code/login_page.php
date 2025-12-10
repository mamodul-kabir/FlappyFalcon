<?php
    $stylesheet_url = "css/signinup.css";
    include 'header.php';
?>

<?php if (isset($_GET['error'])): ?>
    <p style="color: red;">
        <?php
            if ($_GET['error'] == 'empty') echo "Please enter username and password.";
            else if ($_GET['error'] == 'invalid') echo "Invalid username or password.";
        ?>
    </p>
<?php endif; ?>

<?php if (isset($_GET['success'])): ?>
    <p style="color: green;">Account created! Please log in.</p>
<?php endif; ?>

<form action="login.php" method="post">
    <label>Username: <input type="text" name="uname" id="uname"></label><br>
    <label>Password: <input type="password" name="pw" id="pw"></label><br>
    <input type="submit" name="login" value="login">
    <p class="note">Don't have an account?</p>
    <a href="signup_page.php">
        <button type="button">Sign Up</button>
    </a>
</form>

<?php
    include "footer.php"; 
?>