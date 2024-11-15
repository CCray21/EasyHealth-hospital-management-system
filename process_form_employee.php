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

$requiredFields = ['FName', 'LName', 'Role', 'DoB', 'Hours', 'Email'];
foreach ($requiredFields as $field) {
    if (!isset($_POST[$field]) || $_POST[$field] === '') {
        echo json_encode(['success' => false, 'message' => "$field is required"]);
        exit;
    }
}

$FName = $_POST['FName'];
$MName = $_POST['MName'] ?? '';
$LName = $_POST['LName'];
$Role = $_POST['Role'];
$DoB = $_POST['DoB'];
$Hours = $_POST['Hours'];
$Email = $_POST['Email'];
$AdminStatus = isset($_POST['AdminStatus']) ? 1 : 0;

$query = "INSERT INTO EMPLOYEES (FName, MName, LName, Role, DoB, Hours, Email, AdminStatus) VALUES (:FName, :MName, :LName, :Role, :DoB, :Hours, :Email, :AdminStatus)";
$stmt = $db->prepare($query);
$params = [
    ':FName' => $FName,
    ':MName' => $MName,
    ':LName' => $LName,
    ':Role' => $Role,
    ':DoB' => $DoB,
    ':Hours' => $Hours,
    ':Email' => $Email,
    ':AdminStatus' => $AdminStatus
];

if ($stmt->execute($params)) {
    $data = ['email' => $Email];
    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];
    $context  = stream_context_create($options);
    file_get_contents('http://localhost/EasyHealth%20Hospital%20Management%20System/send_reset_email.php', false, $context);

    header('Location: employee_confirmation.php');
    exit;
} else {
    $errorInfo = $stmt->errorInfo();
    echo json_encode(['success' => false, 'message' => 'Failed to add employee', 'error' => $errorInfo]);
}
?>