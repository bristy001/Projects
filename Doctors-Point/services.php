<?php ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Tailwind + DaisyUI -->
    <link
      href="https://cdn.jsdelivr.net/npm/daisyui@5"
      rel="stylesheet"
      type="text/css"
    />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Font Awesome -->
    <script
      src="https://kit.fontawesome.com/2ff2f6e9c4.js"
      crossorigin="anonymous"
    ></script>

    <title>Services | Doctor's Point</title>
  </head>
  <body class="bg-base-200">
    <!-- ───── Navbar (same as other pages) ───── -->
    <header>
      <nav class="navbar bg-base-400 shadow-sm">
        <div class="navbar-start">
          <a href="index.php" class="btn btn-ghost text-2xl font-bold">
            Doctor's Point
          </a>
        </div>
        <div class="navbar-center hidden lg:flex">
          <ul class="menu menu-horizontal px-1 font-semibold">
            <li><a href="index.php">Home</a></li>
            <li  class="border-2 rounded"><a href="./services.php">Services</a></li>
            <li><a href="./contact.php">Contact</a></li>
          </ul>
        </div>
        <div class="navbar-end">
          <a class="btn bg-[#ffb600] text-white">Admin</a>
        </div>
      </nav>
    </header>

    <!-- ───── Main Content ───── -->
    <main class="w-[90%] mx-auto my-12 space-y-16">
      <!-- Hero / Intro -->
      <section class="hero bg-base-100 rounded shadow-sm">
        <div class="hero-content flex-col lg:flex-row-reverse">
          <div class="space-y-4">
            <h1 class="text-5xl font-bold">
              Comprehensive Healthcare at Your Fingertips
            </h1>
            <p class="text-lg leading-relaxed">
              Doctor's Point connects you with top‑rated physicians, advanced
              diagnostics, and personalized wellness plans—all from a single,
              easy‑to‑use platform. Explore our range of services below.
            </p>
            <a href="#serviceGrid" class="btn bg-[#ffb600] text-white">
              Explore&nbsp;Services
            </a>
          </div>
        </div>
      </section>

      <!-- Services Grid -->
      <section id="serviceGrid">
        <h2 class="text-4xl font-bold text-center mb-10">Our Services</h2>

        <div class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
          <!-- Service Card 1 -->
          <div class="card bg-base-100 shadow-md">
            <figure class="pt-6">
              <i
                class="fa-solid fa-laptop-medical text-5xl text-[#ffb600]"
              ></i>
            </figure>
            <div class="card-body items-center text-center">
              <h3 class="card-title">Online Consultation</h3>
              <p>
                Video or chat with certified specialists from the comfort of
                your home—no waiting rooms required.
              </p>
            </div>
          </div>

          <!-- Service Card 2 -->
          <div class="card bg-base-100 shadow-md">
            <figure class="pt-6">
              <i
                class="fa-solid fa-calendar-check text-5xl text-[#ffb600]"
              ></i>
            </figure>
            <div class="card-body items-center text-center">
              <h3 class="card-title">Appointment Booking</h3>
              <p>
                Real‑time scheduling that lets you pick your preferred doctor,
                date, and time in seconds.
              </p>
            </div>
          </div>

          <!-- Service Card 3 -->
          <div class="card bg-base-100 shadow-md">
            <figure class="pt-6">
              <i class="fa-solid fa-flask text-5xl text-[#ffb600]"></i>
            </figure>
            <div class="card-body items-center text-center">
              <h3 class="card-title">Diagnostic Lab</h3>
              <p>
                Access a full range of lab tests and receive digital reports
                directly in your dashboard.
              </p>
            </div>
          </div>

          <!-- Service Card 4 -->
          <div class="card bg-base-100 shadow-md">
            <figure class="pt-6">
              <i
                class="fa-solid fa-prescription-bottle-medical text-5xl text-[#ffb600]"
              ></i>
            </figure>
            <div class="card-body items-center text-center">
              <h3 class="card-title">E‑Prescriptions</h3>
              <p>
                Doctors can send secure digital prescriptions straight to your
                device—and your preferred pharmacy.
              </p>
            </div>
          </div>

          <!-- Service Card 5 -->
          <div class="card bg-base-100 shadow-md">
            <figure class="pt-6">
              <i class="fa-solid fa-heart-pulse text-5xl text-[#ffb600]"></i>
            </figure>
            <div class="card-body items-center text-center">
              <h3 class="card-title">Wellness Programs</h3>
              <p>
                Personalized diet, exercise, and mental‑health plans developed
                by our team of wellness experts.
              </p>
            </div>
          </div>

          <!-- Service Card 6 -->
          <div class="card bg-base-100 shadow-md">
            <figure class="pt-6">
              <i
                class="fa-solid fa-headset text-5xl text-[#ffb600]"
              ></i>
            </figure>
            <div class="card-body items-center text-center">
              <h3 class="card-title">24/7 Support</h3>
              <p>
                Our dedicated support team is always available to help you with
                any questions or concerns.
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- CTA -->
      <section class="text-center mt-20">
        <h3 class="text-3xl font-bold mb-4">
          Ready to take charge of your health?
        </h3>
        <p class="mb-6">
          Sign up today and experience hassle‑free healthcare with Doctor's
          Point.
        </p>
        <a href="index.php" class="btn bg-[#ffb600] text-white">
          Get&nbsp;Started
        </a>
      </section>
    </main>

    <!-- ───── Footer (same as other pages) ───── -->
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
        <a class="link link-hover">About&nbsp;Us</a>
        <a class="link link-hover">Contact</a>
        <a class="link link-hover">Jobs</a>
        <a class="link link-hover">Press Kit</a>
      </nav>
      <nav>
        <h6 class="footer-title">Social</h6>
        <div class="grid grid-flow-col gap-4">
          <a href="#"><i class="fa-brands fa-facebook text-xl"></i></a>
          <a href="#"><i class="fa-brands fa-x-twitter text-xl"></i></a>
          <a href="#"><i class="fa-brands fa-linkedin text-xl"></i></a>
        </div>
      </nav>
    </footer>
  </body>
</html>
