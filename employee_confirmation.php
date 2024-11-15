<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Employee Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        a {
            display: block;
            margin: 10px 0;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            text-decoration: none;
        }
        a:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Employee Added</h2>
        <p>Click below to return to the homepage, add another employee or view employees.</p>
        <a href="Homepage.php">Homepage</a>
        <a href="Add Employees.php">Add Another Employee</a>
        <a href="View Employees.php">View Employees</a>
    </div>
</body>
</html>