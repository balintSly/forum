<?php
include("login.php");
session_start();
$conn = new mysqli($host, $user, $password);
if ($conn->connect_error) {
    die ("Connection error: " . $conn->connect_error);
}
$sql = "CREATE DATABASE IF NOT EXISTS forumdb";
$conn->query($sql);
$conn->select_db("forumdb");
$sql = "CREATE TABLE IF NOT EXISTS users (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL,
    pwhash VARCHAR(32) NOT NULL ,
    nickname VARCHAR(32) NOT NULL ,
    realname VARCHAR(32) NOT NULL ,
    reg_date TIMESTAMP   
)";
$conn->select_db("forumdb");
$conn->query($sql);
$sql = "CREATE TABLE IF NOT EXISTS comments (
      id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    userid int(6) NOT NULL ,
    likenum int(6) default 0,
    comment VARCHAR(200) NOT NULL,
    comment_date TIMESTAMP   
)";
$conn->query($sql);

?>
<!DOCTYPE html>
<html>
<head></head>
<body>
<form action="" method="post">
    <fieldset>
        <legend><b>Login</b></legend>
        <label for="nick">Nickname:</label><br>
        <input type="text" id="nick" name="nick"><br>
        <label for="pword">Password:</label><br>
        <input type="password" id="pword" name="pword"><br>
        <input type="submit" value="Login"><br><br>
        <a href="register.php">Register</a>
    </fieldset>
</form>
</body>
</html>
<?php
if (isset($_POST["nick"]) and isset($_POST["pword"]))
{
    $nick=$_POST["nick"];
    $pwd=md5($_POST["pword"]);
    $sql="SELECT * FROM users WHERE nickname='$nick' and pwhash='$pwd'";
    $result=$conn->query($sql);
    //var_dump($result);
    if ($result->num_rows==0)
    {
        echo "<br>There is no user with this data in the database, register first!";
    }
    else
    {
        $_SESSION["username"]=$_POST["nick"];
        header('Location: forum.php');
    }
}

?>


