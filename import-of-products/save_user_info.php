<?php
session_start();

/**
* Functions for checking & validating form
*/

function checkingFormAndSaveNewUser(){
	include_once 'validate.php';
    
    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['agree'])) {
        $username = cleanInput($_POST['username']);
        $email = cleanInput($_POST['email']);
        $password = cleanInput($_POST['password']);
        $confirm_password = cleanInput($_POST['confirm_password']);
        $agree = $_POST['agree'];

        if (validateUsername($username)==false) {
            echo "Name should contain capitals and lower case, not less than 2 symbols";
            exit;
        } 

  	    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        if (validateEmail($email)==false) {
            echo "E-mail should be in the format of name@example.com";
            exit;
        }
  
        if (validateLength($password, 6)==false) {
            echo "Password should contain not less than 6 symbols";
            exit;
        }

        if (validateConfirm($password, $confirm_password)==false) {
            echo "Passwords do not match";
            exit;
        }
        //$password_hash=password_hash($password, PASSWORD_DEFAULT); //PHP 5 >= 5.5.0
        $password_hash=md5($password);

        $dir_for_saved_users =  "./user/";
    	if(!is_dir($dir_for_saved_users)) mkdir($dir_for_saved_users, 0777, true); 
        chmod('./user/', 0777);
        $filename = $dir_for_saved_users."user_info";
        $new_user_info = $username.":".$email.":".$password_hash."\n";
        file_put_contents($filename, $new_user_info, FILE_APPEND);
        //$_SESSION['name'] = $username;

        echo "You have signed up successfully! <a href='index.php'>Log in</a>";
    } else {
        echo "All fields are required. Please fill in all the fields.";
        exit;
    }

}
checkingFormAndSaveNewUser();


