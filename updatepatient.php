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
    echo json_encode(['success' => false, 'message' => "Patient ID is required"]);
    exit;
}

$id = $data['id'];
$fields = ['FName', 'MName', 'LName', 'Height', 'Weight', 'ContactNumber', 'EmergencyContactNumber', 'BloodType', 'Ethnicity', 'DoB', 'Desc'];

// Fetch current values
$query = "SELECT " . implode(", ", $fields) . " FROM PATIENTS WHERE PatientID = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$currentValues = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$currentValues) {
    echo json_encode(['success' => false, 'message' => "Patient not found"]);
    exit;
}

$set = [];
$params = [];
foreach ($fields as $field) {
    if (array_key_exists($field, $data)) {

        if ($field == 'DoB' && !empty($data[$field]) && !preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $data[$field])) {
            echo json_encode(['success' => false, 'message' => "Invalid DoB format. Use dd/mm/yyyy."]);
            exit;
        }

        if ($field == 'Height' && !empty($data[$field]) && ($data[$field] < 20 || $data[$field] > 255)) {
            echo json_encode(['success' => false, 'message' => "Height must be between 20 and 255 cm."]);
            exit;
        }

        if ($field == 'Weight' && !empty($data[$field]) && ($data[$field] < 2 || $data[$field] > 650)) {
            echo json_encode(['success' => false, 'message' => "Weight must be between 2 and 650 kg."]);
            exit;
        }

        if (in_array($field, ['ContactNumber', 'EmergencyContactNumber']) && !empty($data[$field]) && !preg_match("/^\d{11}$/", $data[$field])) {
            echo json_encode(['success' => false, 'message' => "Phone numbers must be 11 digits."]);
            exit;
        }

        $params[$field] = $data[$field] !== '' ? $data[$field] : null;
    } else {
        $params[$field] = $currentValues[$field];
    }
    $set[] = "$field = :$field";
}
$params['id'] = $id;

$query = "UPDATE PATIENTS SET " . implode(', ', $set) . " WHERE PatientID = :id";
$stmt = $db->prepare($query);

if ($stmt->execute($params)) {
    echo json_encode(['success' => true]);
} else {
    $errorInfo = $stmt->errorInfo();
    echo json_encode(['success' => false, 'message' => 'Failed to update patient', 'error' => $errorInfo]);
}
?>
