<?php
    require('connect.php');
    header('Content-Type: application/json');

    $books = [];

    $sql = "SELECT * FROM books";

    if ($result = mysqli_query($con, $sql))
    {
        $count = 0;

        while ($row = mysqli_fetch_assoc($result))
        {
            $books[$count]['id'] = $row['id'];
            $books[$count]['title'] = $row['title'];
            $books[$count]['author'] = $row['author'];
            $books[$count]['description'] = $row['description'];
            $books[$count]['imageName'] = $row['imageName'] ?? '';

            $count++;
        }

        echo json_encode(['data' => $books]);

    }
    else
    {
        http_response_code(404);
    }


?>