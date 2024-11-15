<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Registration</title>
</head>
<body>
    <h2>Register</h2>
    <form action="register_employee.php" method="POST">
        <label for="employeeID">Employee ID:</label>
        <input type="text" id="employeeID" name="employeeID" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <button type="submit">Register</button>
    </form>
</body>
</html>