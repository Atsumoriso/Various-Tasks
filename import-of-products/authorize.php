<?php
session_start();
// include_once('functions.php');
// if (!isLoggedIn()) {
//     header('Location:index.php');
//     exit;
// }

/**
* Functions for checking if user exists
*/
function checkingIfUserExists(){

	include_once('validate.php');
    include_once('functions.php');
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = cleanInput($_POST['email']);
        $password = cleanInput($_POST['password']);
    }

    if (empty($email) || empty($password)) { 
    	echo "All fields are required. Please fill in all the fields.";
    	exit;
    } else {

    	/*checking correctness of form input*/
  	    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (validateEmail($email) == false) {
            echo "E-mail should be in the format of name@example.com";
            exit;
        }

        if (validateLength($password, 6) == false) {
            echo "Password should contain not less than 6 symbols";
            exit;
        }

        //$password_hash=password_hash($password, PASSWORD_DEFAULT); //PHP 5 >= 5.5.0
        $password_hash=md5($password);
        
        /*checking if user already exists*/
        if(checkLoggedUserInFile($email, $password_hash) == true){
            //echo "Hello! You have logged in as ".$_SESSION['user_name'].".";
            header('Location:products.php');
            exit;  
        } else {
            echo "No such user, or wrong password.<br>"; 
            //exit;
        }

		
    }

}
checkingIfUserExists();