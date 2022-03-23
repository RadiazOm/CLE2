<?php
session_start();

// check if user has logged in
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}

?>

<!doctype html>
<html lang="en">
<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style/style.css">
    <script type="text/javascript" src="Javascript/javascript.js" defer></script>
</head>

<body>
<nav class="header">
    <div class="left">
        <div id="menu-button" class="mobile"><span class="material-icons">menu</span></div>

        <div class="logo">
            <img class="logoPic" src="Images/logo%20placeholder.jpg" alt="logo">
        </div>

        <div class="navigation">
            <div><a href="index.php">Home</a></div>
            <div><a href="events.php">Events</a></div>
            <div><a class="underline" href="overOns.php">About us</a></div>
            <?php if ($_SESSION['loggedInUser']['admin']) { ?>
                <div><a href="configure.php">Configure</a></div>
                <div><a href="create.php">Create</a></div>
            <?php }?>
        </div>
    </div>

    <div class="right">
        <p class="email"><?= $_SESSION['loggedInUser']['email'] ?></p>
        <div><a href="logout.php">Logout</a></div>
        <img class="profilePic" src="Images/profile%20placeholder.jpg" alt="profiel">
    </div>
</nav>

<div id="mobile-menu" class="show">
    <div><a href="index.php">Home</a></div>
    <div><a href="events.php">Events</a></div>
    <div><a class="underline" href="overOns.php">About us</a></div>
    <?php if ($_SESSION['loggedInUser']['admin']) { ?>
        <div><a href="configure.php">Configure</a></div>
        <div><a href="create.php">Create</a></div>
    <?php }?>
</div>

</body>
</html>
