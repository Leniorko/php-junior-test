<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
</head>

<body>
    <p> If it your first start. Please click <a href="populatedb.php">here</a> to populate db with data</p>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
        <input type="search" name="search_query" id="1" , minlength=3>
        <input type="submit" value="Найти">
    </form>
    <table>

        <th>userId</th>
        <th>id</th>
        <th>title</th>
        <th>body</th>

        <?php

        // Checking GET data
        if (isset($_GET["search_query"]) && strlen($_GET["search_query"]) >= 3) {
            $stringToSearch = $_GET["search_query"];


            // Establish DB connection
            $dbConnection = new mysqli("localhost", "root", null, "junior_web_dev_test");

            //Query for search in comments body
            $sqlQuery = "SELECT * FROM comments WHERE body LIKE \"%$stringToSearch%\"";

            // All finds
            $commentsSearchResult = $dbConnection->query($sqlQuery);

            // Array for tracking already printed posts
            // It's neccessary if there multiply comments for one post with searched link.
            $alreadyPrinted = array();


            while ($row = $commentsSearchResult->fetch_assoc()) {

                $postsQuery = "SELECT * FROM posts WHERE id = $row[postid]";
                $postsQueryResult = $dbConnection->query($postsQuery);

                while ($searchedPost = $postsQueryResult->fetch_assoc()) {

                    if (!in_array($searchedPost["id"], $alreadyPrinted)) {
                        // array_push($alreadyPrinted, $searchedPost["id"]);

                        $userId = $searchedPost["userid"];
                        $id = $searchedPost["id"];
                        $title = $searchedPost["title"];
                        $body = $searchedPost["body"];

                        echo "<tr>
                    <td>$userId</td>
                    <td>$id</td>
                    <td>$title</td>
                    <td>$body</td>
                    </tr>";
                    }
                }
            }

            $dbConnection->close();
        }
        ?>
    </table>

</body>

</html>