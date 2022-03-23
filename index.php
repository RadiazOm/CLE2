<?php
session_start();

// check if user has logged in
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}
// store user id in variable so that we can use it in a query
$userId = $_SESSION['loggedInUser']['id'];

require_once 'databaseQuery.php';
// build query for showing events
$query = "SELECT * FROM event
            ORDER BY datum";
/**
 * @var $db
 */

// execute query on database
$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$event = [];
// convert table into array
while($row = mysqli_fetch_assoc($result)) {
    $event[] = $row;
}

// build query for checking if you have signed in
$query = "SELECT * FROM user_events
            WHERE '$userId' = user_id";
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
mysqli_close($db);

$signout = false;

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
                <div><a class="underline" href="index.php">Home</a></div>
                <div><a href="events.php">Events</a></div>
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
        <div><a class="underline" href="index.php">Home</a></div>
        <div><a href="events.php">Events</a></div>
        <div><a href="overOns.php">About us</a></div>
        <?php if ($_SESSION['loggedInUser']['admin']) { ?>
            <div><a href="configure.php">Configure</a></div>
            <div><a href="create.php">Create</a></div>
        <?php }?>
    </div>

    <div class="middleSection">
        <div class="eventChamber">
            <?php foreach ($event as $index => $events) {?>
                <div class="Event">
                    <div class="event">
                        <div class="top">
                            <div class="name">
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
                            <?php foreach ($userEvent as $index2 => $userEvents) {
                                if ($userEvents['event_id'] == $events['id']) {
                                    $signout = true;
                                }
                            }
                            if ($signout == false) { ?>
                            <div class="inschrijven">
                                <p><a href="event.php?id=<?= $events['id']?>">Sign in</a></p>
                            </div>
                            <?php } else { $signout = false ?>
                            <div class="uitschrijven">
                                <p><a href="signout.php?id=<?= $events['id']?>">Sign out</a></p>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>

