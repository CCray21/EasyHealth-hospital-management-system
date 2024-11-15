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
    <title>View Patients</title>
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
        Please search the patient by Patient ID, First name, Middle name, Last name, Height, Weight, Contact Number, Emergency Contact Number, Blood type, Ethnicity or date of birth. Separate multiple searches with commas.
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
                    <th>PatientID</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>Height</th>
                    <th>Weight</th>
                    <th>Contact Number</th>
                    <th>Emergency Contact Number</th>
                    <th>Blood Type</th>
                    <th>Ethnicity</th>
                    <th>DoB</th>
                    <th>Description</th>
                    <th>Save</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody id="patientTableBody">
                <!-- Patient data will be populated here via JavaScript -->
            </tbody>
        </table>
    </div>
    <footer>
        <!-- Your existing footer -->
    </footer>
    <script>
        document.getElementById('searchForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const searchValue = document.getElementById('searchInput').value;
            fetch(`searchpatient.php?search=${encodeURIComponent(searchValue)}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('patientTableBody');
                    tbody.innerHTML = '';
                    data.forEach(patient => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${patient.PatientID}</td>
                            <td><input type="text" value="${patient.FName}" data-id="${patient.PatientID}" data-field="FName" placeholder="First Name"></td>
                            <td><input type="text" value="${patient.MName}" data-id="${patient.PatientID}" data-field="MName" placeholder="Middle Name"></td>
                            <td><input type="text" value="${patient.LName}" data-id="${patient.PatientID}" data-field="LName" placeholder="Last Name"></td>
                            <td><input type="number" value="${patient.Height}" min="20" max="255" data-id="${patient.PatientID}" data-field="Height" placeholder="Height"></td>
                            <td><input type="number" value="${patient.Weight}" min="2" max="650" data-id="${patient.PatientID}" data-field="Weight" placeholder="Weight"></td>
                            <td><input type="text" value="${patient.ContactNumber}" pattern="\\d{11}" title="Phone number must be 11 digits" data-id="${patient.PatientID}" data-field="ContactNumber" placeholder="Contact Number"></td>
                            <td><input type="text" value="${patient.EmergencyContactNumber}" pattern="\\d{11}" title="Phone number must be 11 digits" data-id="${patient.PatientID}" data-field="EmergencyContactNumber" placeholder="Emergency Contact Number"></td>
                            <td>
                                <select data-id="${patient.PatientID}" data-field="BloodType">
                                    <option value="O+" ${patient.BloodType === 'O+' ? 'selected' : ''}>O+</option>
                                    <option value="O-" ${patient.BloodType === 'O-' ? 'selected' : ''}>O-</option>
                                    <option value="A+" ${patient.BloodType === 'A+' ? 'selected' : ''}>A+</option>
                                    <option value="A-" ${patient.BloodType === 'A-' ? 'selected' : ''}>A-</option>
                                    <option value="B+" ${patient.BloodType === 'B+' ? 'selected' : ''}>B+</option>
                                    <option value="B-" ${patient.BloodType === 'B-' ? 'selected' : ''}>B-</option>
                                    <option value="AB+" ${patient.BloodType === 'AB+' ? 'selected' : ''}>AB+</option>
                                    <option value="AB-" ${patient.BloodType === 'AB-' ? 'selected' : ''}>AB-</option>
                                </select>
                            </td>
                            <td>
                                <select data-id="${patient.PatientID}" data-field="Ethnicity">
                                    <option value="Not yet known" ${patient.Ethnicity === 'Not yet known' ? 'selected' : ''}>Not yet known</option>
                                    <option value="American Indian or Alaska Native" ${patient.Ethnicity === 'American Indian or Alaska Native' ? 'selected' : ''}>American Indian or Alaska Native</option>
                                    <option value="Asian" ${patient.Ethnicity === 'Asian' ? 'selected' : ''}>Asian</option>
                                    <option value="Black or African American" ${patient.Ethnicity === 'Black or African American' ? 'selected' : ''}>Black or African American</option>
                                    <option value="Middle Eastern or North African" ${patient.Ethnicity === 'Middle Eastern or North African' ? 'selected' : ''}>Middle Eastern or North African</option>
                                    <option value="Native Hawaiian or other Pacific Islander" ${patient.Ethnicity === 'Native Hawaiian or other Pacific Islander' ? 'selected' : ''}>Native Hawaiian or other Pacific Islander</option>
                                    <option value="White" ${patient.Ethnicity === 'White' ? 'selected' : ''}>White</option>
                                    <option value="Other" ${patient.Ethnicity === 'Other' ? 'selected' : ''}>Other (please specify in 'Description')</option>
                                </select>
                            </td>
                            <td><input type="text" value="${patient.DoB}" pattern="\\d{2}/\\d{2}/\\d{4}" title="Enter date in dd/mm/yyyy format" data-id="${patient.PatientID}" data-field="DoB" placeholder="DoB"></td>
                            <td><input type="text" value="${patient.Desc}" data-id="${patient.PatientID}" data-field="Desc" placeholder="Description"></td>
                            <td><button class="save-btn" onclick="savePatient(${patient.PatientID})"><img src="save-icon.png" alt="Save"></button></td>
                            <td><button class="delete-btn" onclick="deletePatient(${patient.PatientID})"><img src="bin.png" alt="Delete"></button></td>
                        `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching patient data:', error));
        });

        function savePatient(id) {
            const fields = ['FName', 'MName', 'LName', 'Height', 'Weight', 'ContactNumber', 'EmergencyContactNumber', 'BloodType', 'Ethnicity', 'DoB', 'Desc'];
            const updatedData = {};
            let valid = true;

            fields.forEach(field => {
                const input = document.querySelector(`[data-id="${id}"][data-field="${field}"]`);
                if (input && !input.checkValidity()) {
                    valid = false;
                    input.reportValidity();
                }
                updatedData[field] = input.value;
            });

            if (!valid) {
                return;
            }

            fetch('updatepatient.php', {
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
                    alert('Patient updated successfully.');
                } else {
                    alert(`Failed to update patient: ${data.message}`);
                }
            })
            .catch(error => console.error('Error updating patient:', error));
        }

        function deletePatient(id) {
            fetch('deletepatient.php', {
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
                    alert('Patient deleted successfully.');
                    document.getElementById('searchForm').submit();
                } else {
                    alert(`Failed to delete patient: ${data.message}`);
                }
            })
            .catch(error => console.error('Error deleting patient:', error));
        }
    </script>
</body>
</html>