<?php
    $stylesheet_url = "css/signinup.css"; // Define the specific stylesheet
    include 'header.php';           // Include the header

    if(isset($_POST["signup"])){
        header('Location: login.php'); 
    }
?>

<form action="signup.php" method="post">
    <label>Username: <input type="text" name="uname" id="uname"></label><br>
    <label>Password <input type="text" name="pw" id="pw"></label><br>
    <input type="submit" name="signup" value="signup">
</form>
    <a href="login.php"><button>login</button></a>
<?php
    include "footer.php"; 
?>