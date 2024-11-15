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

$data = $_POST;

if (!empty($data['ContactNumber']) && !preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $data['DoB'])) {
    echo json_encode(['success' => false, 'message' => "Invalid DoB format. Use dd/mm/yyyy."]);
    exit;
}

if (!empty($data['ContactNumber']) && !preg_match("/^\d{11}$/", $data['ContactNumber'])) {
    echo json_encode(['success' => false, 'message' => "Invalid Contact Number. Use an 11-digit phone number."]);
    exit;
}

if (!empty($data['EmergencyContactNumber']) && !preg_match("/^\d{11}$/", $data['EmergencyContactNumber'])) {
    echo json_encode(['success' => false, 'message' => "Invalid Emergency Contact Number. Use an 11-digit phone number."]);
    exit;
}

$FName = $data['FName'];
$MName = isset($data['MName']) ? $data['MName'] : '';
$LName = $data['LName'];
$DoB = $data['DoB'];
$Height = isset($data['Height']) ? $data['Height'] : '';
$Weight = isset($data['Weight']) ? $data['Weight'] : '';
$ContactNumber = isset($data['ContactNumber']) ? $data['ContactNumber'] : '';
$EmergencyContactNumber = isset($data['EmergencyContactNumber']) ? $data['EmergencyContactNumber'] : '';
$BloodType = isset($data['BloodType']) ? $data['BloodType'] : '';
$Ethnicity = isset($data['Ethnicity']) ? $data['Ethnicity'] : '';
$Desc = isset($data['Desc']) ? $data['Desc'] : '';

$query = "INSERT INTO PATIENTS (FName, MName, LName, DoB, Height, Weight, ContactNumber, EmergencyContactNumber, BloodType, Ethnicity, Desc) VALUES (:FName, :MName, :LName, :DoB, :Height, :Weight, :ContactNumber, :EmergencyContactNumber, :BloodType, :Ethnicity, :Desc)";
$stmt = $db->prepare($query);
$params = [
    ':FName' => $FName,
    ':MName' => $MName,
    ':LName' => $LName,
    ':DoB' => $DoB,
    ':Height' => $Height,
    ':Weight' => $Weight,
    ':ContactNumber' => $ContactNumber,
    ':EmergencyContactNumber' => $EmergencyContactNumber,
    ':BloodType' => $BloodType,
    ':Ethnicity' => $Ethnicity,
    ':Desc' => $Desc,
];

if ($stmt->execute($params)) {
    header('Location: patient_confirmation.php');
    exit;
} else {
    $errorInfo = $stmt->errorInfo();
    echo json_encode(['success' => false, 'message' => 'Failed to add patient', 'error' => $errorInfo]);
}
?>