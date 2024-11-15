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

if (!isset($data['id'])) {
    echo json_encode(['success' => false, 'message' => "Employee ID is required"]);
    exit;
}

$id = $data['id'];
$fields = ['FName', 'MName', 'LName', 'Role', 'DoB', 'Email', 'Hours', 'AdminStatus'];

$query = "SELECT " . implode(", ", $fields) . " FROM EMPLOYEES WHERE EmployeeID = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$currentValues = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$currentValues) {
    echo json_encode(['success' => false, 'message' => "Employee not found"]);
    exit;
}

$set = [];
$params = [];
foreach ($fields as $field) {
    if (isset($data[$field])) {

        if (in_array($field, ['FName', 'LName', 'Role', 'DoB', 'Email', 'Hours']) && (empty($data[$field]) && $data[$field] !== '0')) {
            echo json_encode(['success' => false, 'message' => "$field cannot be empty"]);
            exit;
        }

        if ($field == 'DoB' && !preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $data[$field])) {
            echo json_encode(['success' => false, 'message' => "Invalid DoB format. Use dd/mm/yyyy."]);
            exit;
        }

        if ($field == 'Hours' && ($data[$field] < 0 || $data[$field] > 40)) {
            echo json_encode(['success' => false, 'message' => "Hours must be between 0 and 40."]);
            exit;
        }

        $params[$field] = $data[$field];
    } else {
        $params[$field] = $currentValues[$field];
    }
    $set[] = "$field = :$field";
}
$params['id'] = $id;

$query = "UPDATE EMPLOYEES SET " . implode(', ', $set) . " WHERE EmployeeID = :id";
$stmt = $db->prepare($query);

if ($stmt->execute($params)) {
    echo json_encode(['success' => true]);
} else {
    $errorInfo = $stmt->errorInfo();
    echo json_encode(['success' => false, 'message' => 'Failed to update employee', 'error' => $errorInfo]);
}
?>
