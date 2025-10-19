<?php
session_start();
include './db/config.php';

/* Hard‑coded admin creds (demo only) */
const ADMIN_USER = 'admin';
const ADMIN_PASS = 'doctor123';

/* ─── Handle admin‑login form ─── */
$loginError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['adminLogin'])) {
  $user = trim($_POST['username'] ?? '');
  $pass = trim($_POST['password'] ?? '');

  if ($user === ADMIN_USER && $pass === ADMIN_PASS) {
    /* Auth OK → redirect to admin dashboard */
    header('Location: admin.php');
    exit;
  } else {
    $loginError = 'Invalid username or password.';
  }
}

/* ─── Fetch doctors for cards ─── */
$sql    = "SELECT * FROM doctors";
$result = mysqli_query($myconnect, $sql);
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

  <title>Home | Doctor's Point</title>
</head>
<body>
  <!-- ───────── Header / Navbar ───────── -->
  <header class="bg-[#fff8e8]">
    <div class="navbar bg-base-400 shadow-sm">
      <div class="navbar-start">
        <a href="index.php" class="btn btn-ghost text-2xl font-bold">Doctor's Point</a>
      </div>

      <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1 font-semibold">
          <li class="border-2 rounded"><a href="index.php">Home</a></li>
          <li><a href="services.php">Services</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
      </div>

      <!-- Admin button triggers modal -->
      <div class="navbar-end">
        <!-- The label+htmlFor trick toggles DaisyUI modal -->
        <label for="adminModal" class="btn bg-[#ffb600] text-white cursor-pointer">
          Admin
        </label>
      </div>
    </div>
  </header>

  <!-- ───────── Banner ───────── -->
  <section class="hero min-h-[70vh] w-[80%] mx-auto">
    <div class="hero-content flex-col lg:flex-row">
      <img src="./images/doctor.png" alt="Doctor illustration" class="max-w-sm rounded-lg" />
      <div class="space-y-8">
        <h1 class="text-5xl font-bold">Discover Health: Find Your Trusted Doctors Today</h1>
        <a href="#OurDoctors" class="btn bg-[#ffb600] text-white">Get Started</a>
      </div>
    </div>
  </section>

  <!-- ───────── Features ───────── -->
  <section
    class="relative w-[65%] mx-auto flex justify-between bg-base-100 px-[5%] py-[2%] rounded shadow-lg -mt-10 z-10">
    <div class="flex flex-col items-center">
      <i class="fa-solid fa-calendar-check bg-[#ffb600] p-4 rounded-full text-xl"></i>
      <h3 class="text-xl font-bold">Book Appointment</h3>
    </div>
    <div class="flex flex-col items-center">
      <i class="fa-solid fa-user-doctor bg-[#ffb600] p-4 rounded-full text-xl"></i>
      <h3 class="text-xl font-bold">Doctors Panel</h3>
    </div>
    <div class="flex flex-col items-center">
      <i class="fa-solid fa-flask bg-[#ffb600] p-4 rounded-full text-xl"></i>
      <h3 class="text-xl font-bold">Lab Testing</h3>
    </div>
  </section>

  <!-- ───────── Doctors Grid ───────── -->
  <main>
    <section id="OurDoctors" class="w-[80%] mx-auto my-10">
      <h2 class="text-3xl font-bold text-center my-10">Our Doctors</h2>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (mysqli_num_rows($result) > 0):
                while ($row = mysqli_fetch_assoc($result)): ?>
          <div class="card bg-base-100 shadow-sm">
            <figure><img src="<?= htmlspecialchars($row['imageURL']) ?>" alt="doctor image" /></figure>
            <div class="card-body">
              <h2 class="text-2xl font-semibold"><?= htmlspecialchars($row['doctorName']) ?></h2>
              <p>Specialist in <?= htmlspecialchars($row['specialistAt']) ?></p>
              <hr />
              <div class="card-actions justify-between items-center">
                <div>
                  <h4 class="text-lg">Consultation Fees</h4>
                  <p class="text-xl font-bold">$<?= htmlspecialchars($row['fees']) ?></p>
                </div>
                <a href="doctorDetails.php?id=<?= $row['id'] ?>"
                   class="btn bg-[#ffb600] text-white">Book Now</a>
              </div>
            </div>
          </div>
        <?php endwhile;
              else: ?>
          <p class="col-span-3 text-center">No doctors available right now.</p>
        <?php endif; ?>
      </div>
    </section>
  </main>

  <!-- ───────── Footer (unchanged) ───────── -->
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
      <a class="link link-hover">About Us</a>
      <a class="link link-hover">Contact</a>
      <a class="link link-hover">Jobs</a>
      <a class="link link-hover">Press Kit</a>
    </nav>
    <nav>
      <h6 class="footer-title">Social</h6>
      <div class="grid grid-flow-col gap-4">
        <a><i class="fa-brands fa-facebook"></i></a>
        <a><i class="fa-brands fa-x-twitter"></i></a>
        <a><i class="fa-brands fa-linkedin"></i></a>
      </div>
    </nav>
  </footer>

  <!-- ───────── Admin Login Modal ───────── -->
  <input type="checkbox" id="adminModal" class="modal-toggle" <?php if($loginError) echo 'checked'; ?> />
  <div class="modal" role="dialog">
    <div class="modal-box">
      <h3 class="font-bold text-lg mb-4 flex items-center gap-2">
        <i class="fa-solid fa-user-shield"></i> Admin Login
      </h3>

      <?php if ($loginError): ?>
        <div class="alert alert-error mb-4">
          <span><?= htmlspecialchars($loginError) ?></span>
        </div>
      <?php endif; ?>

      <form action="" method="post" class="space-y-4">
        <input type="hidden" name="adminLogin" value="1" />
        <div class="form-control">
          <label class="label">Username</label>
          <input type="text" name="username" class="input input-bordered w-full" required />
        </div>
        <div class="form-control">
          <label class="label">Password</label>
          <input type="password" name="password" class="input input-bordered w-full" required />
        </div>
        <div class="modal-action">
          <button class="btn btn-neutral">Login</button>
          <label for="adminModal" class="btn">Close</label>
        </div>
      </form>
    </div>
    <label class="modal-backdrop" for="adminModal"></label>
  </div>
</body>
</html>
