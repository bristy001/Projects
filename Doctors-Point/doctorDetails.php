<?php
include './db/config.php';

if (!isset($_GET['id'])) {
  die('<h2 style="color:red;text-align:center;margin-top:2rem">Invalid request</h2>');
}

$doctorId = intval($_GET['id']);

$stmt = mysqli_prepare($myconnect,
          "SELECT doctorName, specialistAt, imageURL FROM doctors WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $doctorId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) !== 1) {
  die('<h2 style="color:red;text-align:center;margin-top:2rem">Doctor not found</h2>');
}

$doctor = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/2ff2f6e9c4.js" crossorigin="anonymous"></script>
  <title>Doctor Details</title>
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

  <!-- ---------- Doctor Info ---------- -->
  <main class="w-[95%] mx-auto my-8">
    <div class="flex items-center gap-4">
      <div class="w-[100px] h-[100px] border-2 rounded-full overflow-hidden">
        <img src="<?= htmlspecialchars($doctor['imageURL']) ?>"
             alt="doctor image"
             class="w-[100px] h-[100px] rounded-full object-cover" />
      </div>
      <div>
        <h1 class="text-4xl font-semibold">
          <?= htmlspecialchars($doctor['doctorName']) ?>
        </h1>
        <p class="text-lg">
          <?= htmlspecialchars($doctor['specialistAt']) ?>
        </p>
      </div>
    </div>

    <!-- ---------- Static Schedule ---------- -->
    <div class="my-6">
      <h2 class="text-2xl font-semibold text-[#00c5ff]">Schedule</h2>
      <p class="text-lg">Monday – Friday: 9 AM – 5 PM</p>
      <p class="text-lg">Saturday: 10 AM – 2 PM</p>
      <p class="text-lg">Sunday: Closed</p>
    </div>

    <div>
      <a href="confirmAppointment.php?doctorId=<?= $doctorId ?>"
   class="btn bg-[#ffb600] text-white">
   Book Appointment
    </a>
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
