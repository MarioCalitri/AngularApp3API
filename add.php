<?php
    require('connect.php');
    header('Content-Type: application/json');

    // Keep warnings/errors out of JSON output while still logging them
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    error_reporting(E_ALL);

    // Read JSON request body sent by Angular BookService
    $postdata = file_get_contents("php://input");

    if (!empty($postdata)) {
        $request = json_decode($postdata);
        $payload = $request->data ?? $request;

        if (!is_object($payload)) {
            http_response_code(400);
            echo json_encode(['message' => 'Invalid request payload']);
            exit;
        }

        // Validate required book fields
        if (
            empty(trim($payload->title ?? '')) ||
            empty(trim($payload->author ?? ''))
        ) {
            http_response_code(400);
            echo json_encode(['message' => 'Title and author are required']);
            exit;
        }

        // Sanitize inputs for SQL
        $title = mysqli_real_escape_string($con, trim($payload->title));
        $author = mysqli_real_escape_string($con, trim($payload->author));
        $description = mysqli_real_escape_string($con, trim($payload->description ?? ''));
        $imageName = mysqli_real_escape_string($con, trim($payload->imageName ?? ''));

        // Normalize filename and fall back to default cover image
        $cleanPath = str_replace('\\', '/', $imageName);
        $fileName = basename($cleanPath);
        if (empty($fileName)) {
            $fileName = 'placeholder_100.jpg';
        }

        $sql = "INSERT INTO `books` (`title`, `author`, `description`, `imageName`)
                VALUES ('{$title}', '{$author}', '{$description}', '{$fileName}')";

        if (mysqli_query($con, $sql)) {
            http_response_code(201);
            echo json_encode([
                'data' => [
                    'id' => mysqli_insert_id($con),
                    'title' => $title,
                    'author' => $author,
                    'description' => $description,
                    'imageName' => $fileName
                ]
            ]);
        } else {
            http_response_code(422);
            echo json_encode(['message' => 'Failed to insert book into database.']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Empty request body.']);
    }
?>
