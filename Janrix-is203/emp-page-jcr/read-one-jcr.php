<?php
include 'database.php';

$employee_id = isset($_GET['employee_id']) ? $_GET['employee_id'] : null;
$row = [];

if ($employee_id) {
    $stmt = $pdo->prepare("SELECT * FROM tbl_emp_info WHERE Employee_ID = ?");
    $stmt->execute([$employee_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
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
    
    <title>Employee CRUD Operations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        img {
            display: block;
            margin: 0 auto 20px;
            border-radius: 50%;
        }

        p {
            line-height: 1.6;
            color: #555;
        }

        a {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 15px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        a:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div data-role="page">
        <div data-role="header">
            <h1>Employee Details</h1>
        </div>
        <div data-role="content" class="container">
            <?php if ($row): ?>
                <img src="images/profPic.jpg" alt="Profile Picture" style="width: 100px; height: auto;">
                
                <p><strong>Employee ID:</strong> <?php echo htmlspecialchars($row['Employee_ID']); ?></p>
                <p><strong>Name:</strong> <?php echo htmlspecialchars($row['First_Name'] . ' ' . $row['Last_Name']); ?></p>
                <p><strong>Middle Name:</strong> <?php echo htmlspecialchars($row['Middle_Name']); ?></p>
                <p><strong>Gender:</strong> <?php echo htmlspecialchars($row['Gender']); ?></p>
                <p><strong>Date Hired:</strong> <?php echo htmlspecialchars($row['Date_Hired']); ?></p>
                <p><strong>Age:</strong> <?php echo htmlspecialchars($row['Age']); ?></p>
                <p><strong>Department:</strong> <?php echo htmlspecialchars($row['Department']); ?></p>
                <p><strong>Home Address:</strong> <?php echo htmlspecialchars($row['Home_Address']); ?></p>
                <p><strong>Email Address:</strong> <?php echo htmlspecialchars($row['Email_Address']); ?></p>
                
                <a href="update-jcr.php?employee_id=<?php echo htmlspecialchars($row['Employee_ID']); ?>" data-role="button">Edit</a>
                <a href="delete-jcr.php?employee_id=<?php echo htmlspecialchars($row['Employee_ID']); ?>" data-role="button">Delete</a>
            <?php else: ?>
                <p>No record found.</p>
            <?php endif; ?>
            <a href="read-jcr.php" data-ajax="false" data-role="button">Back to All Employees</a>
        </div>
    </div>
</body>
</html>
