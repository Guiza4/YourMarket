<?php

if (empty($_POST["lastname"] && $_POST["firstname"])){
    die("Last Name and First Name are required");
}

if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8){
    die("Password must be at least 8 characters");
}

if(! preg_match("/[a-z]/i", $_POST["password"])){
    die("Password must contain at least one letter");
}

if(! preg_match("/[0-9]/i", $_POST["password"])){
    die("Password must contain at least one number");
}

if(! preg_match("/[A-Z]/i", $_POST["password"])){
    die("Password must contain at least one Upper letter");
}

print_r($_POST);
