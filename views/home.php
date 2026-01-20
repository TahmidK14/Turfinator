<?php require_once __DIR__ . '/layouts/header.php'; ?>
<?php
$featured = $featured ?? [];
$turfs = $turfs ?? [];
?>

<div class="card">
  <h2>Find a Turf. Book in Minutes.</h2>
  <p>Browse available turfs.</p>

  <?php if (!isset($_SESSION['user_id'])): ?>
    <div style="margin-top:12px; display:flex; gap:10px; flex-wrap:wrap;">
      <a href="index.php?page=login" class="btn btn-primary">Login</a>
      <a href="index.php?page=register" class="btn">Register</a>
    </div>
  <?php else: ?>
    <div style="margin-top:12px;">
      <a href="index.php?page=dashboard" class="btn btn-primary">Go to Dashboard</a>
    </div>
  <?php endif; ?>
</div>

<?php if (!empty($featured)): ?>
  <h2 style="margin-top:18px;">Featured Turfs</h2>
  <div class="grid">
    <?php foreach ($featured as $t): ?>
      <div class="card turf-card">
        <?php
          $img = $t['image'] ?? 'default.jpg';
          //$src = "assets/" . htmlspecialchars($img); // ✅ matches public/assets/
        ?>
<img src="assets/<?php echo htmlspecialchars($img); ?>" alt="Turf">


        <div class="turf-title">
          <h3><?php echo htmlspecialchars($t['name']); ?></h3>

          <span class="badge <?php echo ($t['status'] === 'active') ? 'badge-ok' : 'badge-no'; ?>">
            <?php echo ($t['status'] === 'active') ? 'Available' : 'Unavailable'; ?>
          </span>
        </div>

        <div class="meta"><?php echo htmlspecialchars($t['location']); ?></div>
        <div class="meta"><b><?php echo number_format((float)$t['price_per_hour'], 2); ?> / hr</b></div>

        <div style="margin-top:12px;">
          <a href="index.php?page=turf-details&id=<?php echo (int)$t['id']; ?>" class="btn btn-sm">View Details</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <hr style="margin:18px 0; border:none; border-top:1px solid var(--border);">
<?php endif; ?>

<h2 style="margin-top:16px;">All Turfs</h2>
<div class="grid">
  <?php if (empty($turfs)): ?>
    <div class="card" style="grid-column: 1 / -1;">No turfs available right now.</div>
  <?php endif; ?>

  <?php foreach ($turfs as $t): ?>
    <div class="card turf-card">
      <?php
        $img = $t['image'] ?? 'default.jpg';
        $src = "assets/turfs/uploads/" . htmlspecialchars($img); // ✅ matches public/assets/
      ?>
      <img src="<?php echo $src; ?>" alt="Turf">

      <div class="turf-title">
        <h3><?php echo htmlspecialchars($t['name']); ?></h3>

        <span class="badge <?php echo ($t['status'] === 'active') ? 'badge-ok' : 'badge-no'; ?>">
          <?php echo ($t['status'] === 'active') ? 'Available' : 'Unavailable'; ?>
        </span>
      </div>

      <div class="meta"><?php echo htmlspecialchars($t['location']); ?></div>
      <div class="meta"><b><?php echo number_format((float)$t['price_per_hour'], 2); ?> / hr</b></div>

      <div style="margin-top:12px;">
        <a href="index.php?page=turf-details&id=<?php echo (int)$t['id']; ?>" class="btn btn-sm">View Details</a>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php require_once __DIR__ . '/layouts/footer.php'; ?>
