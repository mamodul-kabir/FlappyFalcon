<?php
    $stylesheet_url = 'index.css'; // Define the specific stylesheet
    include 'header.php';           // Include the header

    if(isset($_POST["login"])){
        header('Location: index.php'); 
    }
?>

<form method="post">
    <label>Username: <input type="text" name="uname" id="uname"></label><br>
    <label>Password <input type="text" name="pw" id="pw"></label><br>
    <input type="submit" name="login" value="login">
</form>
<a href="signup.php"><button>signup</button></a>

<?php
    include "footer.php"; 
?>