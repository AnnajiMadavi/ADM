<?php
session_start();
require_once 'db.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: library.php");
    exit;
}

$message = '';
$msgType = '';

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        // Registration Logic
        $firstName = trim($_POST['first_name']);
        $lastName = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $mobile = trim($_POST['mobile']);
        $username = trim($_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure hashing

        try {
            $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, mobile, username, password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$firstName, $lastName, $email, $mobile, $username, $password]);
            $message = "Registration successful! You may now log in.";
            $msgType = "success";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                $message = "Username or Email already exists.";
            } else {
                $message = "An error occurred during registration.";
            }
            $msgType = "error";
        }
    } elseif (isset($_POST['login'])) {
        // Login Logic
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT id, password, first_name FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            header("Location: library.php");
            exit;
        } else {
            $message = "Invalid username or password.";
            $msgType = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Economics Library</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Department of Economics </h1>
        <p>Dr. Annaji Madavi, Head of the Department</p>
    </header>

    <main class="container">
        <section class="intro fade-in">
            <h2>Welcome to the Department of Economics Library</h2>
            <h3>Adarsh Education Society's Arts, Commerce & Science College, Hingoli. 431513</h3>
            <p>Explore pdf Books, Notes,. E-Books, SRTMUN Exam. Question Paper, Roll No., Economics Time Table, Economics Paper Title and Paper Code. Full access to digital Economics Library requires a registered account.</p>
        </section>

        <section class="auth-section fade-in delay-1">
            <?php if($message): ?>
                <div class="alert <?php echo $msgType; ?>"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <div id="login-form-container">
                <h3>Student Login</h3>
                <form method="POST" action="index.php">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="login">Log In</button>
                    <p class="toggle-text">New Student? <span onclick="toggleAuth()">Register here</span>.</p>
                </form>
            </div>

            <div id="register-form-container" style="display: none;">
                <h3>Register for Access</h3>
                <form method="POST" action="index.php" class="grid-form">
                    <input type="text" name="first_name" placeholder="First Name" required>
                    <input type="text" name="last_name" placeholder="Last Name" required>
                    <input type="email" name="email" placeholder="Email Address" required>
                    <input type="tel" name="mobile" placeholder="Mobile Number" required>
                    <input type="text" name="username" placeholder="Choose a Username" required>
                    <input type="password" name="password" placeholder="Choose a Password" required>
                    <button type="submit" name="register" class="full-width">Register</button>
                    <p class="toggle-text full-width">Already registered? <span onclick="toggleAuth()">Log in here</span>.</p>
                </form>
            </div>
        </section>
    </main>

    <script>
        function toggleAuth() {
            const login = document.getElementById('login-form-container');
            const register = document.getElementById('register-form-container');
            if (login.style.display === 'none') {
                login.style.display = 'block';
                register.style.display = 'none';
            } else {
                login.style.display = 'none';
                register.style.display = 'block';
            }
        }
    </script>
</body>
</html>