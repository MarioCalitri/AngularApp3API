<?php
    require('connect.php');
    header('Content-Type: application/json');

    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $title = mysqli_real_escape_string($con, trim($_POST['title'] ?? ''));
    $author = mysqli_real_escape_string($con, trim($_POST['author'] ?? ''));
    $description = mysqli_real_escape_string($con, trim($_POST['description'] ?? ''));
    $imageName = mysqli_real_escape_string($con, trim($_POST['imageName'] ?? ''));

    if ($id < 1 || $title === '' || $author === '') {
        http_response_code(400);
        echo json_encode(['error' => 'ID, title, and author are required.']);
        exit;
    }

    // Build query conditionally depending on whether a new image was provided
    if ($imageName !== '') {
        $sql = "UPDATE `books` SET
            `title` = '{$title}',
            `author` = '{$author}',
            `description` = '{$description}',
            `imageName` = '{$imageName}'
            WHERE `id` = {$id} LIMIT 1";
    } else {
        $sql = "UPDATE `books` SET
            `title` = '{$title}',
            `author` = '{$author}',
            `description` = '{$description}'
            WHERE `id` = {$id} LIMIT 1";
    }

    if (mysqli_query($con, $sql)) {
        http_response_code(200);
        echo json_encode(['message' => 'Book updated successfully.']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Database update failed.']);
    }
?>