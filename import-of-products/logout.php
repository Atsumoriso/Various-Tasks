<?php
session_start();
include_once 'functions.php';

if (isset($_POST['logout'])) {
 	logout();
 }


