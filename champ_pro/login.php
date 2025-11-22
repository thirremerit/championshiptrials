<?php
include "db.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Incorrect password";
        }
    } else {
        $error = "Email not found";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <h1>
        <img src="photos/Hipster_Walking/Hipster_Walking_1.png" alt="Mascot" id="mascot">
        CityCare
    </h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="signup.php">Sign Up</a>
    </nav>
</header>

<div class="container">
    <h2>Login</h2>
    <?php if(isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>
</div>

<footer>
    &copy; 2025 CityCare
</footer>

<script>
const mascot = document.getElementById('mascot');
const frames = [
    'photos/Hipster_Walking/Hipster_Walking_1.png',
    'photos/Hipster_Walking/Hipster_Walking_2.png',
    'photos/Hipster_Walking/Hipster_Walking_3.png',
    'photos/Hipster_Walking/Hipster_Walking_4.png'
];
let currentFrame = 0;
setInterval(() => {
    currentFrame = (currentFrame + 1) % frames.length;
    mascot.src = frames[currentFrame];
}, 200);
</script>

</body>
</html>
