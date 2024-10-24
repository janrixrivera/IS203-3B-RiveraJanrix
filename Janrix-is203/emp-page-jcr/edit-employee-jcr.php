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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $stmt = $pdo->prepare("UPDATE tbl_emp_info SET Last_Name = ?, First_Name = ?, Middle_Name = ?, Gender = ?, Date_Hired = ?, Age = ?, Department = ?, Home_Address = ?, Email_Address = ? WHERE Employee_ID = ?");
    $success = $stmt->execute([
        $_POST['last_name'],
        $_POST['first_name'],
        $_POST['middle_name'],
        $_POST['gender'],
        $_POST['date_hired'],
        $_POST['age'],
        $_POST['department'],
        $_POST['home_address'],
        $_POST['email_address'],
        $employee_id
    ]);

    if ($success) {
        header("Location: employee-dashboard-jcr.php"); 
        exit();
    } else {
        $error = "Error updating information.";
    }
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
    <title>Edit Employee Information</title>
</head>
<body>
    <div data-role="page">
        <div data-role="header">
            <h1>Edit Information</h1>
        </div>
        <div data-role="content">
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="post">
                <label for="last_name">Last Name:</label>
                <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($employee['Last_Name']); ?>" required><br>

                <label for="first_name">First Name:</label>
                <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($employee['First_Name']); ?>" required><br>

                <label for="middle_name">Middle Name:</label>
                <input type="text" name="middle_name" id="middle_name" value="<?php echo htmlspecialchars($employee['Middle_Name']); ?>"><br>

                <label for="gender">Gender:</label>
                <input type="text" name="gender" id="gender" value="<?php echo htmlspecialchars($employee['Gender']); ?>" required><br>

                <label for="date_hired">Date Hired:</label>
                <input type="date" name="date_hired" id="date_hired" value="<?php echo htmlspecialchars($employee['Date_Hired']); ?>" required><br>

                <label for="age">Age:</label>
                <input type="number" name="age" id="age" value="<?php echo htmlspecialchars($employee['Age']); ?>" required><br>

                <label for="department">Department:</label>
                <input type="text" name="department" id="department" value="<?php echo htmlspecialchars($employee['Department']); ?>" required><br>

                <label for="home_address">Home Address:</label>
                <input type="text" name="home_address" id="home_address" value="<?php echo htmlspecialchars($employee['Home_Address']); ?>" required><br>

                <label for="email_address">Email Address:</label>
                <input type="email" name="email_address" id="email_address" value="<?php echo htmlspecialchars($employee['Email_Address']); ?>" required><br>

                <input type="submit" value="Update">
            </form>
            <a href="employee-dashboard-jcr.php" data-role="button">Back</a>
        </div>
    </div>
</body>
</html>
