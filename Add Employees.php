<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['AdminStatus'] !== 1) {
    header("Location: unauthorized.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Employees</title>
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
            border-radius: 4px;
            overflow: hidden;
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
            transition: background-color 0.3s;
        }

        .nav-link img {
            margin-left: 5px;
            height: 20px;
        }

        .nav-link:hover {
            background-color: #005f7a;
            border-radius: 4px;
        }

        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.5);
        }

        .form-container form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-container input[type="text"], .form-container select, .form-container input[type="checkbox"], .form-container button {
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
            <form action="process_form_employee.php" method="post">
                <label for="FName">First Name</label>
                <input type="text" id="FName" name="FName" placeholder="*First Name..." required>
                
                <label for="MName">Middle Name</label>
                <input type="text" id="MName" name="MName" placeholder="Middle Name...">
                
                <label for="LName">Last Name</label>
                <input type="text" id="LName" name="LName" placeholder="*Last Name..." required>

                <label for="Email">Email</label>
                <input type="email" id="Email" name="Email" placeholder="*Email..." required>
                
                <label for="Hours">Hours</label>
                <input type="number" id="Hours" name="Hours" placeholder="*Hours..." min="0" max="40" required>
                
                <label for="Role">Role</label>
                <select id="Role" name="Role" required>
                    <option value="Nurse">Nurse</option>
                    <option value="Doctor">Doctor</option>
                    <option value="Surgeon">Surgeon</option>
                    <option value="Psychotherapist">Psychotherapist</option>
                    <option value="Orthadontist">Orthadontist</option>
                    <option value="Dermatologist">Dermatologist</option>
                    <option value="Pathologist">Pathologist</option>
                    <option value="Paediatrician">Paediatrician</option>
                    <option value="General practice doctor">General Practice Doctor</option>
                    <option value="Forensic psychologist">Forensic Psychologist</option>
                    <option value="Electrician">Electrician</option>
                    <option value="Dietitian">Dietitian</option>
                    <option value="Biomedical scientist">Biomedical Scientist</option>
                </select>
                
                <label for="DoB">Date of Birth</label>
                <input type="text" id="DoB" name="DoB" pattern="\d{2}/\d{2}/\d{4}" title="Enter date in dd/mm/yyyy format" placeholder="*DoB..." required>
                
                <label for="AdminStatus">Admin Status</label>
                <input type="checkbox" id="AdminStatus" name="AdminStatus">
                
                <button type="submit">Add Employee</button>
            </form>
        </div>
    </div>
    <footer>
        <p>Contact us:</p>
        <div class="contact-links">
            <a href="#"><img src="754e8c492a38f895e08b0fee65e13309.png" alt="Instagram"> Instagram</a>
            <a href="#"><img src="99655e9fe24eb0a7ea38de683cedb735.png" alt="X"> X</a>
            <a href="#"><img src="59439.png" alt="Facebook"> Facebook</a>
            <a href="#"><img src="linkedin-icon-1-logo-black-and-white.png" alt="LinkedIn"> LinkedIn</a>
        </div>
        <div>
            <img src="Copyright.png" alt="Copyright" style="height: 20px;"> EasyHealth 2024
        </div>
    </footer>
</body>
</html>