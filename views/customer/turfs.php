<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="page stack">

<h2>Browse Turfs</h2>

<?php
if (!empty($_SESSION['errors'])) {
  echo "<ul>";
  foreach ($_SESSION['errors'] as $e) echo "<li>$e</li>";
  echo "</ul>";
  unset($_SESSION['errors']);
}
?>
<input type="text" id="searchBox" placeholder="Search by name or location">

<p>
  <a href="index.php?page=dashboard">Back to Dashboard</a> |
  <a href="index.php?page=logout">Logout</a>
</p>

<table border="1" cellpadding="8" id="turfTable">
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
          <a href="index.php?page=turf-details&id=<?php echo $t['id']; ?>">View</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
