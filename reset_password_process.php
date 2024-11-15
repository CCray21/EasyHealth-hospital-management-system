<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

$dbPath = 'C:/xampp/htdocs/EasyHealth Hospital Management System/Database.db';

if (!file_exists($dbPath)) {
    echo json_encode(['success' => false, 'message' => "Database file does not exist: $dbPath"]);
    exit;
}

if (!is_writable($dbPath)) {
    echo json_encode(['success' => false, 'message' => "Database file is not writable: $dbPath"]);
    exit;
}

try {
    $db = new PDO("sqlite:$dbPath");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => "Connection failed: " . $e->getMessage()]);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$token = $data['token'];
$newPassword = $data['password'];
$query = "SELECT * FROM password_resets WHERE Token = :token AND Expires > :now";
$stmt = $db->prepare($query);
$stmt->bindParam(':token', $token);
$now = time();
$stmt->bindParam(':now', $now);
$stmt->execute();
$passwordReset = $stmt->fetch(PDO::FETCH_ASSOC);

if ($passwordReset) {
    $email = $passwordReset['Email'];
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    error_log("Hashed Password: $hashedPassword");

    $query = "UPDATE EMPLOYEES SET Password = :password WHERE Email = :email";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':email', $email);
    if ($stmt->execute()) {
        $query = "DELETE FROM password_resets WHERE Email = :email";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        echo json_encode(['success' => true]);
    } else {
        error_log('Failed to update password in the database');
        echo json_encode(['success' => false, 'message' => 'Failed to update password']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid or expired token']);
}
?>