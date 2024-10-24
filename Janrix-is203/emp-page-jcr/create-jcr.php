<?php
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("INSERT INTO tbl_emp_info (Employee_ID, Last_Name, First_Name, Middle_Name, Gender, Date_Hired, Age, Department, Home_Address, Email_Address, Password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['employee_id'],
        $_POST['last_name'],
        $_POST['first_name'],
        $_POST['middle_name'],
        $_POST['gender'],
        $_POST['date_hired'],
        $_POST['age'],
        $_POST['department'],
        $_POST['home_address'],
        $_POST['email_address'],
        password_hash($_POST['password'], PASSWORD_DEFAULT)  
    ]);
    
    
    header("Location: message.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="jquery/jquery.mobile-1.4.5.min.css">
    <script src="jquery/jquery-1.11.3.js"></script>
    <script src="jquery/jquery.mobile-1.4.5.min.js"></script>

    <title>EMPLOYEE CRUD OPERATIONS</title>
</head>
<body>
    <div data-role="page">
        <div data-role="header">
            <h1>Create Employee</h1>
        </div>
        <div data-role="content">
            <form method="post">
                <label for="employee_id">Employee ID:</label>
                <input type="text" name="employee_id" id="employee_id" required><br>

                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" required><br>

                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" required><br>

                <label for="middle_name">Middle Name:</label>
                <input type="text" name="middle_name" id="middle_name"><br>

                <label for="gender">Gender:</label>
                <input type="text" name="gender" id="gender" required><br>

                <label for="date_hired">Date Hired:</label>
                <input type="date" name="date_hired" id="date_hired" required><br>

                <label for="age">Age:</label>
                <input type="number" name="age" id="age" required><br>

                <label for="department">Department:</label>
                <input type="text" name="department" id="department" required><br>

                <label for="home_address">Home Address:</label>
                <input type="text" name="home_address" id="home_address" required><br>

                <label for="email_address">Email Address:</label>
                <input type="email" name="email_address" id="email_address" required><br>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required><br>

                <input type="submit" value="Create">
            </form>
            <a href="read-jcr.php" data-ajax="false" data-role="button">Back</a>
        </div>
    </div>
</body>
</html>
