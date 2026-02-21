<?php
session_start();
include("php/config.php");

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

// Get the job ID from the URL
$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch job details from the database
// Fetch job details from the database
$query = "SELECT * FROM jobs WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the job exists
if (mysqli_num_rows($result) == 0) {
    echo "<script>alert('Job not found.'); window.location.href = 'jobs.php';</script>";
    exit();
}

$job = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("includes/head.php"); ?>
    <title>Skillsoft Tech | Career</title>
  </head>
  <body>
    <?php include("includes/navbar.php"); ?>

    <!-- Go Back -->
    <section>
      <div class="container m-auto py-6 px-6">
        <a
          href="jobs.php"
          class="text-brand-600 font-semibold hover:text-brand-800 flex items-center transition-colors"
        >
          <i class="fas fa-arrow-left mr-2"></i> Back to Job Listings
        </a>
      </div>
    </section>

    <section class="bg-slate-50 min-h-screen">
      <div class="container m-auto py-10 px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 w-full gap-8">
          <main class="md:col-span-2 space-y-8">
            <div
              class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 flex flex-col md:flex-row items-start md:items-center justify-between gap-6"
            >
              <div>
                <span class="inline-block bg-brand-50 text-brand-600 text-xs font-bold px-3 py-1 rounded-full mb-4"><?php echo htmlspecialchars($job['type']); ?></span>
                <h1 class="text-4xl font-extrabold text-slate-900 mb-2">
                  <?php echo htmlspecialchars($job['title']); ?>
                </h1>
                <div
                  class="text-slate-500 flex items-center font-medium"
                >
                  <i
                    class="fa-solid fa-location-dot text-lg text-slate-400 mr-2"
                  ></i>
                  <p><?php echo htmlspecialchars($job['location']); ?></p>
                </div>
              </div>
              <div class="bg-brand-50 p-4 rounded-xl text-center min-w-[150px]">
                 <span class="block text-sm text-slate-500 font-semibold mb-1">Salary</span>
                 <span class="block text-xl font-bold text-brand-600"><i class="fa-solid fa-money-bill-wave mr-1"></i><?php echo htmlspecialchars($job['salary']); ?></span>
              </div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
              <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <i class="fa-solid fa-align-left text-brand-500 mr-3"></i> Job Description
              </h3>

              <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed text-lg">
                <?php echo nl2br(htmlspecialchars($job['description'])); ?>
              </div>
            </div>

            <!-- Job Requirements -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
               <h3 class="text-2xl font-bold text-slate-900 mb-6 flex items-center">
                <i class="fa-solid fa-list-check text-brand-500 mr-3"></i> Job Requirements
              </h3>

              <ul class="space-y-4 text-slate-600 text-lg">
                <li class="flex items-start"><i class="fa-solid fa-circle-check text-green-500 mt-1 mr-3 relative top-0.5"></i> No Experience Needed, but individuals must be computer literate.</li>
                <li class="flex items-start"><i class="fa-solid fa-circle-check text-green-500 mt-1 mr-3 relative top-0.5"></i> Resume / CV</li>
                <li class="flex items-start"><i class="fa-solid fa-circle-check text-green-500 mt-1 mr-3 relative top-0.5"></i> Cover letter</li>
                <li class="flex items-start"><i class="fa-solid fa-circle-check text-green-500 mt-1 mr-3 relative top-0.5"></i> Add a short note on why you are the right person for the job and how available you are.</li>
                <li class="flex items-start"><i class="fa-solid fa-circle-check text-brand-500 mt-1 mr-3 relative top-0.5"></i> Training for 2 Weeks: ($30/hour)</li> 
              </ul>                             
              
              <div class="mt-8">
                  <a 
                    href="apply.php?id=<?php echo $job['id']; ?>" 
                    class="block bg-brand-600 hover:bg-brand-500 text-white text-center font-bold py-4 px-6 rounded-xl transition-all shadow-md hover:-translate-y-1 hover:shadow-xl w-full"
                  >
                    Apply Now
                  </a>
              </div>
            </div>
          </main>

          <!-- Sidebar -->
          <aside class="space-y-8">
            <!-- Company Info -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
              <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center">
                <i class="fa-solid fa-building text-brand-500 mr-3"></i> Company Info
              </h3>

              <h2 class="text-2xl font-bold text-brand-700 mb-4"><?php echo htmlspecialchars($job['company']); ?></h2>

              <p class="text-slate-600 leading-relaxed mb-6">
                <?php echo htmlspecialchars($job['company_description']); ?>
              </p>

              <div class="border-t border-slate-100 pt-6 space-y-6">
                  <div>
                      <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Contact Email</h3>
                      <div class="flex items-center bg-slate-50 p-4 rounded-xl border border-slate-100">
                          <i class="fa-solid fa-envelope text-brand-500 mr-3"></i>
                          <a href="mailto:<?php echo htmlspecialchars($job['contact_email']); ?>" class="text-slate-900 font-bold hover:text-brand-600 transition-colors">
                            <?php echo htmlspecialchars($job['contact_email']); ?>
                          </a>
                      </div>
                  </div>

                  <div>
                      <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-2">Contact Phone</h3>
                      <div class="flex items-center bg-slate-50 p-4 rounded-xl border border-slate-100">
                          <i class="fa-solid fa-phone text-brand-500 mr-3"></i>
                          <a href="tel:<?php echo htmlspecialchars($job['contact_phone']); ?>" class="text-slate-900 font-bold hover:text-brand-600 transition-colors">
                            <?php echo htmlspecialchars($job['contact_phone']); ?>
                          </a>
                      </div>
                  </div>
              </div>
            </div>
          </aside>
        </div>
      </div>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>