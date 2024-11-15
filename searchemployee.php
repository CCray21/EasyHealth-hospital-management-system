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
$query = "SELECT * FROM EMPLOYEES WHERE 1=1";
$params = [];

foreach ($searchTerms as $term) {
    $term = trim($term);
    $query .= " AND (EmployeeID LIKE ? OR FName LIKE ? OR MName LIKE ? OR LName LIKE ? OR DoB LIKE ? OR Role LIKE ? OR AdminStatus LIKE ? OR Hours LIKE ?)";
    for ($i = 0; $i < 8; $i++) {
        $params[] = "%$term%";
    }
}

try{
    $statement = $db->prepare($query);
    $statement->execute($params);
    $employees = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($employees);
}catch (PDOException $e){
    echo json_encode(['success' => false, 'message' => "Query failed". $e->getMessage()]);
}
?>