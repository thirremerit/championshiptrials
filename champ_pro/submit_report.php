<?php
include "db.php";
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$title = $_POST['title'];
$description = $_POST['description'];
$category = $_POST['category'];
$location = $_POST['location'];
$user_id = $_SESSION['user_id'];

$photoName = NULL;
if (!empty($_FILES['photo']['name'])) {
    $photoName = time() . "_" . $_FILES['photo']['name'];
    move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/" . $photoName);
}

$sql = "INSERT INTO issues (title, description, category, location, photo, user_id)
        VALUES ('$title', '$description', '$category', '$location', '$photoName', $user_id)";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Report Submitted</title>
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
        <a href="report.php">Report Issue</a>
        <a href="issues.php">View Issues</a>
        <a href="logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a>
    </nav>
</header>

<div class="container" style="text-align:center;">
    <?php
    if ($conn->query($sql)) {
        echo "<div class='issue-card' style='padding:40px;'>";
        echo "<h2>🎉 Issue Reported Successfully!</h2>";
        echo "<p>Thank you, <strong>".$_SESSION['username']."</strong>! Your issue has been submitted.</p>";
        echo "<a href='index.php' class='btn' style='margin-top:20px;'>Go to Home</a> ";
        echo "<a href='report.php' class='btn' style='margin-top:20px;'>Report Another Issue</a>";
        echo "</div>";
    } else {
        echo "<div class='issue-card' style='padding:40px;'>";
        echo "<h2>❌ Error Reporting Issue</h2>";
        echo "<p>There was an error submitting your report: ".$conn->error."</p>";
        echo "<a href='report.php' class='btn' style='margin-top:20px;'>Try Again</a>";
        echo "</div>";
    }
    ?>
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
