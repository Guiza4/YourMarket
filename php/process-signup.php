<?php

if (empty($_POST["lastname"] && $_POST["firstname"])){
    die("Last Name and First Name are required");
}

if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    die("Valid email is required");
}

print_r($_POST);
