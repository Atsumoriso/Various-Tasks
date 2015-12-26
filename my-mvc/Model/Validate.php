<?php
namespace Model;

class Validate
{

    /**
     * Function to validate user input
     * @param string $value
     * @return string
     */
    public static function cleanInput($value = "") {
        $value = trim($value);
        $value = stripslashes($value); //удаляет экранирование символов
        $value = strip_tags($value); //для удаления HTML и PHP тегов
        $value = htmlspecialchars($value); /*преобразует специальные символы в
            HTML-сущности ('&' преобразуется в '&amp;' и т.д.)*/
        return $value;
    }


    
}
