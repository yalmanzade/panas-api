<?php
session_start();
$name = $_SESSION['username'] ;
$email = $_SESSION['email'];
echo "Name: $name";
echo "Email: $email";
echo "\n";
var_dump($_SESSION);