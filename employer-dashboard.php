<?php
session_start();
include("php/config.php");

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

// Check if the user is submitting a job deletion
if (isset($_POST['delete_job_id'])) {
    $delete_id = intval($_POST['delete_job_id']);
    
    // First, delete related applications safely
    $del_apps = $con->prepare("DELETE FROM applications WHERE job_id = ?");
    $del_apps->bind_param("i", $delete_id);
    $del_apps->execute();
    
    // Then delete the job ensuring it belongs to this employer
    $del_job = $con->prepare("DELETE FROM jobs WHERE id = ? AND employer_id = ?");
    $del_job->bind_param("ii", $delete_id, $user_id);
    if ($del_job->execute()) {
        $msg = "Job successfully deleted.";
    } else {
        $msg = "Failed to delete job.";
    }
}

// Fetch all jobs posted by this employer
$query = "SELECT * FROM jobs WHERE employer_id = ? ORDER BY id DESC";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$jobs_result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("includes/head.php"); ?>
    <title>Skillsoft | Employer Dashboard</title>
  </head>
  <body class="bg-slate-950">
    <?php include("includes/navbar.php"); ?>

    <!-- Header Section -->
    <section class="relative bg-slate-900 pt-24 pb-12 overflow-hidden border-b border-white/5">
      <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80')] bg-cover bg-center opacity-10 mix-blend-overlay"></div>
      <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-slate-950 to-transparent z-10"></div>
      <div class="absolute top-0 right-0 w-96 h-96 bg-brand-600/10 rounded-full blur-[128px] mix-blend-screen pointer-events-none"></div>

      <div class="container m-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-20">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
          <div>
            <h1 class="text-4xl font-extrabold text-white tracking-tight mb-2">Employer <span class="text-brand-400">Dashboard</span></h1>
            <p class="text-slate-400 font-medium">Manage your job listings and review incoming applications.</p>
          </div>
          <div>
            <a href="add-job.php" class="inline-flex items-center bg-brand-600 hover:bg-brand-500 text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg hover:shadow-brand-500/25">
              <i class="fa-solid fa-plus mr-2"></i> Post New Job
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
      <?php if(isset($msg)): ?>
        <div class="mb-8 p-4 rounded-xl bg-brand-500/10 border border-brand-500/20 text-brand-400 font-medium">
          <?php echo htmlspecialchars($msg); ?>
        </div>
      <?php endif; ?>

      <div class="mb-8 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-white">Your Listed Roles</h2>
        <span class="text-slate-400 font-medium"><?php echo mysqli_num_rows($jobs_result); ?> Active</span>
      </div>

      <?php if(mysqli_num_rows($jobs_result) > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php while ($job = mysqli_fetch_assoc($jobs_result)): ?>
            <?php 
              // Fetch application count for this job
              $app_query = $con->prepare("SELECT COUNT(*) as applicant_count FROM applications WHERE job_id = ?");
              $app_query->bind_param("i", $job['id']);
              $app_query->execute();
              $app_count_res = $app_query->get_result()->fetch_assoc();
              $applicant_count = $app_count_res['applicant_count'];
            ?>
            <div class="group relative bg-[#151c2c] rounded-3xl border border-slate-700/50 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.5)] overflow-hidden flex flex-col">
              <div class="p-6 flex-1">
                <div class="mb-4 flex justify-between items-start">
                  <span class="inline-flex items-center px-3 py-1 rounded-full bg-violet-500/10 border border-violet-500/20 text-violet-400 text-xs font-bold uppercase tracking-wider">
                    <?php echo htmlspecialchars($job['type']); ?>
                  </span>
                  
                  <form method="POST" onsubmit="return confirm('Are you sure you want to delete this job and all its applications?');">
                    <input type="hidden" name="delete_job_id" value="<?php echo $job['id']; ?>">
                    <button type="submit" class="text-slate-500 hover:text-red-400 transition-colors p-2" title="Delete Job">
                      <i class="fa-solid fa-trash"></i>
                    </button>
                  </form>
                </div>
                
                <h3 class="text-xl font-bold text-white mb-2 leading-tight"><?php echo htmlspecialchars($job['title']); ?></h3>
                <div class="text-sm text-slate-400 mb-6 flex items-center gap-2">
                  <i class="fa-solid fa-location-dot"></i> <?php echo htmlspecialchars($job['location']); ?>
                </div>

                <div class="flex items-center justify-between bg-slate-900/50 p-4 rounded-xl border border-slate-700/50">
                  <div class="text-center">
                    <span class="block text-2xl font-bold <?php echo $applicant_count > 0 ? 'text-emerald-400' : 'text-slate-500'; ?>"><?php echo $applicant_count; ?></span>
                    <span class="block text-xs font-semibold text-slate-500 uppercase tracking-widest mt-1">Applicants</span>
                  </div>
                  
                  <a href="employer-applications.php?job_id=<?php echo $job['id']; ?>" class="bg-white/5 hover:bg-white/10 border border-white/10 text-white px-4 py-2 rounded-lg text-sm font-bold transition-colors">
                    View Data
                  </a>
                </div>
              </div>
            </div>
          <?php endwhile; ?>
        </div>
      <?php else: ?>
        <div class="py-16 text-center bg-[#151c2c] rounded-3xl border border-slate-700/50 border-dashed">
          <div class="inline-flex w-16 h-16 rounded-full bg-slate-800 items-center justify-center mb-4">
            <i class="fa-solid fa-briefcase text-2xl text-slate-500"></i>
          </div>
          <h3 class="text-xl font-bold text-white mb-2">No jobs posted yet</h3>
          <p class="text-slate-400 font-medium max-w-md mx-auto mb-6">Create your first role listing to start receiving applications from elite tech talent.</p>
          <a href="add-job.php" class="inline-block px-6 py-3 rounded-xl bg-brand-600 hover:bg-brand-500 text-white font-bold transition-all shadow-[0_0_20px_rgba(124,58,237,0.3)]">Post a Role</a>
        </div>
      <?php endif; ?>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>
