<?php
session_start();
include 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM tbl_admin WHERE username = ?");
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true; 
        $_SESSION['admin_username'] = $admin['username']; 
        header("Location: message.php");
        exit();
    } else {
        $error = "Invalid username or password.";
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
    <title>Admin Login</title>
</head>
<body>
    <div data-role="page">
        <div data-role="header">
            <h1>Admin Login</h1>
        </div>
        <div data-role="content">
            <?php if (isset($error)): ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form method="post">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required><br>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required><br>

                <input type="submit" value="Login">
            </form>
        </div>
    </div>
</body>
</html>
        