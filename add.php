<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }

    require 'connect.php';

    $postdata = file_get_contents("php://input");

    if (isset($postdata) && !empty($postdata)) {
        $request = json_decode($postdata);

        // Unwrap { data: { ... } } if sent by BookService
        $payload = isset($request->data) ? $request->data : $request;

        $title = mysqli_real_escape_string($con, trim($payload->title ?? ''));
        $author = mysqli_real_escape_string($con, trim($payload->author ?? ''));
        $description = mysqli_real_escape_string($con, trim($payload->description ?? ''));
        $imageName = mysqli_real_escape_string($con, trim($payload->imageName ?? ''));

        if ($title === '' || $author === '') {
            http_response_code(400);
            echo json_encode(['message' => 'Title and author are required.']);
            exit();
        }

        $sql = "INSERT INTO books (title, author, description, imageName) VALUES ('{$title}', '{$author}', '{$description}', '{$imageName}')";

        if (mysqli_query($con, $sql)) {
            http_response_code(201);
            $book = [
                'id' => mysqli_insert_id($con),
                'title' => $title,
                'author' => $author,
                'description' => $description,
                'imageName' => $imageName
            ];
            echo json_encode(['data' => $book]);
        } else {
            http_response_code(422);
            echo json_encode(['message' => 'Database insert failed: ' . mysqli_error($con)]);
        }
    }
?>