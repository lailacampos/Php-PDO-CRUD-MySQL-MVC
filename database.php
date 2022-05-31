<?php

$dns = "mysql:host=localhost;dbname=world";
$username = "php";
$password = "123";

try {

    $db = new PDO($dns, $username, $password);
} catch (PDOException $e) {
    $error_message = "Database Error: ";
    $error_message .= $e->getMessage();
    echo $error_message;
    exit();
}
