<?php
include "db_connect.php";
session_start();

if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$title       = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$category    = $_POST['category'] ?? '';
$location    = $_POST['location'] ?? '';
$user_id     = $_SESSION['user_id'];

// Convert coordinates to float or null
$lat = isset($_POST['lat']) && $_POST['lat'] !== '' ? floatval($_POST['lat']) : null;
$lng = isset($_POST['lng']) && $_POST['lng'] !== '' ? floatval($_POST['lng']) : null;

$photoName = NULL;
if (!empty($_FILES['photo']['name'])) {
    $photoName = time() . "_" . basename($_FILES['photo']['name']);
    move_uploaded_file($_FILES['photo']['tmp_name'], "uploads/" . $photoName);
}

// Insert into database including coordinates
$stmt = $conn->prepare("INSERT INTO issues (title, description, category, location, photo, user_id, lat, lng) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param(
    "ssssssdd",
    $title,
    $description,
    $category,
    $location,
    $photoName,
    $user_id,
    $lat,
    $lng
);
$ok = $stmt->execute();
$error = $stmt->error;
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Report Submitted</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>CityCare</h1>
    <nav>
        <a href="index.php">Home</a>
        <a href="report.php">Report Issue</a>
        <a href="issues.php">View Issues</a>
        <a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?>)</a>
    </nav>
</header>
<div class="container" style="text-align:center;">
<?php
if ($ok) {
    echo "<h2>🎉 Issue Reported Successfully!</h2>";
    echo "<p>Your issue has been submitted.</p>";
    echo "<p><a href='issues.php'>View Issues</a> | <a href='report.php'>Report another</a></p>";
} else {
    echo "<h2>❌ Error Reporting Issue</h2>";
    echo "<p>There was an error: " . htmlspecialchars($error) . "</p>";
    echo "<p><a href='report.php'>Try Again</a></p>";
}
?>
</div>
</body>
</html>
