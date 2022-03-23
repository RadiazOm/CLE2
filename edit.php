<?php
session_start();

// check if user has logged in and has admin rights
if (!isset($_SESSION['loggedInUser']) || !$_SESSION['loggedInUser']['admin']) {
    header("Location: login.php");
    exit;
}
$id = $_GET['id'];
require_once 'databaseQuery.php';
// if the user has submited the form

/** @var mysqli $db */
if (isset($_POST['submit'])) {
    // convert data into strings, therefore no malicous harm is done
    $name   = mysqli_escape_string($db, $_POST['name']);
    $datum = mysqli_escape_string($db, $_POST['datum']);
    $descriptie  = mysqli_escape_string($db, $_POST['descriptie']);
    $deelnemers   = mysqli_escape_string($db, $_POST['max_deelnemers']);
    //run trough form validation
    require_once 'formValidation.php';
    // if there are no errors
    if (empty($error)) {
        //build query
        $query = "UPDATE event
        SET naam = '$name', max_deelnemers = '$deelnemers', descriptie = '$descriptie', datum = '$datum'
        WHERE id = '$id'";
        // execute query
        $result = mysqli_query($db, $query);
        // if successful return to index
        if ($result) {
            header('Location: index.php');
            exit();
            // otherwise show error
        } else {
            $error['db'] = "something went wrong in the database";
        }

        mysqli_close($db);

    }
    // if user has not submited the form
} else {
    // build query
    $query = "SELECT * FROM event WHERE id= '$id'";
    // execute query
    $result = mysqli_query($db, $query)
    or die('Error '.mysqli_error($db).' with query '.$query);

    $event = [];
    // convery table into array
    while($row = mysqli_fetch_assoc($result)) {
        $event[] = $row;
    }
    // put array into variables
    $name = $event[0]['naam'];
    $deelnemers = $event[0]['max_deelnemers'];
    $descriptie = $event[0]['descriptie'];
    $datum = $event[0]['datum'];
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
            <div><a href="overOns.php">About us</a></div>
            <?php if ($_SESSION['loggedInUser']['admin']) { ?>
                <div><a class="underline" href="configure.php">Configure</a></div>
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
    <div><a href="overOns.php">About us</a></div>
    <?php if ($_SESSION['loggedInUser']['admin']) { ?>
        <div><a class="underline" href="configure.php">Configure</a></div>
        <div><a href="create.php">Create</a></div>
    <?php }?>
</div>

<div class="back-button">
    <p><a href="configure.php">Terug</a></p>
</div>
<?php if (isset($error['db'])) {echo $error['db'];}?>
<form action="" method="post">
    <div class="data-field">
        <label for="name">Naam</label>
        <input id="name" type="text" name="name" value="<?php if (isset($name)) {echo htmlentities($name);} ?>"/>
        <span class="errors"><?php if (isset($error['name'])) {echo $error['name'];} ?></span>
    </div>
    <div class="data-field">
        <label for="datum">Datum</label>
        <input id="datum" type="text" name="datum" value="<?php if(isset($datum)) {echo htmlentities($datum);} ?>"/>
        <span class="errors"><?php if (isset($error['datum'])) {echo $error['datum'];} ?></span>
    </div>
    <div class="data-field">
        <label for="descriptie">Descriptie</label>
        <input id="descriptie" type="text" name="descriptie" value="<?php if(isset($descriptie)) {echo htmlentities($descriptie);} ?>"/>
        <span class="errors"><?php if (isset($error['descriptie'])) {echo $error['descriptie'];} ?></span>
    </div>
    <div class="data-field">
        <label for="max_deelnemers">Max deelnemers</label>
        <input id="max_deelnemers" type="text" name="max_deelnemers" value="<?php if(isset($deelnemers)) {echo htmlentities($deelnemers);}?>"/>
        <span class="errors"><?php if (isset($error['max_deelnemers'])) {echo $error['max_deelnemers'];} ?></span>
    </div>
    <div class="data-submit">
        <input type="hidden" name="submit" value=""/>
        <input type="submit" value="Save"/>
    </div>
    <div class="back-button">
        <p><a href="delete.php?id=<?= $event[0]['id']?>">Delete</a></p>
    </div>
</form>
</body>
