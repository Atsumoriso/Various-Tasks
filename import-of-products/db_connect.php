<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 09.09.15
 * Time: 16:14
 */

function connectToDb()
{
    try {
        $dbh = new PDO('mysql:host=localhost;dbname=source_it_day_14', 'root', 'server88');

        //echo "<br>Connected successfully to Pentagon<br>";
        //return $dbh;
    } catch (Exception $e) {
        die("<br>Failed to connect to Pentagon: " . $e->getMessage());
    }
}
connectToDb();