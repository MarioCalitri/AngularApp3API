<?php
    require('connect.php');

    // Read id from query string (?id=...)
    $id = (isset($_GET['id']) && (int)$_GET['id'] > 0) ? (int)$_GET['id'] : 0;

    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid book ID.']);
        exit;
    }

    // Delete the book record from books table
    $sql = "DELETE FROM `books` WHERE `id` = {$id} LIMIT 1";

    if (mysqli_query($con, $sql)) {
        http_response_code(204);
    } else {
        http_response_code(422);
        echo json_encode(['message' => 'Failed to delete book.']);
    }
?>