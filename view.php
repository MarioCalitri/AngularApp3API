<?php
    require('connect.php');
    header('Content-Type: application/json');

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid book ID.']);
        exit;
    }

    $sql = "SELECT * FROM `books` WHERE `id` = {$id} LIMIT 1";

    if ($result = mysqli_query($con, $sql)) {
        if (mysqli_num_rows($result) == 1) {
            echo json_encode(mysqli_fetch_assoc($result));
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Book not found.']);
        }
    } else {
        http_response_code(500);
    }
?>