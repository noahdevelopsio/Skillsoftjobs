<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="fixed top-0 w-full z-50 backdrop-blur-xl bg-slate-900/80 border-b border-white/5 shadow-[0_4px_30px_rgba(0,0,0,0.3)]">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <!-- Logo -->
            <a class="flex flex-shrink-0 items-center group" href="index.php">
                <img class="h-8 w-auto" src="images/logo.png" alt="Skillsoft" />
                <span class="hidden sm:block text-white text-xl font-extrabold ml-2 tracking-tight group-hover:text-brand-400 transition-colors">Skillsoft</span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-1">
                <a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5'; ?> rounded-lg px-4 py-2 text-sm font-semibold transition-all duration-200">Home</a>
                <a href="jobs.php" class="<?php echo ($current_page == 'jobs.php') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5'; ?> rounded-lg px-4 py-2 text-sm font-semibold transition-all duration-200">Jobs</a>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                <a href="employer-dashboard.php" class="<?php echo ($current_page == 'employer-dashboard.php') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5'; ?> rounded-lg px-4 py-2 text-sm font-semibold transition-all duration-200">
                    <i class="fa-solid fa-chart-line mr-1.5 text-xs"></i>Dashboard
                </a>
                <a href="add-job.php" class="<?php echo ($current_page == 'add-job.php') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5'; ?> rounded-lg px-4 py-2 text-sm font-semibold transition-all duration-200">
                    <i class="fa-solid fa-plus mr-1.5 text-xs"></i>Post Job
                </a>
                <?php endif; ?>

                <!-- Profile Icon -->
                <a href="profile.php" class="ml-2 w-9 h-9 rounded-full bg-gradient-to-br from-brand-500 to-violet-500 flex items-center justify-center text-white text-sm font-bold hover:shadow-[0_0_15px_rgba(124,58,237,0.4)] transition-all">
                    <i class="fa-solid fa-user text-xs"></i>
                </a>
            </div>

            <!-- Mobile Hamburger Button -->
            <button id="mobile-menu-btn" class="md:hidden text-slate-400 hover:text-white p-2 rounded-lg hover:bg-white/5 transition-colors" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                <i class="fa-solid fa-bars text-lg"></i>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden border-t border-white/5 bg-slate-900/95 backdrop-blur-xl">
        <div class="px-4 py-4 space-y-2">
            <a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5'; ?> block rounded-lg px-4 py-3 text-sm font-semibold transition-all">
                <i class="fa-solid fa-home mr-2 w-5 text-center"></i>Home
            </a>
            <a href="jobs.php" class="<?php echo ($current_page == 'jobs.php') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5'; ?> block rounded-lg px-4 py-3 text-sm font-semibold transition-all">
                <i class="fa-solid fa-briefcase mr-2 w-5 text-center"></i>Jobs
            </a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
            <a href="employer-dashboard.php" class="<?php echo ($current_page == 'employer-dashboard.php') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5'; ?> block rounded-lg px-4 py-3 text-sm font-semibold transition-all">
                <i class="fa-solid fa-chart-line mr-2 w-5 text-center"></i>Dashboard
            </a>
            <a href="add-job.php" class="<?php echo ($current_page == 'add-job.php') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5'; ?> block rounded-lg px-4 py-3 text-sm font-semibold transition-all">
                <i class="fa-solid fa-plus mr-2 w-5 text-center"></i>Post Job
            </a>
            <?php endif; ?>
            <a href="profile.php" class="<?php echo ($current_page == 'profile.php') ? 'text-white bg-white/10' : 'text-slate-400 hover:text-white hover:bg-white/5'; ?> block rounded-lg px-4 py-3 text-sm font-semibold transition-all">
                <i class="fa-solid fa-user mr-2 w-5 text-center"></i>Profile
            </a>
        </div>
    </div>
</nav>
<!-- Spacer for fixed navbar -->
<div class="h-16"></div>
