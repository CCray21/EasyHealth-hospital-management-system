<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php'; // Use Composer's autoload
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

$email = json_decode(file_get_contents('php://input'), true)['email'];
$query = "SELECT * FROM EMPLOYEES WHERE Email = :email";
$stmt = $db->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $token = bin2hex(random_bytes(50));
    $expires = date("U") + 1800;

    // Store token in the database
    $query = "INSERT INTO password_resets (Email, Token, Expires) VALUES (:email, :token, :expires)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':expires', $expires);
    if ($stmt->execute()) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'easyhealthhospital@gmail.com';
            $mail->Password = 'rcoq qpmz gfhe fmxx'; // Use the App Password here
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->SMTPDebug = 2;
            $mail->Debugoutput = function($str, $level) {
                file_put_contents('php://stderr', "Debug level $level; message: $str\n", FILE_APPEND);
            };

            $mail->setFrom('easyhealthhospital@gmail.com', 'EasyHealth');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Setup Your Password';
            $mail->Body    = 'Dear ' . htmlspecialchars($user['FName']) . ',<br><br>' .
                             'Your Employee ID is: ' . htmlspecialchars($user['EmployeeID']) . '<br><br>' .
                             'Click the following link to set up your password: ' .
                             '<a href="http://localhost/EasyHealth%20Hospital%20Management%20System/setup_password.html?token=' . $token . '">Set Up Password</a><br><br>' .
                             'Best Regards,<br>EasyHealth Team';

            $mail->send();
            echo json_encode(['success' => true, 'message' => 'A password reset link has been sent to your email.']);
        } catch (Exception $e) {
            error_log('Mailer Error: ' . $mail->ErrorInfo);
            echo json_encode(['success' => false, 'message' => 'Mailer Error: ' . $mail->ErrorInfo]);
        }
    } else {
        error_log('Database Insert Error: ' . json_encode($stmt->errorInfo()));
        echo json_encode(['success' => false, 'message' => 'Database Insert Error']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Email does not exist']);
}
?>