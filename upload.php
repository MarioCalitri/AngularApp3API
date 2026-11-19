<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }

    header('Content-Type: application/json');

    // Use absolute path so PHP always finds the uploads folder inside AngularApp3API
    $uploadDir = __DIR__ . '/uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $filename = basename($file['name']);
        $targetFilePath = $uploadDir . $filename;

        if ($file['error'] === UPLOAD_ERR_OK) {
            if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                http_response_code(200);
                echo json_encode(['message' => 'Image uploaded successfully.', 'filename' => $filename]);
                exit();
            }
        }
    }

    http_response_code(400);
    echo json_encode(['error' => 'Image upload failed.']);
?>