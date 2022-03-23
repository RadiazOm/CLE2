<?php
session_start();

if(isset($_SESSION['loggedInUser'])) {
    $login = true;
} else {
    $login = false;
}

/** @var mysqli $db */
require_once "databaseQuery.php";

if (isset($_POST['submit'])) {
    $email = mysqli_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    $errors = [];
    if($email == '') {
        $errors['email'] = 'Voer een email in';
    }
    if($password == '') {
        $errors['password'] = 'Voer een wachtwoord in';
    }

    if(empty($errors))
    {
        //Get record from DB based on first name
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $login = true;

                $_SESSION['loggedInUser'] = [
                    'email' => $user['email'],
                    'id' => $user['id'],
                    'admin' => $user['admin']
                ];
            } else {
                //error onjuiste inloggegevens
                $errors['loginFailed'] = 'De combinatie van email en wachtwoord is bij ons niet bekend';
            }
        } else {
            //error onjuiste inloggegevens
            $errors['loginFailed'] = 'De combinatie van email en wachtwoord is bij ons niet bekend';
        }
    }
}
if ($login) {
    header('Location: index.php');
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style/style.css"/>
    <title>Login</title>
</head>
<body>
<h2 class="title">Inloggen</h2>
    <form action="" method="post">
        <div class="data-field">
            <label for="email">Email</label>
            <input id="email" type="text" name="email" value="<?= $email ?? '' ?>"/>
            <span class="errors"><?= $errors['email'] ?? '' ?></span>
        </div>
        <div class="data-field">
            <label for="password">Wachtwoord</label>
            <input id="password" type="password" name="password" />
            <span class="errors"><?= $errors['password'] ?? '' ?></span>
        </div>
        <div class="data-submit">
            <input type="submit" name="submit" value="Login"/>
        </div>
        <div class="data-error">
            <span class="errors"><?= $errors['loginFailed'] ?? '' ?></span>
        </div>

        <div class="data-submit">
            <p><a href="register.php">Register</a></p>
        </div>
    </form>
</body>
</html>
