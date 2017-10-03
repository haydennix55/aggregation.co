<?php
session_start();
require("include/db.php");
require("include/header.php");
require("include/nav.php");

if ($_SESSION['message']) {
    echo "<h3>".$_SESSION['message']."</h3>";
}

?>

<script>
var changeCheckbox = function(value) {
    window.location = "hide-show.php";
}

</script>

<form action="add.php" method="post">
    <h3>Add a New Feed</h3>
    <h4>RSS Feed URL:</h4>
    <div>
        <input class="rss-input" name="new-url"/>
    </div>

    <h4>Column Number</h4>
    <div>
        <select name="col-number">
            <option value="1">1</option>
            <option value="1">2</option>
            <option value="1">3</option>
        </select>
    </div>
    <input type="submit" value="Add"/>
</form>

<?php
// Get all the user's feeds
$query = "SELECT * FROM feeds";
$rows = Query($db, $query);

echo "<h3>Current Feeds:</h3>";

function FeedIcon($link)
{
        // Feed favicon.ico
        $url = preg_replace('/^https?:\/\//', '', $link);
        if ($url != "") {
                $imgurl = "https://www.google.com/s2/favicons?domain=";
                $imgurl .= $url;

                echo "<div class=\"feedsListIcon\">";
                "\" type=\"image/x-icon\"></div>\n";
                echo '<img src="';
                echo $imgurl;
                echo '" width="16" height="16" />';
                echo "</div>\n";
        }


}

// Create an array of links and titles
foreach ($rows as $row) {
	echo "<article>";
	$rss = simplexml_load_file($row['link']);
	if ($rss) {
		FeedIcon($row['link']);

		if (strlen($rss->channel->title) == 0) {
			echo "<span class=\"feedsListTitle\">" .
			    "<a href=\"http://aggregation.co/?feed=" .
			    $row['id'] .
			    "\">" .
			    $row['link'] .
			    "</a></span>\n";
/*
			echo "<span class=\"feedsListTitle\">" .
			    $row['link'] . "</span>\n";
*/
		} else {
			echo "<span class=\"feedsListTitle\">" .
			    "<a href=\"http://aggregation.co/?feed=" .
			    $row['id'] .
			    "\">" .
			    $rss->channel->title .
			    "</a></span>\n";
/*
			echo "<span class=\"feedsListTitle\">" .
			    $rss->channel->title . "</span>\n";
*/
		}
		echo "<div class=\"feedsListLink\">" .  $row['link'] .
		    "</div>\n";

	} else {
		echo "<div>" . $row['link'] . " not found</div>\n";
	}

    echo "<h5>Show on News Page:</h5>";
    if ($row['display']){
        echo '<form action="hide-show.php" method="post">';
        echo '<input type="hidden" name="link" value="' . $row['link'] .'">';
        echo '<input class="show" type="checkbox" name="check" value="0" onChange="this.form.submit()" checked/>';
        echo '</form>';
    } else {
        echo '<form action="hide-show.php" method="post">';
        echo '<input type="hidden" name="link" value="' . $row['link'] .'">';
        echo '<input class="show" type="checkbox" name="check" value="1" onChange="this.form.submit()"/>';
        echo '</form>';
    }
	echo "</article>\n";
}
$_SESSION = array();
session_destroy();
require("include/footer.php");
