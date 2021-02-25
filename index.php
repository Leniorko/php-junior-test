<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <p> If it your first start. Please click <a href="populatedb.php">here</a> to populate db with data</p>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="get">
        <input type="search" name="search_query" id="1" , minlength=3>
        <input type="submit" value="Найти">
    </form>

    <br>

    
    <table>

        <th>title</th>
        <th>comment</th>

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


            while ($commentArr = $commentsSearchResult->fetch_assoc()) {

                $postsQuery = "SELECT * FROM posts WHERE id = $commentArr[postid]";
                $postsQueryResult = $dbConnection->query($postsQuery);

                while ($searchedPost = $postsQueryResult->fetch_assoc()) {



                    $title = $searchedPost["title"];
                    $comment = $commentArr['body'];

                    echo "<tr>
                    <td>$title</td>
                    <td>$comment</td>
                    </tr>";
                }
            }

            $dbConnection->close();
        }
        ?>
    </table>

</body>

</html>