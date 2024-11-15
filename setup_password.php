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

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['email']) || !isset($data['EmployeeID']) || !isset($data['password'])) {
    echo json_encode(['success' => false, 'message' => "Email, EmployeeID, and password are required"]);
    exit;
}

$email = $data['email'];
$employeeID = $data['EmployeeID'];
$password = password_hash($data['password'], PASSWORD_BCRYPT);

$query = "UPDATE EMPLOYEES SET password = :password, password_set = 1 WHERE EmployeeID = :EmployeeID AND Email = :email";
$stmt = $db->prepare($query);
$params = [
    ':password' => $password,
    ':EmployeeID' => $employeeID,
    ':email' => $email
];

if ($stmt->execute($params)) {
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid Employee ID or Email']);
    }
} else {
    $errorInfo = $stmt->errorInfo();
    echo json_encode(['success' => false, 'message' => 'Failed to set password', 'error' => $errorInfo]);
}
?>  