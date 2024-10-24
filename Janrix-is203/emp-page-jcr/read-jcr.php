<?php
session_start(); // Start the session
include 'database.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Fetch employee information
$stmt = $pdo->query("SELECT * FROM tbl_emp_info");
$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch admin accounts
$stmtAdmin = $pdo->query("SELECT * FROM tbl_admin");
$admins = $stmtAdmin->fetchAll(PDO::FETCH_ASSOC);

// Handle delete admin request
if (isset($_GET['delete_admin_id'])) {
    $deleteAdminId = $_GET['delete_admin_id'];
    $stmtDelete = $pdo->prepare("DELETE FROM tbl_admin WHERE id = ?");
    $stmtDelete->execute([$deleteAdminId]);
    header("Location: read-jcr.php"); // Redirect to prevent re-submission
    exit();
}

// Handle add admin request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_admin'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    $stmtInsert = $pdo->prepare("INSERT INTO tbl_admin (username, password) VALUES (?, ?)");
    $stmtInsert->execute([$username, $password]);
    
    header("Location: read-jcr.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="jquery/jquery.mobile-1.4.5.min.css">
    <script src="jquery/jquery-1.11.3.js"></script>
    <script src="jquery/jquery.mobile-1.4.5.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .admin-dashboard {
            display: flex;
            flex-direction: column;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            background-color: #fff;
        }

        .section {
            margin: 10px 0;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        h2 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        button, input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        button:hover, input[type="submit"]:hover {
            background-color: #0056b3;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="password"] {
            width: calc(100% - 10px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        @media (min-width: 600px) {
            .admin-dashboard {
                flex-direction: row;
                justify-content: space-between;
            }
            .section {
                flex: 1;
                min-width: 300px;
                margin: 10px;
            }
        }
    </style>
</head>
<body>
    <button onclick="window.location.href='logout.php'" style="align-self: flex-end;">Logout</button>
    <div class="admin-dashboard">
        <div class="section student-accounts">
            <h2>Employee Accounts</h2>
            <table>
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($employee['Employee_ID']); ?></td>
                            <td>
                                <a href="read-one-jcr.php?employee_id=<?php echo htmlspecialchars($employee['Employee_ID']); ?>">
                                    <?php echo htmlspecialchars($employee['First_Name'] . ' ' . $employee['Last_Name']); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($employee['Email_Address']); ?></td>
                            <td><?php echo htmlspecialchars($employee['Department']); ?></td>
                            <td>Active</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button onclick="window.location.href='create-jcr.php'">Add New Employee</button>
        </div>
        
        <div class="section admin-accounts">
            <h2>Admin Accounts</h2>
            <table>
                <thead>
                    <tr>
                        <th>Admin ID</th>
                        <th>Username</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($admin['id']); ?></td>
                            <td><?php echo htmlspecialchars($admin['username']); ?></td>
                            <td>Active</td>
                            <td>
                                <a href="?delete_admin_id=<?php echo htmlspecialchars($admin['id']); ?>" onclick="return confirm('Are you sure you want to delete this admin?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <h3>Add New Admin</h3>
            <form method="post">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
                <input type="submit" name="add_admin" value="Add Admin">
            </form>
        </div>
    </div>
</body>
</html>
