<?php
header("Access-Control-Allow-Origin: http://localhost:49578");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(E_ALL);

require('connect.php');

$rawInput = file_get_contents("php://input");
$data = !empty($_POST) ? $_POST : (json_decode($rawInput, true) ?? []);

if (empty($data)) {
    http_response_code(400);
    echo json_encode(['message' => 'Empty request body.']);
    exit;
}

$id = isset($data['id']) ? (int)$data['id'] : 0;
$title = trim($data['title'] ?? '');
$author = trim($data['author'] ?? '');
$description = trim($data['description'] ?? '');
$imageName = trim($data['imageName'] ?? '');

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(['message' => 'Invalid book ID.']);
    exit;
}

if (empty($title) || empty($author)) {
    http_response_code(400);
    echo json_encode(['message' => 'Title and author are required.']);
    exit;
}

// If a file is uploaded directly to update.php, save it and use that filename
if (!empty($_FILES['image']['name']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '/uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $uploadedFile = basename($_FILES['image']['name']);
    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $uploadedFile)) {
        $imageName = $uploadedFile;
    }
}

$cleanPath = str_replace('\\', '/', $imageName);
$fileName = basename($cleanPath);
if (empty($fileName)) {
    $fileName = 'placeholder_100.jpg';
}

$titleEsc = mysqli_real_escape_string($con, $title);
$authorEsc = mysqli_real_escape_string($con, $author);
$descriptionEsc = mysqli_real_escape_string($con, $description);
$fileNameEsc = mysqli_real_escape_string($con, $fileName);

$sql = "UPDATE `books`
        SET `title` = '{$titleEsc}',
            `author` = '{$authorEsc}',
            `description` = '{$descriptionEsc}',
            `imageName` = '{$fileNameEsc}'
        WHERE `id` = {$id}";

if (mysqli_query($con, $sql)) {
    http_response_code(200);
    echo json_encode([
        'data' => [
            'id' => $id,
            'title' => $title,
            'author' => $author,
            'description' => $description,
            'imageName' => $fileName
        ]
    ]);
} else {
    http_response_code(422);
    echo json_encode(['message' => 'Failed to update book in database.']);
}
?>
