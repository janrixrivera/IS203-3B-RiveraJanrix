<?php
session_start(); 
include 'database.php';
$error = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $employee_id = isset($_POST['employee_id']) ? $_POST['employee_id'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    
    if ($employee_id && $password) {
      
        $stmt = $pdo->prepare("SELECT * FROM tbl_emp_info WHERE Employee_ID = ?");
        $stmt->execute([$employee_id]);
        $employee = $stmt->fetch(PDO::FETCH_ASSOC);

        
        if ($employee && password_verify($password, $employee['Password'])) {
           
            $_SESSION['employee_id'] = $employee['Employee_ID'];
            $_SESSION['employee_name'] = $employee['First_Name'] . ' ' . $employee['Last_Name'];

           
            header("Location: employee-dashboard-jcr.php");
            exit();
        } else {
            $error = "Invalid Employee ID or Password.";
        }
    } else {
        $error = "Both fields are required.";
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
    <title>Employee Login</title>
</head>
<body>
    <div data-role="page">
        <div data-role="header">
            <h1>Employee Login</h1>
        </div>
        <div data-role="content">
            <?php if ($error): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="post">
                <label for="employee_id">Employee ID:</label>
                <input type="text" name="employee_id" id="employee_id" required><br>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required><br>

                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</body>
</html>
