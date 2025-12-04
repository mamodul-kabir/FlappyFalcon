<?php
    $stylesheet_url = "css/signinup.css";
    include 'header.php';
?>

<?php if (isset($_GET['error'])): ?>
    <p style="color: red;">
        <?php
            if ($_GET['error'] == 'empty') echo "Please enter username and password.";
            else if ($_GET['error'] == 'exists') echo "Username already taken.";
            else if ($_GET['error'] == 'failed') echo "Signup failed. Please try again.";
        ?>
    </p>
<?php endif; ?>

<form action="signup.php" method="post">
    <label>Username: <input type="text" name="uname" id="uname"></label><br>
    <label>Password: <input type="password" name="pw" id="pw"></label><br>
    <input type="submit" name="signup" value="signup">
</form>
<a href="login_page.php"><button>login</button></a>

<?php
    include "footer.php"; 
?>