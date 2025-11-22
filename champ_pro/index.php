<!DOCTYPE html>
<html>
<head>
    <title>CityCare - Home</title>
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
    </nav>
</header>

<div class="container hero">
    <h2>Welcome to CityCare</h2>
    <p>A simple platform where citizens can report local issues like potholes, broken lights, trash, or road damage.</p>
    
    <div>
        <a href="report.php" class="btn">Report an Issue</a>
        <a href="issues.php" class="btn">View Issues</a>
    </div>
</div>

<footer>
    &copy; 2025 CityCare
</footer>

<!-- Mascot Animation Script -->
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
}, 200); // adjust 200ms for faster/slower animation
</script>

</body>
</html>
