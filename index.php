<?php
include("php/session_helper.php");
init_session();
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
    <title>Skillsoft | Find Your Dream Job</title>
  </head>
  <body>
    <?php include("includes/navbar.php"); ?>


    <!-- Modern Premium Hero -->
    <section class="relative bg-slate-900 pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
      <!-- Animated Background Elements -->
      <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80')] bg-cover bg-center opacity-10 mix-blend-overlay"></div>
      <div class="absolute top-0 inset-x-0 h-40 bg-gradient-to-b from-slate-900 to-transparent z-10"></div>
      <div class="absolute bottom-0 inset-x-0 h-40 bg-gradient-to-t from-slate-900 to-transparent z-10"></div>
      
      <!-- Glowing Orbs -->
      <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-brand-600/20 rounded-full blur-[128px] mix-blend-screen animate-pulse pointer-events-none"></div>
      <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-violet-600/20 rounded-full blur-[128px] mix-blend-screen pointer-events-none" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite 2s;"></div>

      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 z-20">
        <div class="text-center max-w-4xl mx-auto">
          <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 border border-white/10 backdrop-blur-md mb-8 transform transition hover:scale-105 cursor-default">
            <span class="flex h-2 w-2 relative">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
            </span>
            <span class="text-xs font-semibold uppercase tracking-wider text-slate-300">New premium platform live</span>
          </div>
          
          <h1 class="text-5xl md:text-7xl font-extrabold text-white tracking-tight mb-8 leading-tight">
            Accelerate your <br class="hidden md:block" />
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 via-violet-400 to-brand-400 animate-gradient-x">dream career</span>
          </h1>
          
          <p class="text-lg md:text-xl text-slate-400 mb-10 max-w-2xl mx-auto leading-relaxed">
            Discover elite opportunities. Connect with top companies hiring across every industry and skill level.
          </p>
          
          <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
            <a href="jobs.php" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-gradient-to-r from-brand-600 to-violet-600 hover:from-brand-500 hover:to-violet-500 text-white font-bold transition-all shadow-[0_0_20px_rgba(124,58,237,0.3)] hover:shadow-[0_0_30px_rgba(124,58,237,0.5)] transform hover:-translate-y-1">
              Explore Active Roles
            </a>
            <a href="register.php" class="w-full sm:w-auto px-8 py-4 rounded-xl bg-white/5 hover:bg-white/10 text-white font-bold backdrop-blur-md border border-white/10 transition-all hover:-translate-y-1">
              Join the Network
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Bento Grid Section -->
    <section class="py-20 bg-slate-900 border-t border-white/5">
      <div class="container m-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
          
          <!-- Job Seekers Bento Card -->
          <div class="relative group rounded-3xl bg-slate-800/50 border border-slate-700/50 p-8 lg:p-12 overflow-hidden transition-all duration-300 hover:border-brand-500/50 hover:bg-slate-800">
            <div class="absolute top-0 right-0 w-32 h-32 bg-brand-500/10 rounded-full blur-3xl transform group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10 flex flex-col h-full">
              <div class="w-14 h-14 rounded-2xl bg-brand-500/20 flex items-center justify-center border border-brand-500/30 mb-8 text-brand-400 text-2xl group-hover:scale-110 group-hover:rotate-3 transition-transform">
                <i class="fa-solid fa-user-astronaut"></i>
              </div>
              <h2 class="text-3xl font-bold text-white mb-4">For Pioneers</h2>
              <p class="text-slate-400 text-lg mb-8 flex-grow leading-relaxed">
                Connect directly with hiring managers. Build an elite profile and land the role you deserve.
              </p>
              <a href="jobs.php" class="inline-flex items-center text-brand-400 font-bold hover:text-brand-300 transition-colors group/link w-fit">
                Start browsing roles
                <i class="fa-solid fa-arrow-right ml-2 transform group-hover/link:translate-x-1 transition-transform"></i>
              </a>
            </div>
          </div>

          <!-- Employers Bento Card -->
          <div class="relative group rounded-3xl bg-slate-800/50 border border-slate-700/50 p-8 lg:p-12 overflow-hidden transition-all duration-300 hover:border-violet-500/50 hover:bg-slate-800">
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-violet-500/10 rounded-full blur-3xl transform group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10 flex flex-col h-full">
              <div class="w-14 h-14 rounded-2xl bg-violet-500/20 flex items-center justify-center border border-violet-500/30 mb-8 text-violet-400 text-2xl group-hover:scale-110 group-hover:-rotate-3 transition-transform">
                <i class="fa-solid fa-building"></i>
              </div>
              <h2 class="text-3xl font-bold text-white mb-4">For Visionaries</h2>
              <p class="text-slate-400 text-lg mb-8 flex-grow leading-relaxed">
                Source world-class talent. Post your open roles and build the team that will build the future.
              </p>
              <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
              <a href="add-job.php" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-violet-600 hover:bg-violet-500 text-white font-bold transition-all shadow-lg hover:-translate-y-1 w-fit">
                <i class="fa-solid fa-plus mr-2"></i> Post a Job
              </a>
              <?php else: ?>
              <span class="inline-flex items-center text-slate-500 font-medium text-sm border border-slate-700/50 bg-slate-900/50 px-4 py-2 rounded-lg">
                <i class="fa-solid fa-lock mr-2 text-xs"></i> Admin Access Required
              </span>
              <?php endif; ?>
            </div>
          </div>
          
        </div>
      </div>
    </section>

    <!-- Featured Roles Section -->
    <section class="bg-slate-900 border-t border-white/5 py-24 relative overflow-hidden">
      <!-- Glow Accent -->
      <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-brand-900/10 blur-[120px] rounded-full pointer-events-none"></div>

      <div class="container m-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-10">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
          <div>
            <span class="text-brand-400 font-bold tracking-wider uppercase text-sm mb-2 block">Latest Opportunities</span>
            <h2 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight">Active Roles</h2>
          </div>
          <a href="jobs.php" class="group flex items-center text-slate-300 hover:text-white transition-colors font-medium">
            View the full board
            <div class="ml-3 w-8 h-8 rounded-full border border-slate-600 group-hover:border-white group-hover:bg-white flex items-center justify-center transition-all">
              <i class="fa-solid fa-arrow-right text-xs text-slate-400 group-hover:text-slate-900 transition-colors"></i>
            </div>
          </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php
          if (mysqli_num_rows($result) > 0) {
              while ($job = mysqli_fetch_assoc($result)) {
                  echo '
                  <div class="group relative bg-[#151c2c] rounded-3xl border border-slate-700/50 transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.5)] hover:border-brand-500/30 overflow-hidden flex flex-col">
                    <div class="absolute inset-0 bg-gradient-to-br from-white/[0.02] to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    
                    <div class="p-8 flex-1 relative z-10">
                      <div class="mb-6 flex justify-between items-start">
                        <span class="inline-flex items-center px-3 py-1 rounded-full bg-brand-500/10 border border-brand-500/20 text-brand-400 text-xs font-bold uppercase tracking-wider">' . htmlspecialchars($job['type']) . '</span>
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" title="Actively Hiring"></div>
                      </div>
                      
                      <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-brand-300 transition-colors leading-tight line-clamp-2">' . htmlspecialchars($job['title']) . '</h3>
                      
                      <p class="text-slate-400 mb-8 leading-relaxed line-clamp-3 text-sm">';
                        echo htmlspecialchars($job['description']);
                        echo '
                      </p>
                      
                      <div class="flex flex-wrap items-center gap-4 text-sm font-semibold">
                        <div class="flex items-center text-emerald-400 bg-emerald-400/10 px-3 py-1.5 rounded-lg border border-emerald-400/20">
                          <i class="fa-solid fa-money-bill-wave mr-2"></i>' . htmlspecialchars($job['salary']) . '
                        </div>
                      </div>
                    </div>
                    
                    <div class="px-8 py-5 bg-slate-800/30 border-t border-slate-700/50 flex flex-col sm:flex-row justify-between items-center gap-4 relative z-10 group-hover:bg-slate-800/50 transition-colors">
                      <div class="text-slate-400 text-sm font-medium flex items-center">
                        <i class="fa-solid fa-location-dot mr-2 text-slate-500 group-hover:text-brand-400 transition-colors"></i>
                        <span class="truncate max-w-[150px]">' . htmlspecialchars($job['location']) . '</span>
                      </div>
                      <a
                        href="job-details.php?id=' . $job['id'] . '"
                        class="w-full sm:w-auto bg-white/5 hover:bg-brand-600 text-white px-5 py-2.5 rounded-xl border border-white/10 hover:border-brand-500 text-center text-sm font-bold transition-all shadow-sm group-hover:shadow-[0_0_15px_rgba(124,58,237,0.3)]"
                      >
                        Review Role
                      </a>
                    </div>
                  </div>';
              }
          } else {
              echo '<div class="col-span-full py-12 text-center bg-slate-800/30 rounded-3xl border border-slate-700/50 border-dashed">
                      <i class="fa-solid fa-ghost text-4xl text-slate-600 mb-4 block"></i>
                      <p class="text-slate-400 font-medium">No premium roles available right now.</p>
                    </div>';
          }
          ?>
        </div>
      </div>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>