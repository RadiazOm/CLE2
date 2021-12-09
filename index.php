<?php
$host       = 'localhost';
$username   = 'root';
$password   = '';
$database   = 'events';

$db = mysqli_connect($host, $username, $password, $database)
or die('Error: '.mysqli_connect_error());

$query = "SELECT * FROM event";

$result = mysqli_query($db, $query)
or die('Error '.mysqli_error($db).' with query '.$query);

$event = [];

while($row = mysqli_fetch_assoc($result)) {
    $event[] = $row;
}

mysqli_close($db);

?>

<!doctype html>
<html lang="en">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="style/style.css">
</head>

<body>
    <nav class="header">
        <div class="left">
            <div class="logo">
                <img class="logoPic" src="Images/logo%20placeholder.jpg" alt="logo">
            </div>

            <div class="navigation">
                <div><a class="home" href="index.php">Home</a></div>
                <div><a href="events.php">Events</a></div>
                <div><a href="overOns.php">Over Ons</a></div>
            </div>
        </div>

        <div class="right">
            <img class="profilePic" src="Images/profile%20placeholder.jpg" alt="profiel">
        </div>
    </nav>
    <div class="middleSection">
        <div class="eventChamber">
            <div class="Event">
                <div class="event">
                    <div class="top">
                        <div>
                            <p>Five night's at Freddy's</p>
                        </div>
                        <div class="datum">
                            <p>2022-09-02</p>
                        </div>
                    </div>

                    <div class="middle">
                        <p>In dit event gaan wij samen deze nieuwe game ontdekk...hhhhhhhhhhhhhhhhhh hhhhhh hhhhhhhhhhhhhh hhhhhh hhhhhhhhhhhh hhhhhhhh hhhhhhhhhhhh hhhhhhhhhh hhhhhhhhh hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh v v v hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh v v hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh v hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh v </p>
                    </div>

                    <div class="bottom">
                        <div>
                            <p>23/86</p>
                        </div>
                        <div class="inschrijven">
                            <p><a href="event.php">Inschrijven</a></p>
                        </div>
                    </div>
                </div>
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
                                <p><?= $events['max_deelnemers'] ?></p>
                            </div>
                            <div class="inschrijven">
                                <p><a href="event.php?id=<?= $index + 1?>">Inschrijven</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>

