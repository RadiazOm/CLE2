<?php
$error = [];
if ($name == '') {
//          dan toon foutmelding
    $error['name'] = 'Name cannot be empty';
}
$dateCheck = explode("-", $datum, 3);
if (count($dateCheck) < 3 || !checkdate($dateCheck[1], $dateCheck[2], $dateCheck[0])) {
    $error['datum'] = 'date has to be a YYYY-MM-DD format';
}
if ($datum == '') {
    $error['datum'] = 'date cannot be empty';
//          dan toon foutmelding
}
if ($descriptie == '') {
    $error['descriptie'] = 'descirption cannot be empty';
//          dan toon foutmelding
}
if (!is_numeric($deelnemers)) {
    $error['max_deelnemers'] = 'max participants should be a number';
}
if ($deelnemers == '') {
    $error['max_deelnemers'] = 'max participants cannot be empty';
//          dan toon foutmelding
}



