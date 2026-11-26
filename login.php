<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(200);
    exit;
}

set_exception_handler(function ($e) {
    http_response_code(500);
    echo json_encode(["message" => $e->getMessage()]);
    exit;
});

set_error_handler(function ($severity, $message, $file, $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

$userName = trim($data["username"] ?? $data["userName"] ?? "");
$password = $data["password"] ?? "";

if ($userName === "" || $password === "") {
    http_response_code(400);
    echo json_encode(["message" => "Username and password required."]);
    exit;
}

$mysqli = new mysqli("localhost", "root", "", "bookdb");
if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(["message" => "DB connection failed: " . $mysqli->connect_error]);
    exit;
}

$stmt = $mysqli->prepare("SELECT * FROM registrations WHERE userName = ? OR username = ? LIMIT 1");
if (!$stmt) {
    $stmt = $mysqli->prepare("SELECT * FROM registrations WHERE userName = ? LIMIT 1");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $mysqli->error);
    }
    $stmt->bind_param("s", $userName);
} else {
    $stmt->bind_param("ss", $userName, $userName);
}

$stmt->execute();
$res = $stmt->get_result();
$user = $res ? $res->fetch_assoc() : null;
$stmt->close();
$mysqli->close();

$storedPass = $user["password"] ?? $user["Password"] ?? "";
$valid = $user && (password_verify($password, $storedPass) || $password === $storedPass);

if (!$valid) {
    http_response_code(401);
    echo json_encode(["message" => "Invalid username or password."]);
    exit;
}

unset($user["password"], $user["Password"]);

echo json_encode([
    "token" => base64_encode(($user["id"] ?? $userName) . ":" . time()),
    "user" => $user
]);