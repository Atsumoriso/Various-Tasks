<?php
session_start();
include_once 'functions.php';

?>

<!DOCTYPE html>
<html>
<head>
    <title>Log in</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<div id="reg_login">
<?php
checkSession();

?>
</div>
<h2>Log in</h2>
<form action="authorize.php" method="POST">
<!--Insert email-->
    <label for="email">E-mail:</label>
    <p><input type="email" required name="email"  maxlength="40" placeholder="Your E-mail" title="E-mail should be in the format of name@example.com"></p>
<!--Insert password-->
    <label for="password">Password:</label>
    <p><input type="password" name="password"  placeholder="Your password" title="Password should contain not less than 6 letters, figures or underlines" pattern="^[a-z0-9_-]{6,50}$"></p>
    <input type="submit" name="submit" value="Log in"><br>
</form>
</body>
</html>