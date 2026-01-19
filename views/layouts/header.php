<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Turf Booking System</title>

    <!-- ✅ Correct relative paths -->
    <link rel="stylesheet" href="assets/styles.css">
    <script src="assets/app.js" defer></script>
</head>
<body>

<header>
<nav class="nav">
  <a href="index.php?page=home">Home</a>

  <?php if (isset($_SESSION['user_id'])): ?>
    <a href="index.php?page=dashboard">Dashboard</a>
    <a href="index.php?page=logout">Logout</a>
  <?php else: ?>
    <a href="index.php?page=login">Login</a>
    <a href="index.php?page=register">Register</a>
  <?php endif; ?>
</nav>

</header>
