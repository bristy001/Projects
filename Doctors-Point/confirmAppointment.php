<?php
include './db/config.php';

/* ───── 1. Get & validate doctorId from URL ───── */
if (!isset($_GET['doctorId'])) {
  die('<h2 style="color:red;text-align:center;margin-top:2rem">No doctor selected.</h2>');
}
$doctorId = intval($_GET['doctorId']);

/* ───── 2. Fetch doctor’s name for display ───── */
$stmt = mysqli_prepare($myconnect, "SELECT doctorName FROM doctors WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $doctorId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {
  die('<h2 style="color:red;text-align:center;margin-top:2rem">Doctor not found.</h2>');
}
$doctor = mysqli_fetch_assoc($result);
$doctorName = $doctor['doctorName'];

/* ───── 3. If the form was submitted, insert into DB ───── */
$insertSuccess = null;          // null = not submitted, true = ok, false = fail
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  /* Gather & basic‑validate POST data */
  $appointmentDay = trim($_POST['day'] ?? '');
  $patientName    = trim($_POST['patientName'] ?? '');
  $patientAge     = intval($_POST['patientAge'] ?? 0);

  if ($appointmentDay === '' || $patientName === '' || $patientAge <= 0) {
    $insertSuccess = false;   // invalid input
  } else {
    /* Insert into patients table */
    $ins = mysqli_prepare(
            $myconnect,
            "INSERT INTO patients (doctorName, appointmentDay, patientName, patientAge)
             VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($ins, "sssi",
                           $doctorName,
                           $appointmentDay,
                           $patientName,
                           $patientAge);

    $insertSuccess = mysqli_stmt_execute($ins);
    mysqli_stmt_close($ins);
  }
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

  <title>Confirm Appointment</title>
</head>
<body>
  <!-- ---------- Navbar (unchanged) ---------- -->
  <header>
    <div class="navbar bg-base-400 shadow-sm">
      <div class="navbar-start">
        <a class="btn btn-ghost text-2xl font-bold">Doctor's Point</a>
      </div>
      <div class="navbar-end">
        <a class="btn bg-[#ffb600] text-white">Admin</a>
      </div>
    </div>
  </header>

  <!-- ---------- Main ---------- -->
  <main class="min-h-[50vh]">
    <div class="w-[80%] mx-auto my-10">

<?php
/* ───── 4. Show success or error banner if form submitted ───── */
if ($insertSuccess === true) {
  echo '<div class="alert alert-success mb-6">🎉 Appointment booked successfully!</div>';
} elseif ($insertSuccess === false) {
  echo '<div class="alert alert-error mb-6">❌ Failed to book the appointment. Please check your input.</div>';
}

/* Show the form only if not inserted yet (or failed) */
if ($insertSuccess !== true):
?>
      <h2 class="text-3xl font-bold text-center my-10">Confirm Appointment</h2>

      <div class="card bg-base-200 shadow-sm p-6">
        <h3 class="text-xl font-semibold mb-4">Appointment Details</h3>
        <form action="" method="post" class="space-y-4">
          <!-- Doctor name (readonly) -->
          <div class="flex flex-col gap-2">
            <label class="label">Doctor's Name</label>
            <input type="text"
                   name="doctorName"
                   class="input w-full bg-base-100 cursor-not-allowed"
                   value="<?= htmlspecialchars($doctorName) ?>"
                   readonly />
          </div>

          <!-- Day -->
          <div class="flex flex-col gap-2">
            <label class="label">Day</label>
            <input type="text"
                   name="day"
                   class="input w-full"
                   placeholder="Day (e.g. Monday)"
                   required />
          </div>

          <!-- Patient name -->
          <div class="flex flex-col gap-2">
            <label class="label">Patient Name</label>
            <input type="text"
                   name="patientName"
                   class="input w-full"
                   placeholder="Patient Name"
                   required />
          </div>

          <!-- Patient age -->
          <div class="flex flex-col gap-2">
            <label class="label">Patient Age</label>
            <input type="number"
                   name="patientAge"
                   class="input w-full"
                   placeholder="Patient Age"
                   required />
          </div>
          <button type="submit" class="btn btn-neutral mt-4">
            Confirm Appointment
          </button>
        </form>
      </div>
<?php endif; ?>
    </div>
  </main>

  <!-- ---------- Footer (unchanged) ---------- -->
  <footer
      class="footer sm:footer-horizontal bg-base-300 text-base-content p-10"
    >
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
          <a>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              class="fill-current"
            >
              <path
                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"
              ></path>
            </svg>
          </a>
          <a>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              class="fill-current"
            >
              <path
                d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"
              ></path>
            </svg>
          </a>
          <a>
            <svg
              xmlns="http://www.w3.org/2000/svg"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              class="fill-current"
            >
              <path
                d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"
              ></path>
            </svg>
          </a>
        </div>
      </nav>
    </footer>
</body>
</html>
