<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="page stack">

<h2>My Customers</h2>

<p>
  <a href="index.php?page=dashboard">Back to Dashboard</a> |
  <a href="index.php?page=logout">Logout</a>
</p>

<?php if (empty($customers)): ?>
  <div class="card">No customers yet. Customers will appear after bookings are made.</div>
<?php else: ?>
  <table class="table" border="1" cellpadding="8" cellspacing="0">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Total Bookings</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($customers as $c): ?>
        <tr>
          <td><?php echo htmlspecialchars($c['name'] ?? ''); ?></td>
          <td><?php echo htmlspecialchars($c['email'] ?? ''); ?></td>
          <td><?php echo htmlspecialchars($c['phone'] ?? ''); ?></td>
          <td><?php echo (int)($c['bookings_count'] ?? 0); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
