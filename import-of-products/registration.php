<?php
session_start();
include_once('functions.php');
if(isLoggedIn()){
    
    header('Location:index.php');
    exit;
}
checkSession()
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Регистрация</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link type="text/css" rel="stylesheet" media="all" href="css/main.css"/>

</head>
<body>

<div id="reg_login">

</div>

<h2>Sign up</h2>
<form action="save_user_info.php" class="newuserform" method="POST">
 <!--Insert name-->
    <label for="username">Enter your name:</label>
    <p><input type="text" name="username"  placeholder="Your name"  pattern="^[a-zA-Z]{2,}" title="Name should contain capitals and lower case, not less than 2 symbols"></p>
<!--Insert email-->
    <label for="email">Enter your E-mail:</label>
    <p><input type="email" required name="email"  class=" email" maxlength="40" placeholder="Your E-mail" title="E-mail should be in the format of name@example.com"></p>
<!--Insert password-->
    <label for="password">Password:</label>
    <p><input type="password" name="password"  placeholder="Your password" title="Password should contain not less than 6 letters, figures or underlines" pattern="^[a-z0-9_-]{6,50}$"></p>
<!--confirm password-->
    <label for="confirm_password">Repeat password:</label>
    <p><input type="password" name="confirm_password"  id="confirm_password" placeholder="Repeat password" title="Password should contain not less than 6 letters, figures or underlines"></p>

<!--agreement-->
    <p><input type="checkbox" required name="agree">
    <label for="agree">I agree with the User Agreement</label></p>


<!--Button submit-->
    <p><input type="submit" name="submit" value="Sign up now!" id="submitBtn"</p>

</form>
</body>
</html>