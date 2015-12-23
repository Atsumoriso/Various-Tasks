<?php

/**
* This file contains functions
*/

/**
* Function to check if the user is logged in
*/ 

function isLoggedIn(){
    if(!empty($_SESSION['user_name']) && !empty($_SESSION['email'])){
        return true;
    } else {
        return false;
    }
}

/**
*  Receives POST parametr 'logout', logouts, and redirects to registration page
*/
function logout(){
    session_unset(); 
    session_destroy(); 
    setcookie('sort', '', time() - 1000); //Если нужно удалить, то достаточно имени
    // setcookie('sort', 'name', 1);
    // setcookie('sort', 'cheap', 1);
    // setcookie('sort', 'expensive', 1);
    header('Location:registration.php');
    exit();
}

/**
 * [checkSession description]
 * @return [type] [description]
 */
function checkSession(){

  // Проверяем, пусты ли пересменные логина и email пользователя
if (!isLoggedIn())
    {
	      echo "You have entered as guest<br><br> You need to <a href='index.php'>log in</a> to enter this site.<br>
If you are a new user, please, <a href='registration.php'>sign up</a>";
    }
	  else
    {
        echo "You have entered as ".$_SESSION['user_name']." ";
?>
    <form action="logout.php" method="POST">
        <input type="submit" name="logout" value="Log out">
    </form>
<?php 
    echo "See <a href='products.php'>products</a><br>";
    echo "Go <a href='index.php'>to main page</a><br>";
    }
}

/**
 * [checkLoggedUserInFile description]
 * @param  [type] $email         [description]
 * @param  [type] $password_hash [description]
 * @return [type]                [description]
 */
function checkLoggedUserInFile($email, $password_hash){
	
	/*Saving info from file to array*/
    $file = file_get_contents(dirname(__FILE__).'/user/user_info');
    // $file = str_replace("\n", ";", $file);
	// $file = explode(";", $file);
    //вместо 2-х строчек выше одна:
    $file = explode("\n", $file);

    $user_info = [];
	foreach ($file as $value) {
		$value = explode(":", $value);
		$value = array_push($user_info, $value); 
	}

    /*Checking if user exists*/
    foreach ($user_info as $value) {
        if ($email == $value[1] && $password_hash == $value[2]) {
            $_SESSION['user_name'] = $value[0];
            $_SESSION['email'] = $value[1];
            return true;
            exit;
        } 
    }

    /*If no coincidence*/
    foreach ($user_info as $value) {
        if ($email != $value[1] && $password_hash != $value[2]){
        return false;
        exit;  
        } 
    }

}
