<?php
session_start();
include 'database.php'; 


if (!isset($_SESSION['employee_id'])) {
    header("Location: login-employee-jcr.php");
    exit();
}


$employee_id = $_SESSION['employee_id'];
$stmt = $pdo->prepare("SELECT * FROM tbl_emp_info WHERE Employee_ID = ?");
$stmt->execute([$employee_id]);
$employee = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="jquery/jquery.mobile-1.4.5.min.css">
    <script src="jquery/jquery-1.11.3.js"></script>
    <script src="jquery/jquery.mobile-1.4.5.min.js"></script>
    <title>Employee Dashboard</title>
</head>
<body>
    <div data-role="page">
        <div data-role="header">
            <h1>Employee Dashboard</h1>
        </div>
        <div data-role="content">
            <h2>Welcome, <?php echo htmlspecialchars($employee['First_Name']); ?></h2>
            <p>Employee ID: <?php echo htmlspecialchars($employee['Employee_ID']); ?></p>
            <p>Name: <?php echo htmlspecialchars($employee['First_Name'] . ' ' . $employee['Last_Name']); ?></p>
            <p>Middle Name: <?php echo htmlspecialchars($employee['Middle_Name']); ?></p>
            <p>Gender: <?php echo htmlspecialchars($employee['Gender']); ?></p>
            <p>Date Hired: <?php echo htmlspecialchars($employee['Date_Hired']); ?></p>
            <p>Age: <?php echo htmlspecialchars($employee['Age']); ?></p>
            <p>Department: <?php echo htmlspecialchars($employee['Department']); ?></p>
            <p>Home Address: <?php echo htmlspecialchars($employee['Home_Address']); ?></p>
            <p>Email Address: <?php echo htmlspecialchars($employee['Email_Address']); ?></p>
            <a href="edit-employee-jcr.php" data-role="button">Edit Information</a>
            <a href="logout-employee.php" data-role="button">Logout</a>
        </div>
    </div>
</body>
</html>
