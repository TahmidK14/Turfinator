<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Turfinator</title>
  <link rel="stylesheet" href="assets/styles.css">
  <script src="assets/app.js" defer></script>
</head>
<body>

<header class="site-header">
  <div class="container bar">
    <div class="brand">Turfinator</div>

    <nav class="nav">
      <a href="index.php?page=home">Home</a>

      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="index.php?page=dashboard">Dashboard</a>
        <a href="index.php?page=profile">Profile</a>
        <a href="index.php?page=logout">Logout</a>
      <?php else: ?>
        <a href="index.php?page=login">Login</a>
        <a href="index.php?page=register">Register</a>
      <?php endif; ?>

      <button type="button" id="themeToggle" class="btn btn-sm">Theme</button>
    </nav>
  </div>
</header>

<div class="container">
