<?php


include 'database.php';

$employee_id = isset($_GET['employee_id']) ? $_GET['employee_id'] : null;

if ($employee_id) {
    $stmt = $pdo->prepare("DELETE FROM tbl_emp_info WHERE Employee_ID = ?");
    $success = $stmt->execute([$employee_id]);

    if ($success) {
        $message = "Record deleted successfully!";
    } else {
        $message = "Error deleting record.";
    }
} else {
    $message = "No record specified.";
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
            <h1>Delete Employee</h1>
        </div>
        <div data-role="content">
            <p><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></p>
            <a href="read-jcr.php" data-ajax="false" data-role="button">Home</a>
        </div>
    </div>
</body>
</html>
