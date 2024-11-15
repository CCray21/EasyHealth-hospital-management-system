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
    <title>View Employees</title>
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
            overflow-x: auto;
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

        .form-container input[type="text"], .form-container input[type="number"], .form-container button {
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

        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
            background-color: rgba(0, 115, 177, 0.653);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
            table-layout: auto;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            white-space: nowrap;
        }

        th {
            background-color: #009879;
            color: #ffffff;
        }

        tr {
            background-color: #f3f3f3;
        }

        tr:nth-of-type(even) {
            background-color: #f2f2f2;
        }

        tr:last-of-type {
            border-bottom: 2px solid #009879;
        }

        .delete-btn, .save-btn {
            padding: 5px;
            background-color: transparent;
            border: none;
            cursor: pointer;
        }

        .delete-btn img, .save-btn img {
            width: 20px;
            height: 20px;
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

        .instructions {
            margin-top: 20px;
            font-size: 18px;
            color: yellow;
            font-weight: bold;
            text-align: center;
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
    <div class="instructions">
        Please search the employee by Employee ID, First name, Middle name, Last name, Job, Admin status, date of birth or hours. Separate multiple searches with commas.
    </div>
    <div class="content">
        <div class="form-container">
            <form id="searchForm">
                <input type="text" id="searchInput" name="search" placeholder="Search...">
                <button type="submit">Search</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <th>EmployeeID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Email</th> <!-- New Email Column -->
                    <th>Job</th>
                    <th>Admin Status</th>
                    <th>DoB</th>
                    <th>Hours</th>
                    <th>Save</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody id="employeeTableBody">
                <!-- Employee data will be populated here via JavaScript -->
            </tbody>
        </table>
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
    <script>
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const searchValue = document.getElementById('searchInput').value;
            fetch(`searchemployee.php?search=${encodeURIComponent(searchValue)}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('employeeTableBody');
                    tbody.innerHTML = '';
                    data.forEach(employee => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${employee.EmployeeID}</td>
                            <td><input type="text" value="${employee.FName}" data-id="${employee.EmployeeID}" data-field="FName" placeholder="*First Name..." required></td>
                            <td><input type="text" value="${employee.MName}" data-id="${employee.EmployeeID}" data-field="MName" placeholder="Middle Name..."></td>
                            <td><input type="text" value="${employee.LName}" data-id="${employee.EmployeeID}" data-field="LName" placeholder="*Last Name..." required></td>
                            <td><input type="email" value="${employee.Email}" data-id="${employee.EmployeeID}" data-field="Email" placeholder="*Email..." required></td>
                            <td>
                                <select data-id="${employee.EmployeeID}" data-field="Role" required>
                                    <option value="Nurse" ${employee.Role === 'Nurse' ? 'selected' : ''}>Nurse</option>
                                    <option value="Doctor" ${employee.Role === 'Doctor' ? 'selected' : ''}>Doctor</option>
                                    <option value="Surgeon" ${employee.Role === 'Surgeon' ? 'selected' : ''}>Surgeon</option>
                                    <option value="Psychotherapist" ${employee.Role === 'Psychotherapist' ? 'selected' : ''}>Psychotherapist</option>
                                    <option value="Orthadontist" ${employee.Role === 'Orthadontist' ? 'selected' : ''}>Orthadontist</option>
                                    <option value="Dermatologist" ${employee.Role === 'Dermatologist' ? 'selected' : ''}>Dermatologist</option>
                                    <option value="Pathologist" ${employee.Role === 'Pathologist' ? 'selected' : ''}>Pathologist</option>
                                    <option value="Paediatrician" ${employee.Role === 'Paediatrician' ? 'selected' : ''}>Paediatrician</option>
                                    <option value="General practice doctor" ${employee.Role === 'General practice doctor' ? 'selected' : ''}>General practice doctor</option>
                                    <option value="Forensic psychologist" ${employee.Role === 'Forensic psychologist' ? 'selected' : ''}>Forensic psychologist</option>
                                    <option value="Electrician" ${employee.Role === 'Electrician' ? 'selected' : ''}>Electrician</option>
                                    <option value="Dietitian" ${employee.Role === 'Dietitian' ? 'selected' : ''}>Dietitian</option>
                                    <option value="Biomedical scientist" ${employee.Role === 'Biomedical scientist' ? 'selected' : ''}>Biomedical scientist</option>
                                </select>
                            </td>
                            <td><input type="checkbox" ${employee.AdminStatus ? 'checked' : ''} data-id="${employee.EmployeeID}" data-field="AdminStatus"></td>
                            <td><input type="text" value="${employee.DoB}" pattern="\\d{2}/\\d{2}/\\d{4}" title="Enter date in dd/mm/yyyy format" data-id="${employee.EmployeeID}" data-field="DoB" placeholder="*DoB..." required></td>
                            <td><input type="number" value="${employee.Hours}" min="0" max="40" data-id="${employee.EmployeeID}" data-field="Hours" placeholder="*Hours..." required></td>
                            <td><button class="save-btn" onclick="saveEmployee(${employee.EmployeeID})"><img src="save-icon.png" alt="Save"></button></td>
                            <td><button class="delete-btn" onclick="deleteEmployee(${employee.EmployeeID})"><img src="bin.png" alt="Delete"></button></td>
                        `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching employee data:', error));
        });

        function saveEmployee(id) {
            const fields = ['FName', 'MName', 'LName', 'Email', 'Role', 'DoB', 'Hours', 'AdminStatus'];
            const updatedData = {};
            let valid = true;

            // Check if all required inputs are valid
            fields.forEach(field => {
                const input = document.querySelector(`[data-id="${id}"][data-field="${field}"]`);
                if (input && !input.checkValidity()) {
                    valid = false;
                    input.reportValidity();
                }
                if (field === 'AdminStatus') {
                    updatedData[field] = input.checked ? 1 : 0;
                } else {
                    updatedData[field] = input.value;
                }
            });

            if (!valid) {
                return;
            }

            fetch('updateemployee.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id, ...updatedData })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Employee updated successfully.');
                } else {
                    alert(`Failed to update employee: ${data.message}`);
                }
            })
            .catch(error => console.error('Error updating employee:', error));
        }

        function deleteEmployee(id) {
            fetch('deleteemployee.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert('Employee deleted successfully.');
                    document.getElementById('searchForm').submit();
                } else {
                    alert(`Failed to delete employee: ${data.message}`);
                }
            })
            .catch(error => console.error('Error deleting employee:', error));
        }
    </script>
</body>
</html>