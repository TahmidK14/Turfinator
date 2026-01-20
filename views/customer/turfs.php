<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="page stack">

  <?php
  if (!empty($_SESSION['errors'])) {
    echo '<div class="alert error"><ul style="margin:0; padding-left:18px;">';
    foreach ($_SESSION['errors'] as $e) echo '<li>' . htmlspecialchars($e) . '</li>';
    echo '</ul></div>';
    unset($_SESSION['errors']);
  }
  ?>

  <div class="card">
    <div class="spread">
      <h2>Browse Turfs</h2>

    </div>

    <div class="divider"></div>

    <input class="input" type="text" id="searchBox" placeholder="Search by name or location">
  </div>

  <table class="table" id="turfTable" style="margin-top:12px;">
    <thead>
      <tr>
        <th>Name</th>
        <th>Location</th>
        <th>Price/hr</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody id="turfBody">
      <?php foreach ($turfs as $t): ?>
        <tr>
          <td><?php echo htmlspecialchars($t['name']); ?></td>
          <td><?php echo htmlspecialchars($t['location']); ?></td>
          <td><?php echo number_format((float)$t['price_per_hour'], 2); ?></td>
          <td>
            <a class="btn btn-sm" href="index.php?page=turf-details&id=<?php echo (int)$t['id']; ?>">View</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
