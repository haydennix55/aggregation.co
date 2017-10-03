<?php
session_start();
require("include/db.php");

$url = $_POST["new-url"];
$col = $_POST["col-number"];

$query = "SELECT * FROM feeds WHERE link = \"". $url . "\"";
$result = Query($db, $query);

if ($result){

    $_SESSION['message'] = "This feed is already on aggregation.co.";

} else {

    $query = "INSERT INTO feeds (displayColumn,link,display) VALUES (" . $col . ",\"" . $url . "\", 1);";
    $response = QueryInsert($db, $query);

    if ($response){
        $_SESSION['message'] = "Feed Successfully Added!";
    } else {
        $_SESSION['message'] = "There was a problem adding the feed.";
    }

}

header("Location: feeds.php");

?>
