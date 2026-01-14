<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Register</h2>

<?php
if (!empty($_SESSION['errors'])) {
    echo "<ul>";
    foreach ($_SESSION['errors'] as $e) echo "<li>$e</li>";
    echo "</ul>";
    unset($_SESSION['errors']);
}
?>

<form method="POST" action="index.php?page=register-submit" id="registerForm">
    <input type="text" name="name" placeholder="Full Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="text" name="phone" placeholder="Phone"><br><br>


    <input type="password" name="password" placeholder="Password" required><br><br>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required><br><br>

    <button type="submit">Create Account</button>
</form>

<p><a href="index.php?page=login">Already have an account? Login</a></p>

<script src="/assets/app.js"></script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
