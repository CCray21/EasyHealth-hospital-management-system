<?php
session_start();
if (!isset($_SESSION['employeeID'])) {
    header("Location: unauthorized.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Patients</title>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        body {
            display: flex;
            flex-direction: column;
            background-image: url(Hospitalbg.jpg);
            background-color: blue;
        }

        nav {
            text-decoration: none;
            padding: 20px;
            background-color: #007B9E;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logo img {
            height: 40px;
        }

        .nav-center {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 1;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .dropdown, .dropdown-2 {
            position: relative;
            display: inline-block;
        }

        .dropdown-content, .dropdown-content-2 {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            top: 100%;
            left: 0;
        }

        .dropdown-content a, .dropdown-content-2 a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover, .dropdown-content-2 a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content, .dropdown-2:hover .dropdown-content-2 {
            display: block;
        }

        .nav-link {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            font-size: 16px;
            padding: 10px;
        }

        .nav-link img {
            margin-left: 5px;
            height: 20px;
        }

        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin-top: 10px;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.5);
            margin-bottom: 20px;
        }

        .form-container form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-container input[type="text"], .form-container input[type="number"], .form-container select, .form-container button {
            padding: 10px;
            border: 1px solid #000;
            border-radius: 4px;
        }

        .form-container button {
            background-color: #00A4BD;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        .form-container button:hover {
            background-color: #007B9E;
        }

        footer {
            background-color: gray;
            text-align: center;
            padding: 10px 0;
            width: 100%;
            margin-top: auto;
        }

        .contact-links {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .contact-links a {
            text-decoration: none;
            color: white;
        }

        .contact-links img {
            height: 20px;
            vertical-align: middle;
            margin-right: 5px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
            padding-right: 20px;
            color: white;
        }

        .user-info a {
            text-decoration: none;
            color: white;
            padding: 10px;
            background-color: #007B9E;
            border-radius: 4px;
        }

        .user-info a:hover {
            background-color: #005f7a;
        }

    </style>
</head>
<body>
    <nav>
        <div class="logo">
            <a href="Homepage.php"><img src="EasyHealth.png" alt="EasyHealth"></a>
        </div>
        <div class="nav-center">
            <div class="nav-links">
                <div class="dropdown">
                    <a href="#" class="nav-link">View/Edit/Delete <img src="kisspng-arrow-computer-icons-clip-art-down-arrow-5abd343cdccc70.8152850215223491169044.jpg" alt="drop"></a>
                    <div class="dropdown-content">
                        <a href="View Employees.php">Employees</a>
                        <a href="View Patients.php">Patients</a>
                    </div>
                </div>
                <div class="dropdown-2">
                    <a href="#" class="nav-link">Add <img src="kisspng-arrow-computer-icons-clip-art-down-arrow-5abd343cdccc70.8152850215223491169044.jpg" alt="drop"></a>
                    <div class="dropdown-content-2">
                        <a href="Add Employees.php">Employees</a>
                        <a href="Add Patients.php">Patients</a>
                    </div>
                </div>
            </div> 
        </div>
        <div class="nav-right">
            <?php if (isset($_SESSION['employeeID'])): ?>
                <span>Welcome, <?php echo $_SESSION['FName']; ?> | <a href="logout.php">Logout</a></span>
            <?php else: ?>
                <a href="login.php" class="nav-link">Login</a>
            <?php endif; ?>
        </div>
    </nav> 
    <div class="content">
        <div class="form-container">
            <form action="process_form_patient.php" method="post">
                <input type="text" name="FName" placeholder="First Name...">
                <input type="text" name="MName" placeholder="Middle Name...">
                <input type="text" name="LName" placeholder="Last Name...">
                <input type="text" name="DoB" placeholder="DoB (dd/mm/yyyy)" pattern="\d{2}/\d{2}/\d{4}" title="Enter date in dd/mm/yyyy format">
                <input type="number" name="Height" placeholder="Height (cm)" min="20" max="255">
                <input type="number" name="Weight" placeholder="Weight (kg)" min="2" max="650">
                <input type="text" name="ContactNumber" placeholder="Contact Number" pattern="\d{11}" title="Enter an 11-digit phone number">
                <input type="text" name="EmergencyContactNumber" placeholder="Emergency Contact Number" pattern="\d{11}" title="Enter an 11-digit phone number">
                <select name="BloodType" required>
                    <option value="">Select Blood Type...</option>
                    <option value="O+">Not yet known</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                </select>
                <select name="Ethnicity" required>
                    <option value="">Select Ethnicity...</option>
                    <option value="American Indian or Alaska Native">American Indian or Alaska Native</option>
                    <option value="Asian">Asian</option>
                    <option value="Black or African American">Black or African American</option>
                    <option value="Middle Eastern or North African">Middle Eastern or North African</option>
                    <option value="Native Hawaiian or other Pacific Islander">Native Hawaiian or other Pacific Islander</option>
                    <option value="White">White</option>
                    <option value="Not yet known">Not yet known</option>
                    <option value="Other">Other (please specify in 'Description')</option>
                </select>
                <input type="text" name="Desc" placeholder="Description">
                <button type="submit">Add Patient</button>
            </form>
        </div>
    </div>
    <footer>
        <p>Contact us:</p>
        <div class="contact-links">
            <a href="#"><img src="instagram-icon.png" alt="Instagram"> Instagram</a>
            <a href="#"><img src="x-icon.png" alt="X"> X</a>
            <a href="#"><img src="facebook-icon.png" alt="Facebook"> Facebook</a>
            <a href="#"><img src="linkedin-icon.png" alt="LinkedIn"> LinkedIn</a>
        </div>
        <div>
            <img src="copyright.png" alt="Copyright" style="height: 20px;"> EasyHealth 2024
        </div>
    </footer>
</body>
</html>