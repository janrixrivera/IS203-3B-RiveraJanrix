<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'database.php';

$employee_id = isset($_GET['employee_id']) ? $_GET['employee_id'] : null;
$row = [];

if ($employee_id) {
    $stmt = $pdo->prepare("SELECT * FROM tbl_emp_info WHERE Employee_ID = ?");
    $stmt->execute([$employee_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $row) {
    $new_employee_id = $_POST['employee_id'];
    $new_password = $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : $row['Password']; // Keep old password if not updated

    // Update the record
    $stmt = $pdo->prepare("UPDATE tbl_emp_info SET Employee_ID = ?, Last_Name = ?, First_Name = ?, Middle_Name = ?, Gender = ?, Date_Hired = ?, Age = ?, Department = ?, Home_Address = ?, Email_Address = ?, Password = ? WHERE Employee_ID = ?");
    $success = $stmt->execute([
        $new_employee_id,
        $_POST['last_name'],
        $_POST['first_name'],
        $_POST['middle_name'],
        $_POST['gender'],
        $_POST['date_hired'],
        $_POST['age'],
        $_POST['department'],
        $_POST['home_address'],
        $_POST['email_address'],
        $new_password,
        $employee_id
    ]);

    if ($success) {
        header("Location: message.php");
        exit();
    } else {
        $errorInfo = $stmt->errorInfo();
        echo "<p>Error updating record: " . htmlspecialchars($errorInfo[2]) . "</p>";
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
    <title>EMPLOYEE CRUD OPERATIONS</title>
</head>
<body>
    <div data-role="page">
        <div data-role="header">
            <h1>Update Employee</h1>
        </div>
        <div data-role="content">
            <?php if ($row): ?>
                <form method="post">
                    <label for="employee_id">Employee ID:</label>
                    <input type="text" name="employee_id" id="employee_id" value="<?php echo htmlspecialchars($row['Employee_ID']); ?>" required><br>

                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" id="last_name" value="<?php echo htmlspecialchars($row["Last_Name"]); ?>" required><br>

                    <label for="first_name">First Name:</label>
                    <input type="text" name="first_name" id="first_name" value="<?php echo htmlspecialchars($row["First_Name"]); ?>" required><br>

                    <label for="middle_name">Middle Name:</label>
                    <input type="text" name="middle_name" id="middle_name" value="<?php echo htmlspecialchars($row["Middle_Name"]); ?>"><br>

                    <label for="gender">Gender:</label>
                    <input type="text" name="gender" id="gender" value="<?php echo htmlspecialchars($row["Gender"]); ?>" required><br>

                    <label for="date_hired">Date Hired:</label>
                    <input type="date" name="date_hired" id="date_hired" value="<?php echo htmlspecialchars($row["Date_Hired"]); ?>" required><br>

                    <label for="age">Age:</label>
                    <input type="number" name="age" id="age" value="<?php echo htmlspecialchars($row["Age"]); ?>" required><br>

                    <label for="department">Department:</label>
                    <input type="text" name="department" id="department" value="<?php echo htmlspecialchars($row["Department"]); ?>" required><br>

                    <label for="home_address">Home Address:</label>
                    <input type="text" name="home_address" id="home_address" value="<?php echo htmlspecialchars($row["Home_Address"]); ?>" required><br>

                    <label for="email_address">Email Address:</label>
                    <input type="email" name="email_address" id="email_address" value="<?php echo htmlspecialchars($row["Email_Address"]); ?>" required><br>

                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password"><br> <!-- Optional password update -->

                    <input type="submit" value="Update">
                </form>
            <?php else: ?>
                <p>No record found.</p>
            <?php endif; ?>
            <a href="read-jcr.php" data-role="button" data-ajax="false">Back</a>
        </div>
    </div>
</body>
</html>
