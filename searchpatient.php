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

$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchTerms = explode(',', $search);
$query = "SELECT * FROM PATIENTS WHERE 1=1";
$params = [];

foreach ($searchTerms as $term) {
    $term = trim($term);
    $query .= " AND (PatientID LIKE ? OR FName LIKE ? OR MName LIKE ? OR LName LIKE ? OR DoB LIKE ? OR Height LIKE ? OR Weight LIKE ? OR ContactNumber LIKE ? OR EmergencyContactNumber LIKE ? OR BloodType LIKE ? OR Ethnicity LIKE ? OR Desc LIKE ?)";
    for ($i = 0; $i < 12; $i++) {
        $params[] = "%$term%";
    }
}

try {
    $statement = $db->prepare($query);
    $statement->execute($params);
    $patients = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($patients);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => "Query failed: " . $e->getMessage()]);
}
?>