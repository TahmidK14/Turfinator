<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<div class="page stack">

<h2>Add New Turf</h2>

<?php
if (!empty($_SESSION['errors'])) {
  echo "<ul>";
  foreach ($_SESSION['errors'] as $e) echo "<li>$e</li>";
  echo "</ul>";
  unset($_SESSION['errors']);
}
?>

<form method="POST" action="index.php?page=turf-store" id="turfForm" enctype="multipart/form-data">
  <input type="text" name="name" placeholder="Turf Name" required><br><br>
  <input type="text" name="location" placeholder="Location" required><br><br>
  <input type="text" name="price_per_hour" placeholder="Price per hour" required><br><br>
  <textarea name="description" placeholder="Description (optional)" rows="4" cols="40"></textarea><br><br>

  <label><b>Turf Image (required)</b></label><br>
  <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" required><br><br>

  <select name="status">
    <option value="active">Active</option>
    <option value="inactive">Inactive</option>
  </select><br><br>

  <button type="submit">Save</button>
</form>


<p><a href="index.php?page=manager-turfs">Back</a></p>

<script src="assets/app.js" defer></script>

</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
