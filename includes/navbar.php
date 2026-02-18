<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav class="bg-indigo-700 border-b border-indigo-500">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
    <div class="flex h-20 items-center justify-between">
        <div class="flex flex-1 items-center justify-center md:items-stretch md:justify-start">
        <!-- Logo -->
        <a class="flex flex-shrink-0 items-center mr-4" href="index.php">
            <img class="h-10 w-auto" src="images/logo.png" alt="Skillsoft" />
            <span class="hidden md:block text-white text-2xl font-bold ml-2">Skillsoft</span>
        </a>
        <div class="md:ml-auto">
            <div class="flex space-x-2">
            <a href="index.php" class="<?php echo ($current_page == 'index.php') ? 'bg-black text-white hover:bg-gray-900 hover:text-white' : 'text-white hover:bg-gray-900 hover:text-white'; ?> rounded-md px-3 py-2">Home</a>
            <a href="jobs.php" class="<?php echo ($current_page == 'jobs.php') ? 'bg-black text-white hover:bg-gray-900 hover:text-white' : 'text-white hover:bg-gray-900 hover:text-white'; ?> rounded-md px-3 py-2">Jobs</a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
            <a href="add-job.php" class="<?php echo ($current_page == 'add-job.php') ? 'bg-black text-white hover:bg-gray-900 hover:text-white' : 'text-white hover:bg-gray-900 hover:text-white'; ?> rounded-md px-3 py-2">Add Job</a>
            <?php endif; ?>
            <!-- Profile Icon -->
            <a href="profile.php" class="text-indigo-500 border-indigo-500 bg-indigo-100 hover:bg-gray-900 hover:text-white rounded-full px-3 py-2">
                <i class="fa-solid fa-user"></i>
            </a>
            </div>
        </div>
        </div>
    </div>
    </div>
</nav>
