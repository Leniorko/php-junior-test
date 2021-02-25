<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php

// Links for data access
$postsLink = "https://jsonplaceholder.typicode.com/posts";
$commentsLink = "https://jsonplaceholder.typicode.com/comments";

// Getting all data
$postsLinkContent = file_get_contents($postsLink);
$commentsLinkContent = file_get_contents($commentsLink);

// Parse data to json
$postsInJSON = json_decode($postsLinkContent);
$commentsInJSON = json_decode($commentsLinkContent);

// Counters of total loaded data
$totlaLoadedPosts = 0;
$totalLoadedComments = 0;

// Database connection
$dbConnection = new mysqli("localhost", "root", null, "junior_web_dev_test");

// Error handle
if ($dbConnection->connect_error) {
    die("Connection failed: " . $dbConnection->connect_error);
}

// Loops for query every object
foreach ($postsInJSON as $postObject) {
    $userId = $postObject->userId;
    $id = $postObject->id;
    $title = $postObject->title;
    $body = $postObject->body;

    $sqlQuery = "INSERT INTO posts (userid, id, title, body) VALUES ($userId, $id, \"$title\", \"$body\")";

    if ($dbConnection->query($sqlQuery) === TRUE){
        $totlaLoadedPosts += 1;
    } else {
        echo "Error: {$sqlQuery} <br> {$dbConnection->error}";
    }
}

foreach ($commentsInJSON as $commentObject) {
    $postId = $commentObject->postId;
    $id = $commentObject->id;
    $name = $commentObject->name;
    $email = $commentObject->email;
    $body = $commentObject->body;

    $sqlQuery = "INSERT INTO comments (postid, id, username, email, body) VALUES ($postId, $id, \"$name\", \"$email\", \"$body\")";

    if ($dbConnection->query($sqlQuery) === TRUE){
        $totalLoadedComments += 1;
    } else {
        echo "Error: {$sqlQuery} <br> {$dbConnection->error}";
    }
}

echo "<p>Загружено $totlaLoadedPosts записей и $totalLoadedComments комментариев</p>";

$dbConnection->close();
?>

<p><a href="index.php">Go to homepage</a></p>
</body>
</html>

