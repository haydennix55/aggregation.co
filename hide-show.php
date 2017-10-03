<?php
session_start();
require("include/db.php");

$link = $_POST["link"];
$val = $_POST["check"];

$query = "SELECT * FROM feeds WHERE link = \"". $link . "\"";
$rows = Query($db, $query);
$response = QueryInsert($db, $query);

foreach ($rows as $row){
    $id = $row['id'];
}

if ($response){

        if ($val) {
            $queryFeeds = "UPDATE feeds SET display = 1 WHERE link = '" . $link . "';";
            $queryItems = "UPDATE items SET display = 1 WHERE id = " . $id . ";";
        } else {
            $queryFeeds = "UPDATE feeds SET display = 0 WHERE link = '" . $link . "';";
            $queryItems = "UPDATE items SET display = 0 WHERE id = " . $id . ";";
        }
        $response = QueryInsert($db, $queryFeeds);
        $response = QueryInsert($db, $queryItems);

        if ($response){
            $_SESSION['message'] = "Preferences Updated!";
        } else {
            $_SESSION['message'] = "There was a problem updating preferences.";
        }

} else {
    $_SESSION['message'] = "There is no such feed.";
}

header("Location: feeds.php");

?>
