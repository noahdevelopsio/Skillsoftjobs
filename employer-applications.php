<?php
session_start();
include("php/config.php");

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;

if ($job_id === 0) {
    die("Error: No job selected.");
}

// Verify this job actually belongs to the logged-in employer
$job_check = $con->prepare("SELECT title FROM jobs WHERE id = ? AND employer_id = ?");
$job_check->bind_param("ii", $job_id, $user_id);
$job_check->execute();
$job_result = $job_check->get_result();

if (mysqli_num_rows($job_result) === 0) {
    die("Error: Unauthorized access or job does not exist.");
}

$job_data = mysqli_fetch_assoc($job_result);

// Fetch all applications for this job
$query = "SELECT * FROM applications WHERE job_id = ? ORDER BY id DESC";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $job_id);
$stmt->execute();
$applications = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("includes/head.php"); ?>
    <title>Skillsoft | View Applications</title>
  </head>
  <body class="bg-slate-950">
    <?php include("includes/navbar.php"); ?>

    <section class="relative bg-slate-900 pt-24 pb-12 overflow-hidden border-b border-white/5">
      <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-slate-950 to-transparent z-10"></div>
      <div class="container m-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-20">
        
        <a href="employer-dashboard.php" class="inline-flex items-center text-slate-400 font-semibold hover:text-white transition-colors mb-6 group">
          <div class="w-8 h-8 rounded-full border border-slate-700 group-hover:bg-white/10 flex items-center justify-center mr-3 transition-colors">
            <i class="fas fa-arrow-left text-sm group-hover:-translate-x-0.5 transition-transform"></i>
          </div>
          Back to Dashboard
        </a>

        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-3xl font-extrabold text-white tracking-tight mb-2">Applicants for: <span class="text-brand-400"><?php echo htmlspecialchars($job_data['title']); ?></span></h1>
            <p class="text-slate-400 font-medium">Review submitted resumes and candidate profiles.</p>
          </div>
          <div class="bg-slate-800/50 px-6 py-3 rounded-2xl border border-slate-700">
            <span class="block text-2xl font-bold text-white text-center"><?php echo mysqli_num_rows($applications); ?></span>
            <span class="block text-xs font-bold text-slate-500 uppercase tracking-widest mt-1">Total Views</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
      <?php if(mysqli_num_rows($applications) > 0): ?>
        <div class="bg-[#151c2c] rounded-3xl border border-slate-700/50 overflow-hidden shadow-2xl">
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="bg-slate-800/80 border-b border-slate-700/50">
                  <th class="py-4 px-6 font-bold text-slate-300 text-sm uppercase tracking-wider">Candidate</th>
                  <th class="py-4 px-6 font-bold text-slate-300 text-sm uppercase tracking-wider">Contact</th>
                  <th class="py-4 px-6 font-bold text-slate-300 text-sm uppercase tracking-wider">Demographics</th>
                  <th class="py-4 px-6 font-bold text-slate-300 text-sm uppercase tracking-wider text-right">Resume</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-700/50">
                <?php while ($app = mysqli_fetch_assoc($applications)): ?>
                  <tr class="hover:bg-slate-800/30 transition-colors group">
                    <td class="py-5 px-6">
                      <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-brand-500 to-violet-500 flex items-center justify-center text-white font-bold mr-4 shadow-inner">
                          <?php echo substr(htmlspecialchars($app['firstname']), 0, 1) . substr(htmlspecialchars($app['lastname']), 0, 1); ?>
                        </div>
                        <div>
                          <div class="font-bold text-white group-hover:text-brand-300 transition-colors">
                            <?php echo htmlspecialchars($app['firstname']) . ' ' . htmlspecialchars($app['lastname']); ?>
                          </div>
                          <div class="text-xs text-slate-500 font-medium mt-0.5">SSN: ***-**-<?php echo substr(htmlspecialchars($app['ssn']), -4); ?></div>
                        </div>
                      </div>
                    </td>
                    <td class="py-5 px-6">
                      <div class="text-sm text-slate-300 font-medium mb-1 flex items-center">
                        <i class="fa-solid fa-envelope w-4 text-slate-500 mr-2"></i> 
                        <a href="mailto:<?php echo htmlspecialchars($app['email']); ?>" class="hover:underline"><?php echo htmlspecialchars($app['email']); ?></a>
                      </div>
                      <div class="text-sm text-slate-400 flex items-center">
                        <i class="fa-solid fa-phone w-4 text-slate-500 mr-2"></i> 
                        <?php echo htmlspecialchars($app['phoneno']); ?>
                      </div>
                    </td>
                    <td class="py-5 px-6">
                      <div class="text-sm text-slate-300 font-medium mb-1 flex items-center">
                        <i class="fa-solid fa-house w-4 text-slate-500 mr-2"></i>
                        <span class="truncate max-w-[200px]" title="<?php echo htmlspecialchars($app['houseaddress']); ?>">
                           <?php echo htmlspecialchars($app['houseaddress']); ?>
                        </span>
                      </div>
                      <div class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center">
                        <i class="fa-solid fa-venus-mars w-4 text-slate-600 mr-2"></i> <?php echo htmlspecialchars($app['gender']); ?>
                      </div>
                    </td>
                    <td class="py-5 px-6 text-right">
                      <?php 
                        // The primary uploaded file is stored in driverlicense_path due to the schema 
                        $resumePath = $app['driverlicense_path'];
                        // Fix relative path for the dashboard
                        $resumeUrl = str_replace('../', '', $resumePath);
                      ?>
                      <a 
                        href="<?php echo htmlspecialchars($resumeUrl); ?>" 
                        target="_blank"
                        class="inline-flex items-center justify-center bg-brand-500/10 hover:bg-brand-500 text-brand-400 hover:text-white border border-brand-500/20 hover:border-brand-500 px-4 py-2 rounded-lg font-bold text-sm transition-all shadow-sm"
                      >
                        <i class="fa-solid fa-file-arrow-down mr-2"></i> Download
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php else: ?>
        <div class="py-16 text-center bg-[#151c2c] rounded-3xl border border-slate-700/50 border-dashed">
          <div class="inline-flex w-16 h-16 rounded-full bg-slate-800 items-center justify-center mb-4">
            <i class="fa-solid fa-inbox text-2xl text-slate-500"></i>
          </div>
          <h3 class="text-xl font-bold text-white mb-2">No Applications Yet</h3>
          <p class="text-slate-400 font-medium">Candidates have not applied to this position yet. Check back later!</p>
        </div>
      <?php endif; ?>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>
