<?php
if(isset($_POST['submitB'])){
	$username = $_POST ['uname'];
   date_default_timezone_set('Europe/Kyiv');
	$time = date("d.m.Y H:i:s");
    setcookie("login", $username, time() + 3600);
    setcookie("time", $time, time() + 3600);
    header("Location: cookieData.php");
}
?>

<!DOCTYPE html>
<html>
  <head>
     <title>A Web Page</title>
     <meta charset="utf-8"/>
  </head>
  <body>
     <form method="post" action="<?= $_SERVER['PHP_SELF']?>">
        Введіть логін: <input type="text" name="uname"/><br/>
        <input type="submit" name="submitB" value="Підтвердити"/>
     </form>
   </body>
</html>