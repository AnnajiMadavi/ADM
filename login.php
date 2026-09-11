<?php
session_start();
require_once 'db.php';

// Redirect to library if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: library.php");
    exit;
}

$message = '';
$msgType = '';

// Handle Form Submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        $firstName = trim($_POST['first_name']);
        $lastName = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $mobile = trim($_POST['mobile']);
        $username = trim($_POST['username']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

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
    <title>Login | Economics Library</title>
    <style>
        :root {
            --primary-bg: #fdfbf7; --header-bg: #1b2a2f; --header-light: #2c424a;
            --accent: #c5a86a; --text-dark: #2c3e50; --error: #e74c3c;
            --success: #28a745; --card-bg: #ffffff; --border-color: #e1e4e8;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'DM Sans', Arial, sans-serif; background-color: var(--primary-bg); color: var(--text-dark); line-height: 1.6; }
        a { text-decoration: none; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
        
        header { background-color: var(--header-bg); color: white; padding: 1.5rem 5%; display: flex; justify-content: space-between; align-items: center; border-bottom: 4px solid var(--accent); box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        header h1 { font-family: 'Playfair Display', serif; font-size: 2rem; margin: 0; }
        header p { margin: 5px 0 0 0; color: #a8b8c0; font-size: 0.9rem; }
        .btn-logout { color: white; border: 1px solid white; padding: 0.5rem 1rem; border-radius: 4px; transition: 0.3s; font-weight: bold; }
        .btn-logout:hover { background: var(--accent); border-color: var(--accent); color: var(--header-bg); }
        
        .auth-section { background: var(--card-bg); padding: 2.5rem; border-radius: 12px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); max-width: 500px; margin: 4rem auto; border-top: 5px solid var(--accent); }
        .auth-section h3 { font-size: 1.5rem; color: var(--header-bg); border-bottom: 2px solid var(--border-color); padding-bottom: 10px; margin-top: 0; margin-bottom: 20px; }
        
        .grid-form { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .grid-form input, .full-width { grid-column: span 2; }
        form { display: flex; flex-direction: column; gap: 1.2rem; }
        input { padding: 0.9rem; border: 1px solid #ddd; border-radius: 6px; font-size: 1rem; outline: none; width: 100%; }
        input:focus { border-color: var(--accent); }
        
        form button { background: var(--header-bg); color: white; border: none; padding: 1rem; border-radius: 6px; font-weight: bold; font-size: 1.1rem; cursor: pointer; transition: 0.3s; width: 100%; }
        form button:hover { background: var(--header-light); }
        
        .toggle-text { text-align: center; font-size: 0.95rem; margin-top: 10px; }
        .toggle-text span { color: var(--header-bg); cursor: pointer; font-weight: bold; text-decoration: underline; }
        
        .alert { padding: 1rem; border-radius: 6px; margin-bottom: 1.5rem; text-align: center; font-weight: bold; }
        .alert.error { background: #fce4e4; color: var(--error); border: 1px solid var(--error); }
        .alert.success { background: #e8f8f5; color: var(--success); border: 1px solid var(--success); }
        
        .fade-in { animation: fadeInUp 0.8s ease forwards; opacity: 0; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        
        @media (max-width: 768px) {
            header { flex-direction: column; text-align: center; gap: 15px; }
            .grid-form { grid-template-columns: 1fr; }
            .grid-form input, .full-width { grid-column: span 1; }
        }
    </style>
</head>
<body>
    <header>
        <div>
            <h1>Department of Economics</h1>
            <p>Student Portal Authentication</p>
        </div>
        <div class="user-controls">
            <a href="index.html" class="btn-logout">Back to Home</a>
        </div>
    </header>

    <main class="container">
        <section class="auth-section fade-in">
            <?php if($message): ?>
                <div class="alert <?php echo $msgType; ?>"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>

            <div id="login-form-container">
                <h3>Student Login</h3>
                <form method="POST" action="login.php">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="login">Log In</button>
                    <p class="toggle-text">New Student? <span onclick="toggleAuth()">Register here</span>.</p>
                </form>
            </div>

            <div id="register-form-container" style="display: none;">
                <h3>Register for Access</h3>
                <form method="POST" action="login.php" class="grid-form">
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