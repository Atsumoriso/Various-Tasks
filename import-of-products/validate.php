<?php
/**
* functions for checking form
*/
function cleanInput($value = "") {
    $value = trim($value);
    $value = stripslashes($value); //удаляет экранирование символов
    $value = strip_tags($value); //для удаления HTML и PHP тегов
    $value = htmlspecialchars($value); /*преобразует специальные символы в 
        HTML-сущности ('&' преобразуется в '&amp;' и т.д.)*/
    return $value;
}

function validateUsername($username){
    if(!preg_match("/^[a-zA-Z]{2,}/", $username)) 
        return false;
    else 
        return true;        
}

function validateEmail($email){
    if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $email))
        return false;
    else 
        return true; 
}
    
function validateLength($item, $min){
    if (strlen($item) < $min)
        return false;
    else
        return true;
}

function validateConfirm($password, $confirm_password){
    if($password != $confirm_password)
        return false;
    else
        return true;
}
    

