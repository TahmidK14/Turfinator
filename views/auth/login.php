<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="page stack">

<h2>Login</h2>

<?php
if (!empty($_SESSION['success'])) {
    echo "<p>" . $_SESSION['success'] . "</p>";
    unset($_SESSION['success']);
}

if (!empty($_SESSION['errors'])) {
    echo "<ul>";
    foreach ($_SESSION['errors'] as $e) echo "<li>$e</li>";
    echo "</ul>";
    unset($_SESSION['errors']);
}
?>

<form method="POST" action="index.php?page=login-submit" id="loginForm">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Login</button>
</form>

<p><a href="index.php?page=register">Create account</a></p>

<script src="/assets/app.js"></script>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
