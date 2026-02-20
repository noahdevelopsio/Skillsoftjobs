<?php
session_start();
include("php/config.php");

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

// Handle filter input
$filter = isset($_GET['filter']) ? mysqli_real_escape_string($con, $_GET['filter']) : '';

// Fetch jobs based on filter
// Fetch jobs based on filter
if (!empty($filter)) {
    $query = "SELECT * FROM jobs 
              WHERE title LIKE ? 
              OR location LIKE ? 
              OR type LIKE ? 
              OR description LIKE ?";
    $stmt = $con->prepare($query);
    $searchTerm = "%{$filter}%";
    $stmt->bind_param("ssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT * FROM jobs";
    $result = mysqli_query($con, $query);
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("includes/head.php"); ?>
    <title>Skillsoft</title>

  </head>
  <body>
    <?php include("includes/navbar.php"); ?>

    <!-- Filter Jobs -->
    <section class="bg-slate-900 py-12 relative overflow-hidden">
      <!-- Decorative background blur -->
      <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80')] bg-cover bg-center opacity-10 mix-blend-overlay"></div>
      <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-3xl mx-auto backdrop-blur-md bg-white/10 p-2 rounded-2xl border border-white/20 shadow-2xl">
          <form method="GET" action="jobs.php" class="relative flex items-center">
            <i class="fa-solid fa-magnifying-glass absolute left-6 text-slate-400 text-lg"></i>
            <input
              type="text"
              name="filter"
              class="w-full py-4 pl-14 pr-32 bg-white rounded-xl focus:outline-none focus:ring-4 focus:ring-brand-500/30 text-slate-800 text-lg placeholder:text-slate-400 font-medium transition-shadow"
              placeholder="Search by role, location, or type..."
              value="<?php echo htmlspecialchars($filter); ?>"
            />
            <button type="submit" class="absolute right-2 top-2 bottom-2 bg-brand-600 hover:bg-brand-500 text-white px-6 rounded-lg font-bold transition-colors">
              Search
            </button>
          </form>
        </div>
      </div>
    </section>

    <!-- All Jobs -->
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
                        <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider">Active</span>
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
              echo '<p class="text-center text-gray-600">No jobs found matching your criteria.</p>';
          }
          ?>
        </div>
      </div>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>