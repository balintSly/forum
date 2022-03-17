<?php
include("login.php");
$conn = new mysqli($host, $user, $password);
$conn->select_db("forumdb");
?>
    <!DOCTYPE html>
    <html>
    <head></head>
    <body>
    <form action="" method="post">
        <fieldset>
            <legend><b>Register</b></legend>
            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email"><br>

            <label for="name">Name:</label><br>
            <input type="text" id="name" name="name"><br>
            <label for="nick">Nickname:</label><br>
            <input type="text" id="nick" name="nick"><br>

            <label for="pword">Password:</label><br>
            <input type="password" id="pword" name="pword"><br>
            <label for="pwordagain">Password again:</label><br>
            <input type="password" id="pwordagain" name="pwordagain"><br>
            <input type="submit" value="Register"><br><br>
            <a href="loginpage.php">Back to the login page</a>
        </fieldset>
    </form>
    </body>
    </html>
<?php //todo validate
if (isset($_POST["email"]) and isset($_POST["pword"]) and isset($_POST["pwordagain"]) and isset($_POST["nick"]) and isset($_POST["name"]))
{
    if (strlen($_POST["email"])==0 or strlen($_POST["pword"])<8)
    {
        echo "<br>You must enter a vaild e-mail address, and a minimum 8 characters long password!";
    }
    else
    {
        if ($_POST["pword"] !== $_POST["pwordagain"])
        {
            echo "<br>Password fields are not equal!";
        }
        else
        {
            $email = $_POST["email"];
            $pwd = md5($_POST["pword"]);
            $name=$_POST["name"];
            $nick=$_POST["nick"];

            $sql = "SELECT * FROM users WHERE email='$email'";
            $result = $conn->query($sql);

            $sql = "SELECT * FROM users WHERE nickname='$nick'";
            $result2 = $conn->query($sql);

            if ($result->num_rows==0 and $result2->num_rows==0) {
                $sql = "Insert into users (email, pwhash, nickname, realname) VALUES ('$email', '$pwd', '$nick', '$name')";
                $conn->query($sql);
                echo "<br>User successfully registered to the database!";
            }
            else if ($result->num_rows!=0)
            {
                echo "<br>Email already registered to the database!";
            }
            else if ($result2->num_rows!=0)
            {
                echo "<br>Nickname already registered to the database!";
            }
        }

    }




}
?>