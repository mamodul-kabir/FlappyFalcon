<?php
    $stylesheet_url = "css/signinup.css"; // Define the specific stylesheet
    include 'header.php';           // Include the header
?>

<form action="login.php" method="post">
    <label>Username: <input type="text" name="uname" id="uname"></label><br>
    <label>Password <input type="text" name="pw" id="pw"></label><br>
    <input type="submit" name="login" value="login">
</form>
<a href="signup_page.php"><button>signup</button></a>

<?php
    include "footer.php"; 
?>