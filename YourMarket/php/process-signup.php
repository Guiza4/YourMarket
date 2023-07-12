<?php

if (empty($_POST["lastname"] && $_POST["firstname"])) {
    die("Last Name and First Name are required");
}

if (empty($_POST["dateofbirth"])) {
    die("Your Date of Birth is required");
}

if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    die("Valid email is required");
}

if (strlen($_POST["password"]) < 8) {
    die("Password must be at least 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/i", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_conf"]) {
    die("Passwords much match");
}

$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
$dateofbirth = $_POST["dateofbirth"];
$phone = $_POST["phone"];


$mysqli = require __DIR__ . "/connecdb.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['usertype'])) {
        $userType = $_POST['usertype'];
        if ($userType === "seller") {
            $sql = "INSERT INTO seller (lastname, firstname, phone, dateofbirth, email, password)
        VALUES (?,?,?,?,?,?)";
            $stmt = $mysqli->stmt_init();

            if (!$stmt->prepare($sql)) {
                die("SQL error: " . $mysqli->error);
            }//Si On a une erreur ici c'est qu'il y a une erreur avec le sql

            $stmt->bind_param("ssssss", $_POST["lastname"], $_POST["firstname"], $phone, $dateofbirth, $_POST["email"], $password_hash);


            if ($stmt->execute()) {
                header("Location: /YourMarket/YourMarket/html/SignUP_Test_Success.html");
                exit;
            } else {
                if ($mysqli->errno === 1062) {
                    die("Email already taken");
                } else {
                    die($mysqli->error . " " . $mysqli->errno);
                }
            }
        } elseif ($userType === "buyer") {
            $sql = "INSERT INTO buyer (lastname, firstname, dateofbirth, phone, email, password)
        VALUES (?,?,?,?,?,?)";
            $stmt = $mysqli->stmt_init();

            if (!$stmt->prepare($sql)) {
                die("SQL error: " . $mysqli->error);
            }//Si On a une erreur ici c'est qu'il y a une erreur avec le sql

            $stmt->bind_param("ssssss", $_POST["lastname"], $_POST["firstname"], $dateofbirth, $phone, $_POST["email"], $password_hash);


            if ($stmt->execute()) {
                header("Location: /YourMarket/YourMarket/html/SignUP_Test_Success.html");
                exit;
            } else {
                if ($mysqli->errno === 1062) {
                    die("Email already taken");
                } else {
                    die($mysqli->error . " " . $mysqli->errno);
                }
            }
        }
    }
}



