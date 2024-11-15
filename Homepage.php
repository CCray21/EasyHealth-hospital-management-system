<?php
session_start();
$FName = $_SESSION['FName'] ?? 'Guest';
?>
<!DOCTYPE html>
<html>
<head>
    <title>EasyHealth: Homepage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            background-color: #f0f4f8;
            color: #333;
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
            background-color: #ddd;
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

        h1 {
            text-align: center;
            font-size: 3em;
            margin-top: 50px;
            color: #007B9E;
            padding: 10px;
        }

        .content-section {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px;
            flex-wrap: wrap;
            gap: 30px;
        }

        .content-section img {
            width: 100%;
            max-width: 500px;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .content-description {
            max-width: 500px;
            font-size: 1.2em;
            color: #333;
            text-align: justify;
        }

        footer {
            background-color: gray;
            text-align: center;
            padding: 10px 0;
            width: 100%;
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

        .contact-links a:hover {
            text-decoration: underline;
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
    <h1>
        Welcome to the EasyHealth Hospital Management System!
    </h1>
    <section class="content-section">
        <img src="pexels-cottonbro-studio-7579823.jpg" alt="Doctor">
        <div class="content-description">
            <p>Here at EasyHealth, we handle all of the boring stuff so you can have an easier time searching, editing, and adding employees in the facility. We value a simple, yet functional, approach to managing such a big database.</p>
        </div>
    </section>
    <section class="content-section">
        <img src="24-bed-modular-ward-increases-hospital-capacity-1.png" alt="Hospital">
        <div class="content-description">
            <p>For years, complex databases using physical paper were used to keep track of employees, patients, and other information. Our job is to keep everything in one place without the hassle of keeping things organized yourself, losing important documents, and documents getting damaged or destroyed.</p>
        </div>
    </section>
    <footer>
        <p style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">Contact us:</p>
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