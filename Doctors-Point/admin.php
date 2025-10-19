<?php
/******************************************************************
 * admin.php – Admin dashboard: add doctors + view appointments
 ******************************************************************/
include './db/config.php';

/* ─────────────────────────────
   1. Handle “Add Doctor” form
   ───────────────────────────── */
$addStatus = null;   // null = not submitted, true = success, false = error
$addError  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // sanitize + basic validation
  $doctorName   = trim($_POST['doctorName']   ?? '');
  $specialistAt = trim($_POST['specialistAt'] ?? '');
  $fees         = intval($_POST['fees']       ?? 0);
  $imageURL     = trim($_POST['imageURL']     ?? '');

  if ($doctorName === '' || $specialistAt === '' || $fees <= 0 || $imageURL === '') {
    $addStatus = false;
    $addError  = 'All fields are required and fees must be > 0.';
  } else {
    $stmt = mysqli_prepare(
              $myconnect,
              "INSERT INTO doctors (doctorName, specialistAt, fees, imageURL)
               VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssis",
                           $doctorName,
                           $specialistAt,
                           $fees,
                           $imageURL);
    $addStatus = mysqli_stmt_execute($stmt);
    if (!$addStatus) {
      $addError = mysqli_error($myconnect);
    }
    mysqli_stmt_close($stmt);
  }
}

/* ─────────────────────────────
   2. Fetch all appointments
   ───────────────────────────── */
$apptSql = "
  SELECT id, doctorName, appointmentDay, patientName, patientAge
  FROM   patients
  ORDER  BY STR_TO_DATE(appointmentDay,'%Y-%m-%d') ASC, id ASC
";
$appointments = mysqli_query($myconnect, $apptSql);
if (!$appointments) {
  die('Could not load appointments: ' . mysqli_error($myconnect));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind & DaisyUI -->
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <!-- Icons -->
  <script src="https://kit.fontawesome.com/2ff2f6e9c4.js" crossorigin="anonymous"></script>

  <title>Admin Panel</title>
</head>
<body class="bg-base-200">
  <!-- ---------- Header ---------- -->
  <header class="navbar bg-base-400 shadow-sm">
    <div class="navbar-start">
      <a href="index.php" class="btn btn-ghost text-2xl font-bold">Doctor's Point Admin</a>
    </div>
    <div class="navbar-end pr-4">
      <a href="index.php" class="btn btn-sm bg-[#ffb600] text-white">
        <i class="fa-solid fa-right-to-bracket mr-2"></i>Back to Site
      </a>
    </div>
  </header>

  <!-- ---------- Main ---------- -->
  <main class="w-[90%] mx-auto my-10 space-y-16">

    <!-- ========= Add Doctor ========= -->
    <section id="addDoctor">
      <h2 class="text-3xl font-bold mb-6 flex items-center gap-2">
        <i class="fa-solid fa-user-doctor"></i> Add Doctor
      </h2>

      <!-- Success / error banners -->
      <?php if ($addStatus === true): ?>
        <div class="alert alert-success mb-6">
          <i class="fa-solid fa-check-circle"></i>
          <span>Doctor added successfully!</span>
        </div>
      <?php elseif ($addStatus === false): ?>
        <div class="alert alert-error mb-6">
          <i class="fa-solid fa-circle-exclamation"></i>
          <span><?= htmlspecialchars($addError) ?></span>
        </div>
      <?php endif; ?>

      <form method="POST"
            class="card bg-base-100 shadow-lg p-8 space-y-4 max-w-2xl">

        <div class="form-control">
          <label class="label">Doctor's Name</label>
          <input type="text"
                 name="doctorName"
                 class="input input-bordered w-full"
                 placeholder="Dr. John Doe"
                 required />
        </div>

        <div class="form-control">
          <label class="label">Specialist At</label>
          <input type="text"
                 name="specialistAt"
                 class="input input-bordered w-full"
                 placeholder="Cardiology"
                 required />
        </div>

        <div class="form-control">
          <label class="label">Fees (USD)</label>
          <input type="number"
                 name="fees"
                 class="input input-bordered w-full"
                 placeholder="100"
                 min="1"
                 required />
        </div>

        <div class="form-control">
          <label class="label">Image URL</label>
          <input type="url"
                 name="imageURL"
                 class="input input-bordered w-full"
                 placeholder="https://example.com/doctor.jpg"
                 required />
        </div>

        <button class="btn btn-neutral">
          <i class="fa-solid fa-plus mr-2"></i> Add Doctor
        </button>
      </form>
    </section>

    <!-- ========= Appointments ========= -->
    <section id="appointments">
      <h2 class="text-3xl font-bold mb-6 flex items-center gap-2">
        <i class="fa-solid fa-calendar-check"></i> All Appointments
      </h2>

      <?php if (mysqli_num_rows($appointments) === 0): ?>
        <div class="alert alert-info">
          <span>No appointments found.</span>
        </div>
      <?php else: ?>
        <div class="overflow-x-auto">
          <table class="table table-zebra w-full">
            <thead>
              <tr>
                <th>#</th>
                <th>Doctor</th>
                <th>Date / Day</th>
                <th>Patient</th>
                <th class="text-center">Age</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; ?>
              <?php while ($row = mysqli_fetch_assoc($appointments)): ?>
                <tr>
                  <td><?= $i++ ?></td>
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
    </section>
  </main>

  <!-- ---------- Footer ---------- -->
  <footer class="footer justify-center bg-base-300 p-4">
    <p class="text-sm opacity-70">© <?= date('Y') ?> Doctor's Point. All rights reserved.</p>
  </footer>
</body>
</html>
