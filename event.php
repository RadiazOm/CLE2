<?php
session_start();

// check if user has logged in
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}
require_once 'databaseQuery.php';
$id = $_GET["id"];
// store user id in variable so that we can use it in a query
$userId = $_SESSION['loggedInUser']['id'];

// build query
$query = "SELECT * FROM event WHERE id= '$id'";
/**
 * @var $db
 */
// store result
$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$event = [];
// make an array from the result
while($row = mysqli_fetch_assoc($result)) {
    $event[] = $row;
}
// make new query
$query = "SELECT * FROM user_events
            WHERE '$userId' = user_id AND event_id = '$id'";
/**
 * @var $db
 */

// execute query on database
$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$userEvent = [];
// convert table into array
while($row = mysqli_fetch_assoc($result)) {
    $userEvent[] = $row;
}
if (count($userEvent) != 0) {
    header('Location: index.php');
    exit();
}


if (isset($_POST['submit'])) {
    if ($event[0]['deelnemers'] >= $event[0]['max_deelnemers']) {
        $errors['participants'] = "Max participants reached, sorry :(.";
    } elseif ($userEvent[0]['event_id'] == $id) {
        $errors['user'] = "You cannot sign in to an event you are already signed in to.";
    } else {
        $deelnemers = $event[0]['deelnemers'] + 1;
        $query = "UPDATE event
              SET deelnemers = '$deelnemers'
              WHERE id = '$id'";
        $result = mysqli_query($db, $query)
        or die('Error ' . mysqli_error($db) . ' with query ' . $query);
        if (!$result) {
            $errors['db'] = "something went wrong, oops.";
        } else {
            $userId = $_SESSION['loggedInUser']['id'];
            $eventId = $event[0]['id'];
            $query2 = "INSERT INTO user_events (user_id, event_id)
                  VALUES ('$userId', '$eventId')";
            $result = mysqli_query($db, $query2)
            or die('Error ' . mysqli_error($db) . ' with query ' . $query2);
            if ($result) {
                header('Location: index.php');
            } else {
                $errors['db'] = "something went wrong, oops.";
            }
        }
    }
}

mysqli_close($db);

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
            <div><a class="underline" href="events.php">Events</a></div>
            <div><a href="overOns.php">About us</a></div>
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
    <div><a class="underline" href="events.php">Events</a></div>
    <div><a href="overOns.php">About us</a></div>
    <?php if ($_SESSION['loggedInUser']['admin']) { ?>
        <div><a href="configure.php">Configure</a></div>
        <div><a href="create.php">Create</a></div>
    <?php }?>
</div>

<?php foreach ($event as $index => $events) {?>
    <div class="Event">
        <div class="event">
            <div class="top">
                <div>
                    <p><?= $events['naam'] ?></p>
                </div>
                <div class="datum">
                    <p><?= $events['datum'] ?></p>
                </div>
            </div>

            <div class="middle">
                <p><?= $events['descriptie'] ?></p>
            </div>

            <div class="bottom">
                <div>
                    <p><?= $events['deelnemers'] ?>/<?= $events['max_deelnemers'] ?></p>
                </div>
                <div class="inschrijven">
                    <form action="" method="post">
                        <div class="button">
                            <input type="hidden" name="submit" value=""/>
                            <input type="submit" value="Sign in"/>
                            <span class="errors"><?php if (isset($errors['participants'])) {echo $errors['participants'];} ?></span>
                            <span class="errors"><?php if (isset($errors['user'])) {echo $errors['user'];} ?></span>
                            <span class="errors"><?php if (isset($errors['db'])) {echo $errors['db'];} ?></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
</body>
</html>
