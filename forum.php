<?php
include("login.php");
session_start();
$conn = new mysqli($host, $user, $password);
$conn->select_db("forumdb");
//$conn->query("insert into comments (userid,comment) values(1, 'Ez egy másik komment')");
$table=$conn->query("select * from comments");
$username=$_SESSION["username"];
$actualuserid=$conn->query("select * from users where nickname='$username'")->fetch_assoc()["id"];
?>
<html>
<head>

</head>
<body>
<p style="font-style: italic">Bejelentkezve mint: <?php echo $_SESSION["username"]; ?></p>
<h1>Hozzászólások</h1>
<?php
if ($table->num_rows!==0)
{
    echo"<table border='2'>";
    echo"<tr>";
    echo "<td>Felhasználó</td>";
    echo "<td>Hozzászólás</td>";
    echo "<td>Like-ok</td>";
    echo "<td>Művelet</td>";
    echo"</tr>";
    while ($row=$table->fetch_assoc())
    {
        $userid=$row["userid"];
        $nick=$conn->query("select nickname from users where id=$userid")->fetch_assoc()["nickname"];
        echo"<tr>";
        echo "<td>".$nick."</td>";
        echo "<td>".$row["comment"]."</td>";
        echo "<td>".$row["likenum"]."</td>";
        if ($userid==$actualuserid)
        {
            echo "<td><a href='forum.php?delete=".$row["id"]."'>Törlés</a></td>";
        }
        else
        {
            echo "<td><a href='forum.php?like=".$row["id"]."'>Like</a></td>";
        }
        echo"</tr>";
    }
    echo"</table>";
}
?>
</body>
<form action="forum.php" method="post">
    <br><label>Hozzászólás írása</label><br>
    <textarea minlength="3" maxlength="200" name="comment" rows="4" cols="50"></textarea><br>
    <input type="submit" value="Hozzászólok">
</form>
</html>
<?php
if (isset($_POST["comment"]))
{
    $comm=$_POST["comment"];
    $conn->query("insert into comments (userid, comment) values ($actualuserid,'$comm')");
    header('Location: forum.php');
}
if (isset($_GET["delete"]))
{
    $commentid=$_GET["delete"];
    $conn->query("delete from comments where id='$commentid'");
    header('Location: forum.php');
}
if (isset($_GET["like"]))
{
    $commentid=$_GET["like"];
    $likes=$conn->query("select * from comments where id='$commentid'")->fetch_assoc()["likenum"];
    $likes++;
    $conn->query("update comments set likenum=$likes where id='$commentid'");
    header('Location: forum.php');
}