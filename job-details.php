<?php
include("php/session_helper.php");
init_session();
include("php/config.php");

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

    <!-- Premium Header Area -->
    <section class="relative bg-slate-900 pt-24 pb-12 overflow-hidden border-b border-white/5">
      <!-- Animated Background Elements -->
      <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80')] bg-cover bg-center opacity-10 mix-blend-overlay"></div>
      <div class="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-slate-950 to-transparent z-10"></div>
      
      <!-- Glowing Orbs -->
      <div class="absolute top-0 right-0 w-96 h-96 bg-brand-600/10 rounded-full blur-[128px] mix-blend-screen pointer-events-none"></div>

      <div class="container m-auto px-4 sm:px-6 lg:px-8 max-w-7xl relative z-20">
        <a
          href="jobs.php"
          class="inline-flex items-center text-slate-400 font-semibold hover:text-white transition-colors mb-8 group"
        >
          <div class="w-8 h-8 rounded-full border border-slate-700 group-hover:bg-white/10 flex items-center justify-center mr-3 transition-colors">
            <i class="fas fa-arrow-left text-sm group-hover:-translate-x-0.5 transition-transform"></i>
          </div>
          Back to Command Center
        </a>

        <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 backdrop-blur-xl bg-slate-800/30 p-8 rounded-3xl border border-slate-700/50 shadow-2xl">
          <div class="flex-1">
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-brand-500/10 border border-brand-500/20 text-brand-400 text-xs font-bold uppercase tracking-wider mb-4">
              <?php echo htmlspecialchars($job['type']); ?>
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4">
              <?php echo htmlspecialchars($job['title']); ?>
            </h1>
            <div class="flex flex-wrap items-center gap-4 text-slate-400 font-medium">
              <div class="flex items-center">
                <i class="fa-solid fa-location-dot text-lg text-slate-500 mr-2"></i>
                <span><?php echo htmlspecialchars($job['location']); ?></span>
              </div>
              <div class="hidden sm:block w-1.5 h-1.5 rounded-full bg-slate-600"></div>
              <div class="flex items-center">
                <i class="fa-solid fa-building text-lg text-slate-500 mr-2"></i>
                <span class="text-white font-bold"><?php echo htmlspecialchars($job['company']); ?></span>
              </div>
              <div class="hidden sm:block w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
              <span class="text-emerald-400 text-sm font-bold uppercase tracking-wider">Actively Hiring</span>
            </div>
          </div>
          <div class="bg-[#151c2c] p-6 rounded-2xl border border-slate-700/50 min-w-[200px] flex flex-col items-center justify-center shadow-inner">
             <span class="block text-sm text-slate-400 font-semibold mb-2 uppercase tracking-wide">Compensation</span>
             <span class="block text-2xl font-bold text-emerald-400"><i class="fa-solid fa-money-bill-wave mr-2 opacity-50"></i><?php echo htmlspecialchars($job['salary']); ?></span>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content Area -->
    <section class="bg-slate-950 min-h-screen py-12">
      <div class="container m-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          
          <!-- Details Column -->
          <main class="lg:col-span-2 space-y-8">
            <!-- Job Description -->
            <div class="bg-[#151c2c] p-8 md:p-10 rounded-3xl border border-slate-700/50 shadow-xl relative overflow-hidden group">
              <div class="absolute top-0 right-0 w-64 h-64 bg-brand-500/5 rounded-full blur-3xl group-hover:bg-brand-500/10 transition-colors"></div>
              <h3 class="text-2xl font-bold text-white mb-8 flex items-center relative z-10">
                <div class="w-10 h-10 rounded-xl bg-brand-500/10 flex items-center justify-center mr-4 border border-brand-500/20">
                  <i class="fa-solid fa-align-left text-brand-400"></i>
                </div>
                Role Overview
              </h3>

              <div class="prose prose-invert prose-slate max-w-none text-slate-300 leading-relaxed text-lg relative z-10">
                <?php echo nl2br(htmlspecialchars($job['description'])); ?>
              </div>
            </div>

            <!-- Job Requirements -->
            <div class="bg-[#151c2c] p-8 md:p-10 rounded-3xl border border-slate-700/50 shadow-xl relative overflow-hidden group">
              <div class="absolute bottom-0 right-0 w-64 h-64 bg-violet-500/5 rounded-full blur-3xl group-hover:bg-violet-500/10 transition-colors"></div>
               <h3 class="text-2xl font-bold text-white mb-8 flex items-center relative z-10">
                <div class="w-10 h-10 rounded-xl bg-violet-500/10 flex items-center justify-center mr-4 border border-violet-500/20">
                  <i class="fa-solid fa-list-check text-violet-400"></i>
                </div>
                Candidate Requirements
              </h3>

              <ul class="space-y-4 text-slate-300 text-lg relative z-10">
                <?php if (!empty($job['candidate_requirements'])): ?>
                <li class="flex items-start bg-slate-800/30 p-4 rounded-xl border border-slate-700/50">
                  <i class="fa-solid fa-check text-brand-400 mt-1 mr-4 bg-brand-400/10 p-1.5 rounded-md"></i> 
                  <span class="whitespace-pre-line"><?php echo nl2br(htmlspecialchars($job['candidate_requirements'])); ?></span>
                </li>
                <?php else: ?>
                <li class="flex items-start bg-slate-800/30 p-4 rounded-xl border border-slate-700/50">
                  <i class="fa-solid fa-check text-brand-400 mt-1 mr-4 bg-brand-400/10 p-1.5 rounded-md"></i> 
                  <span>No specific prior experience mandated; fundamental computer literacy required.</span>
                </li>
                <?php endif; ?>
                
                <li class="flex items-start bg-slate-800/30 p-4 rounded-xl border border-slate-700/50">
                  <i class="fa-solid fa-check text-brand-400 mt-1 mr-4 bg-brand-400/10 p-1.5 rounded-md"></i> 
                  <span>Digital Resume / CV</span>
                </li>
                
                <?php if ($job['req_coverletter']): ?>
                <li class="flex items-start bg-slate-800/30 p-4 rounded-xl border border-slate-700/50">
                  <i class="fa-solid fa-check text-brand-400 mt-1 mr-4 bg-brand-400/10 p-1.5 rounded-md"></i> 
                  <span>Cover letter articulating fit</span>
                </li>
                <?php endif; ?>

                <?php if ($job['req_passport']): ?>
                <li class="flex items-start bg-slate-800/30 p-4 rounded-xl border border-slate-700/50">
                  <i class="fa-solid fa-check text-brand-400 mt-1 mr-4 bg-brand-400/10 p-1.5 rounded-md"></i> 
                  <span>Passport Photo</span>
                </li>
                <?php endif; ?>

                <?php if ($job['req_id']): ?>
                <li class="flex items-start bg-slate-800/30 p-4 rounded-xl border border-slate-700/50">
                  <i class="fa-solid fa-check text-brand-400 mt-1 mr-4 bg-brand-400/10 p-1.5 rounded-md"></i> 
                  <span>National ID or Driver's License</span>
                </li>
                <?php endif; ?>
              </ul>                             
              
              <div class="mt-10 relative z-10">
                  <a 
                    href="apply.php?job_id=<?php echo $job['id']; ?>" 
                    class="block text-center bg-gradient-to-r from-brand-600 to-violet-600 hover:from-brand-500 hover:to-violet-500 text-white font-bold py-5 px-6 rounded-2xl transition-all shadow-[0_0_20px_rgba(124,58,237,0.3)] hover:shadow-[0_0_30px_rgba(124,58,237,0.5)] transform hover:-translate-y-1 w-full text-lg tracking-wide"
                  >
                    Submit Application
                  </a>
              </div>
            </div>
          </main>

          <!-- Sidebar -->
          <aside class="space-y-8 h-fit lg:sticky lg:top-24">
            <!-- Company Info Widget -->
            <div class="bg-[#151c2c] p-8 rounded-3xl border border-slate-700/50 shadow-xl overflow-hidden relative">
              <div class="absolute top-0 right-0 w-32 h-32 bg-brand-500/10 rounded-full blur-2xl pointer-events-none"></div>
              
              <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-6 flex items-center">
                <i class="fa-solid fa-building mr-2"></i> Enterprise Details
              </h3>

              <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-slate-800 border border-slate-700 mb-6 font-bold text-2xl text-white">
                <?php echo substr(htmlspecialchars($job['company']), 0, 1); ?>
              </div>

              <h2 class="text-2xl font-extrabold text-white mb-4 leading-tight"><?php echo htmlspecialchars($job['company']); ?></h2>

              <p class="text-slate-400 leading-relaxed mb-8 text-sm">
                <?php echo htmlspecialchars($job['company_description']); ?>
              </p>

              <div class="space-y-4">
                  <!-- Email -->
                  <div class="group border border-slate-700/50 bg-slate-800/30 rounded-2xl p-4 transition-colors hover:bg-slate-800">
                      <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Direct Contact</h3>
                      <div class="flex items-center">
                          <div class="w-8 h-8 rounded-lg bg-brand-500/10 flex items-center justify-center mr-3">
                            <i class="fa-solid fa-envelope text-brand-400 text-sm"></i>
                          </div>
                          <a href="mailto:<?php echo htmlspecialchars($job['contact_email']); ?>" class="text-white text-sm font-semibold truncate hover:text-brand-400 transition-colors">
                            <?php echo htmlspecialchars($job['contact_email']); ?>
                          </a>
                      </div>
                  </div>

                  <!-- Phone -->
                  <div class="group border border-slate-700/50 bg-slate-800/30 rounded-2xl p-4 transition-colors hover:bg-slate-800">
                      <h3 class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Office Line</h3>
                      <div class="flex items-center">
                          <div class="w-8 h-8 rounded-lg bg-violet-500/10 flex items-center justify-center mr-3">
                            <i class="fa-solid fa-phone text-violet-400 text-sm"></i>
                          </div>
                          <a href="tel:<?php echo htmlspecialchars($job['contact_phone']); ?>" class="text-white text-sm font-semibold hover:text-violet-400 transition-colors">
                            <?php echo htmlspecialchars($job['contact_phone']); ?>
                          </a>
                      </div>
                  </div>
              </div>
            </div>
            
            <!-- Trust Badge -->
            <div class="border border-slate-700/50 bg-slate-800/20 rounded-2xl p-6 flex flex-col items-center text-center">
              <i class="fa-solid fa-shield-halved text-3xl text-slate-600 mb-3"></i>
              <p class="text-slate-400 text-sm">This role is verified by Skillsoft Talent Acquisition.</p>
            </div>
          </aside>
        </div>
      </div>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>