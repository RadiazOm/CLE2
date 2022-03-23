<?php
session_start();

// check if user has logged in and has admin rights
if (!isset($_SESSION['loggedInUser'])) {
    header("Location: login.php");
    exit;
}
$id = $_GET['id'];
$userId = $_SESSION['loggedInUser']['id'];

require_once "databaseQuery.php";
$query = "DELETE FROM user_events WHERE event_id='$id' AND user_id = '$userId'";
$result = mysqli_query($db, $query);

if ($result) {
    $query = "UPDATE event
        SET deelnemers = deelnemers -1
        WHERE id = '$id'";

    $result = mysqli_query($db, $query);

    if ($result) {
        header('Location: index.php');
        exit();
    } else {
        $error['db'] = "something went wrong in the database";
    }
} else {
    $error['db'] = "something went wrong in the database";
    echo $error['db'];
}

mysqli_close($db);
