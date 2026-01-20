<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="page stack">

  <div class="card">
    <div class="spread">
      <div>
        <h2>Admin Dashboard</h2>
        <p>Welcome, <b><?php echo htmlspecialchars($_SESSION['name'] ?? ''); ?></b></p>
      </div>


    </div>
  </div>

  <div class="grid">
    <div class="card">
      <h3>Add Manager</h3>
      <p>Create a manager account (admin-only).</p>
      <div class="row">
        <a class="btn btn-primary" href="index.php?page=manager-create">Add Manager</a>
      </div>
    </div>

    <div class="card">
      <h3>View Managers</h3>
      <p>See all manager accounts.</p>
      <div class="row">
        <a class="btn btn-primary" href="index.php?page=manager-list">View Managers</a>
      </div>
    </div>

    <div class="card">
      <h3>Quick Action</h3>
      <p>Manage your admin session.</p>
      <div class="row">
        <a class="btn btn-danger" href="index.php?page=logout">Logout</a>
      </div>
    </div>
  </div>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
