<?php
session_start();
include("php/config.php");

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

// Fetch all jobs from the database (limit to 4 for the homepage)
$query = "SELECT * FROM jobs LIMIT 6";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("includes/head.php"); ?>
    <title>Skillsoft | Begin a Career in Tech</title>
  </head>
  <body>
    <?php include("includes/navbar.php"); ?>


    <!-- Premium Hero -->
    <section class="relative bg-slate-900 py-28 mb-10 overflow-hidden">
      <!-- Decorative background blur -->
      <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80')] bg-cover bg-center opacity-20 mix-blend-overlay"></div>
      <div class="absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-slate-900 to-transparent"></div>
      <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-slate-50 to-transparent"></div>
      
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center z-10">
        <div class="text-center">
          <span class="inline-block py-1 px-3 rounded-full bg-brand-500/20 text-brand-100 text-sm font-semibold mb-6 border border-brand-500/30 backdrop-blur-md">🚀 Elevate Your Future</span>
          <h1 class="text-5xl font-extrabold text-white tracking-tight sm:text-6xl md:text-7xl mb-6">
            Start a <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-violet-400">Tech Career</span>
          </h1>
          <p class="mt-4 text-xl text-slate-300 max-w-2xl mx-auto">
            Discover opportunities that match your passion. Join the top companies innovating the future of software, design, and engineering.
          </p>
          <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
            <a href="jobs.php" class="px-8 py-4 rounded-xl bg-brand-600 hover:bg-brand-500 text-white font-bold transition-all shadow-lg shadow-brand-500/30 hover:-translate-y-1">Find Jobs</a>
            <a href="register.php" class="px-8 py-4 rounded-xl bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white font-bold transition-all hover:-translate-y-1">Create Account</a>
          </div>
        </div>
      </div>
    </section>

    <!-- Employers -->
    <section class="py-4">
      <div class="container-xl lg:container m-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-lg">
          <div class="bg-gray-100 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold">For Job Seekers</h2>
            <p class="mt-2 mb-4">
              Browse our jobs and start your career today
            </p>
            <a
              href="jobs.php"
              class="inline-block bg-black text-white rounded-lg px-4 py-2 hover:bg-gray-700"
            >
              Browse Jobs
            </a>
          </div>
          <div class="bg-indigo-100 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold">For Employers</h2>
            <p class="mt-2 mb-4">
              List your job to find the perfect employees for the role
            </p>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
            <a
              href="add-job.php"
              class="inline-block bg-indigo-500 text-white rounded-lg px-4 py-2 hover:bg-indigo-600"
            >
              Add Job
            </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <!-- Browse Jobs -->
    <section class="bg-blue-50 px-4 py-10">
      <div class="container-xl lg:container m-auto">
        <h2 class="text-3xl font-bold text-indigo-500 mb-6 text-center">
          Browse Jobs
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <?php
          // Check if there are any jobs
          if (mysqli_num_rows($result) > 0) {
              // Loop through each job and display it
              while ($job = mysqli_fetch_assoc($result)) {
                  echo '
                  <div class="group bg-white rounded-2xl shadow-sm hover:shadow-2xl border border-slate-100 transition-all duration-300 hover:-translate-y-2 overflow-hidden flex flex-col">
                    <div class="p-6 flex-1">
                      <div class="mb-4 flex justify-between items-start">
                        <span class="inline-block bg-brand-50 text-brand-600 text-xs font-bold px-3 py-1 rounded-full">' . htmlspecialchars($job['type']) . '</span>
                        <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">New</span>
                      </div>
                      <h3 class="text-2xl font-bold text-slate-900 mb-2 group-hover:text-brand-600 transition-colors">' . htmlspecialchars($job['title']) . '</h3>
                      <div class="text-slate-500 mb-6 leading-relaxed">';
                        $description = htmlspecialchars($job['description']);
                        if (strlen($description) > 90) {
                            echo substr($description, 0, 90) . '...';
                        } else {
                            echo $description;
                        }
                        echo '
                      </div>
                      <div class="flex items-center text-slate-800 font-bold mb-2">
                        <i class="fa-solid fa-money-bill-wave text-brand-500 mr-2"></i>' . htmlspecialchars($job['salary']) . '
                      </div>
                    </div>
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                      <div class="text-slate-600 text-sm font-medium flex items-center">
                        <i class="fa-solid fa-location-dot text-slate-400 mr-2 text-lg"></i>
                        ' . htmlspecialchars($job['location']) . '
                      </div>
                      <a
                        href="job-details.php?id=' . $job['id'] . '"
                        class="w-full sm:w-auto bg-slate-900 hover:bg-brand-600 text-white px-6 py-2.5 rounded-xl text-center text-sm font-semibold transition-colors shadow-md"
                      >
                        Review Role
                      </a>
                    </div>
                  </div>';
              }
          } else {
              echo '<p class="text-center text-gray-600">No jobs found.</p>';
          }
          ?>
        </div>
      </div>
    </section>

    <section class="m-auto max-w-lg my-10 px-6">
      <a
        href="jobs.php"
        class="block bg-black text-white text-center py-4 px-6 rounded-xl hover:bg-gray-700"
        >View All Jobs</a
      >
    </section>

    <script src="js/main.js"></script>
  </body>
</html>