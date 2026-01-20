<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="page stack">

  <div class="card">
    <div class="spread">
      <div>
        <h2>Customer Dashboard</h2>
        <p>Welcome, <b><?php echo htmlspecialchars($_SESSION['name'] ?? ''); ?></b></p>
      </div>

    </div>
  </div>

  <div class="grid">
    <div class="card">
      <h3>Browse Turfs</h3>
      <p>Search and view available turfs.</p>
      <div class="row">
        <a class="btn btn-primary" href="index.php?page=turfs">Search Turfs</a>
      </div>
    </div>

    <div class="card">
      <h3>My Bookings</h3>
      <p>Track your bookings and cancel if needed.</p>
      <div class="row">
        <a class="btn btn-primary" href="index.php?page=my-bookings">My Bookings</a>
      </div>
    </div>

    <div class="card">
      <h3>Account</h3>
      <p>Update profile or change password.</p>
      <div class="row">
        <a class="btn btn-primary" href="index.php?page=profile">My Profile</a>
      </div>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
