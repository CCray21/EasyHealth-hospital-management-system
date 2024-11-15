<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
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
        input[type="password"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .error-message {
            color: red;
            margin-top: 10px;
        }
        .success-message {
            color: green;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <form id="resetPasswordForm">
            <input type="password" id="password" name="password" placeholder="Enter new password" required>
            <input type="hidden" id="token" name="token" value="<?php echo htmlspecialchars($_GET['token']); ?>">
            <button type="submit">Reset Password</button>
        </form>
        <div class="error-message"></div>
        <div class="success-message"></div>
    </div>
    <script>
        document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const password = document.getElementById('password').value;
            const token = document.getElementById('token').value;
            fetch('reset_password_process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ password: password, token: token })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector('.success-message').innerText = data.message;
                    document.querySelector('.error-message').innerText = '';
                } else {
                    document.querySelector('.error-message').innerText = data.message;
                    document.querySelector('.success-message').innerText = '';
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>