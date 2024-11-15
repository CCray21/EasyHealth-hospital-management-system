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
$employeeID = $data['employeeID'];
$password = $data['password'];
$query = "SELECT * FROM employees WHERE EmployeeID = :employeeID";
$stmt = $db->prepare($query);
$stmt->bindParam(':employeeID', $employeeID);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $hashedPassword = $user['password'];
    if (password_verify($password, $hashedPassword)) {
        $_SESSION['employeeID'] = $user['EmployeeID'];
        $_SESSION['role'] = $user['Role'];
        $_SESSION['FName'] = $user['FName'];
        $_SESSION['AdminStatus'] = $user['AdminStatus'];
        echo json_encode(['success' => true, 'message' => 'Login successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid employee ID or password']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid employee ID or password']);
}
?>