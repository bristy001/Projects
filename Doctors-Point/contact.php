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

    <title>Contact Us | Doctor's Point</title>
  </head>
  <body class="bg-base-200">
    <!-- ───── Navbar (shared) ───── -->
    <header>
      <nav class="navbar bg-base-400 shadow-sm">
        <div class="navbar-start">
          <a href="index.php" class="btn btn-ghost text-2xl font-bold">
            Doctor's Point
          </a>
        </div>
        <div class="navbar-center hidden lg:flex">
          <ul class="menu menu-horizontal px-1 font-semibold">
            <li><a href="./index.php">Home</a></li>
            <li><a href="./services.php">Services</a></li>
            <li class="border-2 rounded"><a href="./contact.php">Contact</a></li>
          </ul>
        </div>
        <div class="navbar-end">
          <a class="btn bg-[#ffb600] text-white">Admin</a>
        </div>
      </nav>
    </header>

    <!-- ───── Main Content ───── -->
    <main class="w-[90%] mx-auto my-12 space-y-16">
      <!-- Hero -->
      <section class="hero bg-base-100 rounded shadow-sm">
        <div class="hero-content flex-col lg:flex-row">
          <div class="space-y-4">
            <h1 class="text-5xl font-bold">We’d Love to Hear From You</h1>
            <p class="text-lg leading-relaxed">
              Whether you have a question about appointments, services, pricing,
              or anything else, our team is ready to answer all your questions.
            </p>
            <a href="#contactForm" class="btn bg-[#ffb600] text-white">
              Send&nbsp;a&nbsp;Message
            </a>
          </div>
        </div>
      </section>

      <!-- Contact Details -->
      <section>
        <h2 class="text-4xl font-bold text-center mb-10">Contact Details</h2>
        <div
          class="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 text-center"
        >
          <div class="card bg-base-100 shadow-md p-6">
            <i class="fa-solid fa-location-dot text-4xl text-[#ffb600]"></i>
            <h3 class="mt-4 font-semibold">Address</h3>
            <p>123 Health Street, Dhaka 1205, Bangladesh</p>
          </div>

          <div class="card bg-base-100 shadow-md p-6">
            <i class="fa-solid fa-phone text-4xl text-[#ffb600]"></i>
            <h3 class="mt-4 font-semibold">Phone</h3>
            <p>+880&nbsp;1XXX‑XXX‑XXX (24/7)</p>
          </div>

          <div class="card bg-base-100 shadow-md p-6">
            <i class="fa-solid fa-envelope text-4xl text-[#ffb600]"></i>
            <h3 class="mt-4 font-semibold">Email</h3>
            <p>support@doctorspoint.com</p>
          </div>
        </div>
      </section>

      <!-- Contact Form -->
      <section id="contactForm" class="max-w-3xl mx-auto">
        <h2 class="text-4xl font-bold text-center mb-6">Send Us a Message</h2>
        <form
          action="#"
          method="post"
          class="card bg-base-100 shadow-lg p-8 space-y-4"
        >
          <div class="form-control">
            <label class="label">Name</label>
            <input
              type="text"
              name="name"
              class="input input-bordered w-full"
              placeholder="Your Name"
              required
            />
          </div>

          <div class="form-control">
            <label class="label">Email</label>
            <input
              type="email"
              name="email"
              class="input input-bordered w-full"
              placeholder="you@example.com"
              required
            />
          </div>

          <div class="form-control">
            <label class="label">Subject</label>
            <input
              type="text"
              name="subject"
              class="input input-bordered w-full"
              placeholder="Subject"
              required
            />
          </div>

          <div class="form-control">
            <label class="label">Message</label>
            <textarea
              name="message"
              class="textarea textarea-bordered w-full"
              rows="5"
              placeholder="Type your message..."
              required
            ></textarea>
          </div>

          <button class="btn bg-[#ffb600] text-white">
            <i class="fa-solid fa-paper-plane mr-2"></i>Send Message
          </button>
        </form>
      </section>

      <!-- Embedded Map (optional) -->
      <section class="mt-20">
        <h2 class="text-4xl font-bold text-center mb-6">Find Us</h2>
        <div class="w-full h-80 rounded overflow-hidden shadow-md">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.8482672267985!2d90.40113621498255!3d23.75270259413796!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755bf5d2dd95b7b%3A0x8d1dc0f0c4dc3945!2sDhaka!5e0!3m2!1sen!2sbd!4v1700000000000"
            width="100%"
            height="100%"
            style="border:0;"
            allowfullscreen=""
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
          ></iframe>
        </div>
      </section>
    </main>

    <!-- ───── Footer (shared) ───── -->
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