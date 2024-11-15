<?php

session_start();

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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeID = $_POST['employeeID'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $db->prepare("UPDATE EMPLOYEES SET password = :password WHERE EmployeeID = :employeeID");
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':employeeID', $employeeID);

    if ($stmt->execute()) {
        echo "Password set successfully.";
    } else {
        echo "Failed to set password.";
    }
}
?>