<?php
include './db/config.php';

/* Pull all appointments */
$sql = "
  SELECT id, doctorName, appointmentDay, patientName, patientAge
  FROM   patients
  ORDER  BY STR_TO_DATE(appointmentDay, '%Y-%m-%d') ASC, id ASC
";
$result = mysqli_query($myconnect, $sql);

if (!$result) {
  die('Database error: ' . mysqli_error($myconnect));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind & DaisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <!-- FontAwesome (icons) -->
  <script src="https://kit.fontawesome.com/2ff2f6e9c4.js" crossorigin="anonymous"></script>

  <title>All Appointments</title>
</head>
<body class="bg-base-200">
  <!-- ---------- Navbar ---------- -->
  <header>
    <div class="navbar bg-base-400 shadow-sm">
      <div class="navbar-start">
        <a href="index.php" class="btn btn-ghost text-2xl font-bold">Doctor's Point</a>
      </div>
      <div class="navbar-end">
        <a class="btn bg-[#ffb600] text-white">Admin</a>
      </div>
    </div>
  </header>

  <!-- ---------- Main ---------- -->
  <main class="w-[90%] min-h-[50vh] mx-auto my-10">
    <h2 class="text-3xl font-bold text-center mb-8">All Appointments</h2>

<?php if (mysqli_num_rows($result) === 0): ?>
    <div class="alert alert-info shadow-lg">
      <span>No appointments found.</span>
    </div>
<?php else: ?>
    <div class="overflow-x-auto">
      <table class="table table-zebra w-full">
        <thead>
          <tr>
            <th class="text-center">#</th>
            <th>Doctor</th>
            <th>Day (YYYY‑MM‑DD)</th>
            <th>Patient</th>
            <th class="text-center">Age</th>
          </tr>
        </thead>
        <tbody>
        <?php $serial = 1; ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td class="text-center"><?= $serial++ ?></td>
            <td><?= htmlspecialchars($row['doctorName']) ?></td>
            <td><?= htmlspecialchars($row['appointmentDay']) ?></td>
            <td><?= htmlspecialchars($row['patientName']) ?></td>
            <td class="text-center"><?= htmlspecialchars($row['patientAge']) ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
<?php endif; ?>
  </main>

  <!-- ---------- Footer ---------- -->
  <footer class="footer sm:footer-horizontal bg-base-300 text-base-content p-10">
    <nav>
      <h6 class="footer-title">Services</h6>
      <a class="link link-hover">Branding</a>
      <a class="link link-hover">Design</a>
      <a class="link link-hover">Marketing</a>
      <a class="link link-hover">Advertisement</a>
    </nav>
    <nav>
      <h6 class="footer-title">Company</h6>
      <a class="link link-hover">About us</a>
      <a class="link link-hover">Contact</a>
      <a class="link link-hover">Jobs</a>
      <a class="link link-hover">Press kit</a>
    </nav>
    <nav>
      <h6 class="footer-title">Social</h6>
      <div class="grid grid-flow-col gap-4">
        <!-- social icons here -->
      </div>
    </nav>
  </footer>
</body>
</html>
