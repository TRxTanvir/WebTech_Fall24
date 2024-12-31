<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Child Adoption Management System</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            width: 600px;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        p {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .action-buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 30px;
        }

        .action-button {
            background-color: #4caf50;
            color: #fff;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .action-button:hover {
            background-color: #45a049;
        }

        .logout-button {
            background-color: #f44336;
            margin-top: 20px;
        }

        .logout-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to Child Adoption Management System</h1>
        <p>Our management is dedicated to helping children find love and permanent families through the process of adoption. We strive to provide a supportive environment for all children in need of a home.</p>

        <div class="action-buttons">
            <button class="action-button" onclick="location.href='employee.php'">Add an Employee</button>
            <button class="action-button" onclick="location.href='apform.php'">Adopt a Child</button>
            <button class="action-button" onclick="location.href='rescue.php'">Request for Rescue</button>
            <button class="action-button" onclick="location.href='volform.php'">Be a Volunteer</button>
            <button class="action-button" onclick="location.href='donation.php'">Donate Us</button>
        </div>

        <button class="logout-button" onclick="location.href='welcome.php'">Logout</button>
    </div>
</body>
</html>
