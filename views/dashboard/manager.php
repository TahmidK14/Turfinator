<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="page stack">

  <div class="card">
    <div class="spread">
      <div>
        <h2>Manager Dashboard</h2>
        <p>Welcome, <b><?php echo htmlspecialchars($_SESSION['name'] ?? ''); ?></b></p>
      </div>

    </div>
  </div>

  <div class="grid">
    <div class="card">
      <h3>Manage Turfs</h3>
      <p>Add, edit, delete, and update your turfs.</p>
      <div class="row">
        <a class="btn btn-primary" href="index.php?page=manager-turfs">My Turfs</a>
        <a class="btn btn-primary" href="index.php?page=turf-create">Add Turf</a>
      </div>
    </div>

    <div class="card">
      <h3>Manage Bookings</h3>
      <p>Approve or cancel bookings for your turfs.</p>
      <div class="row">
        <a class="btn btn-primary" href="index.php?page=manage-bookings">Manage Bookings</a>
      </div>
    </div>

    <div class="card">
      <h3>Customer List</h3>
      <p>See customers booked.</p>
      <div class="row">
        <a class="btn btn-primary" href="index.php?page=manager-customers">View Customers</a>
      </div>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
