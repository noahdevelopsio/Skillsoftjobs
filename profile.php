<?php
include("php/session_helper.php");
init_session();
include("php/config.php");

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

// Fetch the logged-in user's data
$user_id = $_SESSION['id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <?php include("includes/navbar.php"); ?>

    <!-- Dashboard Section -->
    <section class="bg-slate-950 min-h-screen py-12 relative overflow-hidden">
      <!-- Animated Background Elements -->
      <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80')] bg-cover bg-center opacity-5 mix-blend-overlay pointer-events-none"></div>
      
      <!-- Glowing Orbs -->
      <div class="absolute top-0 right-1/4 w-96 h-96 bg-brand-600/10 rounded-full blur-[128px] mix-blend-screen pointer-events-none"></div>
      <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-violet-600/10 blur-[120px] mix-blend-screen pointer-events-none"></div>
      
      <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl relative z-10">
        
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
          <div>
            <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-2">My Command Center</h1>
            <p class="text-slate-400 font-medium">Manage your personal profile and preferences.</p>
          </div>
          <div class="flex gap-4">
            <a href="edit-profile.php" class="px-6 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold backdrop-blur-md border border-white/10 transition-all shadow-sm flex items-center">
              <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Profile
            </a>
            <a href="php/logout.php" class="px-6 py-2.5 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 font-semibold border border-red-500/20 transition-all shadow-sm flex items-center">
              <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Logout
            </a>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          
          <!-- Identity Card -->
          <div class="md:col-span-1">
            <div class="backdrop-blur-xl bg-slate-800/40 p-8 rounded-3xl border border-slate-700/50 shadow-2xl relative overflow-hidden flex flex-col items-center text-center">
              <div class="absolute top-0 inset-x-0 h-32 bg-gradient-to-b from-brand-500/10 to-transparent"></div>
              
              <div class="w-32 h-32 rounded-full bg-slate-900 border-4 border-slate-800 mb-6 flex items-center justify-center relative z-10 shadow-xl overflow-hidden group">
                <i class="fa-solid <?php echo ($user['Gender'] == 'Female') ? 'fa-user-nurse' : 'fa-user-tie'; ?> text-6xl text-slate-600 group-hover:text-brand-400 transition-colors duration-500"></i>
                <div class="absolute inset-0 bg-brand-500/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
              </div>

              <h2 class="text-2xl font-bold text-white mb-1 relative z-10"><?php echo htmlspecialchars($user['Firstname'] . ' ' . $user['Lastname']); ?></h2>
              <p class="text-brand-400 font-semibold mb-4 relative z-10">@<?php echo htmlspecialchars($user['Username']); ?></p>
              
              <div class="inline-flex items-center px-4 py-1.5 rounded-full bg-slate-900/50 border border-slate-700/50 text-slate-300 text-sm font-medium relative z-10 shadow-inner">
                <div class="w-2 h-2 rounded-full <?php echo ($user['Role'] == 'admin') ? 'bg-violet-500' : 'bg-emerald-500'; ?> mr-2 shadow-[0_0_8px_currentColor]"></div>
                <?php echo ucfirst(htmlspecialchars($user['Role'])); ?> Account
              </div>
            </div>
          </div>

          <!-- Data Grid -->
          <div class="md:col-span-2">
            <div class="backdrop-blur-xl bg-slate-800/40 p-8 md:p-10 rounded-3xl border border-slate-700/50 shadow-2xl h-full relative overflow-hidden">
               <div class="absolute inset-0 bg-gradient-to-br from-white/[0.02] to-transparent pointer-events-none"></div>
              
              <h3 class="text-xl font-bold text-white mb-8 flex items-center border-b border-slate-700/50 pb-4 relative z-10">
                <i class="fa-solid fa-address-card text-brand-400 mr-3"></i> Personal Information
              </h3>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-8 gap-x-6 relative z-10">
                
                <div class="group">
                  <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1.5 flex items-center">
                    <i class="fa-solid fa-envelope mr-2 text-slate-600 group-hover:text-brand-400 transition-colors"></i> Email Address
                  </h4>
                  <p class="text-lg font-medium text-slate-200 bg-slate-900/50 px-4 py-2.5 rounded-xl border border-slate-700/50 shadow-inner truncate">
                    <?php echo htmlspecialchars($user['Email']); ?>
                  </p>
                </div>

                <div class="group">
                  <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1.5 flex items-center">
                    <i class="fa-solid fa-briefcase mr-2 text-slate-600 group-hover:text-brand-400 transition-colors"></i> Occupation
                  </h4>
                  <p class="text-lg font-medium text-slate-200 bg-slate-900/50 px-4 py-2.5 rounded-xl border border-slate-700/50 shadow-inner truncate">
                    <?php echo htmlspecialchars($user['Occupation']); ?>
                  </p>
                </div>

                <div class="group">
                  <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1.5 flex items-center">
                    <i class="fa-solid fa-globe mr-2 text-slate-600 group-hover:text-brand-400 transition-colors"></i> Country
                  </h4>
                  <p class="text-lg font-medium text-slate-200 bg-slate-900/50 px-4 py-2.5 rounded-xl border border-slate-700/50 shadow-inner truncate">
                    <?php echo htmlspecialchars($user['Country'] ?? 'Not set'); ?>
                  </p>
                </div>

                <div class="group">
                  <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1.5 flex items-center">
                    <i class="fa-solid fa-venus-mars mr-2 text-slate-600 group-hover:text-brand-400 transition-colors"></i> Gender
                  </h4>
                  <p class="text-lg font-medium text-slate-200 bg-slate-900/50 px-4 py-2.5 rounded-xl border border-slate-700/50 shadow-inner truncate">
                    <?php echo htmlspecialchars($user['Gender']); ?>
                  </p>
                </div>

                <div class="group">
                  <h4 class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1.5 flex items-center">
                    <i class="fa-solid fa-shield-halved mr-2 text-slate-600 group-hover:text-brand-400 transition-colors"></i> Account Status
                  </h4>
                  <p class="text-lg font-medium text-slate-200 bg-slate-900/50 px-4 py-2.5 rounded-xl border border-slate-700/50 shadow-inner truncate flex items-center">
                    <i class="fa-solid fa-check-circle text-emerald-500 mr-2"></i> Active & Verified
                  </p>
                </div>

              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>