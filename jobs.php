<?php
include("php/session_helper.php");
init_session();
include("php/config.php");

// Handle filter inputs
$filter = isset($_GET['filter']) ? trim(mysqli_real_escape_string($con, $_GET['filter'])) : '';
$type_filter = isset($_GET['type']) ? trim(mysqli_real_escape_string($con, $_GET['type'])) : '';
$location_filter = isset($_GET['location']) ? trim(mysqli_real_escape_string($con, $_GET['location'])) : '';

// Fetch distinct types and locations for filter dropdowns
$types_result = mysqli_query($con, "SELECT DISTINCT type FROM jobs ORDER BY type ASC");
$locations_result = mysqli_query($con, "SELECT DISTINCT location FROM jobs ORDER BY location ASC");

// Build dynamic query
$conditions = [];
$types = "";
$params = [];

// Keyword search
if (!empty($filter)) {
    $keywords = explode(' ', $filter);
    foreach ($keywords as $word) {
        $word = trim($word);
        if (strlen($word) > 1) {
            $conditions[] = "(title LIKE ? OR location LIKE ? OR type LIKE ? OR company LIKE ? OR description LIKE ?)";
            $types .= "sssss";
            $searchTerm = "%{$word}%";
            array_push($params, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        }
    }
}

// Type filter
if (!empty($type_filter)) {
    $conditions[] = "type = ?";
    $types .= "s";
    $params[] = $type_filter;
}

// Location filter
if (!empty($location_filter)) {
    $conditions[] = "location = ?";
    $types .= "s";
    $params[] = $location_filter;
}

// Build final query — randomize order
if (count($conditions) > 0) {
    $query = "SELECT * FROM jobs WHERE " . implode(" AND ", $conditions) . " ORDER BY RAND()";
    $stmt = $con->prepare($query);
    $stmt->execute(array_merge([$types], $params));
    $result = $stmt->get_result();
} else {
    $query = "SELECT * FROM jobs ORDER BY RAND()";
    $result = mysqli_query($con, $query);
}

$has_filters = !empty($filter) || !empty($type_filter) || !empty($location_filter);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("includes/head.php"); ?>
    <title>Skillsoft | Browse Jobs</title>

  </head>
  <body>
    <?php include("includes/navbar.php"); ?>

    <!-- Hero Search Section -->
    <section class="relative pt-24 pb-16 overflow-hidden bg-slate-950">
      <div class="absolute inset-0 bg-gradient-to-b from-slate-900 via-slate-950 to-slate-900 z-10"></div>
      <div class="absolute top-1/2 left-1/4 w-96 h-96 bg-brand-600/20 rounded-full blur-[128px] mix-blend-screen pointer-events-none transform -translate-y-1/2"></div>
      <div class="absolute top-1/2 right-1/4 w-96 h-96 bg-violet-600/20 rounded-full blur-[128px] mix-blend-screen pointer-events-none transform -translate-y-1/2" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite 1s;"></div>

      <div class="container mx-auto px-4 relative z-20">
        <div class="text-center mb-10">
          <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Job <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-violet-400">Board</span></h1>
          <p class="text-lg text-slate-400 max-w-2xl mx-auto">Find the perfect role tailored to your skills and aspirations.</p>
        </div>

        <!-- Search + Filters -->
        <div class="max-w-4xl mx-auto">
          <div class="backdrop-blur-xl bg-white/5 p-4 rounded-2xl border border-white/10 shadow-[0_0_40px_rgba(0,0,0,0.5)] relative">
            
            <form method="GET" action="jobs.php" class="space-y-4">
              <!-- Search Bar -->
              <div class="relative flex items-center">
                <i class="fa-solid fa-magnifying-glass absolute left-5 text-slate-500 text-lg"></i>
                <input
                  type="text"
                  name="filter"
                  class="w-full py-4 pl-14 pr-36 bg-slate-900/50 border border-slate-700/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 text-white text-lg placeholder:text-slate-500 font-medium transition-all"
                  placeholder="Search by role, location, or company..."
                  value="<?php echo htmlspecialchars($filter); ?>"
                />
                <button type="submit" class="absolute right-2 top-2 bottom-2 bg-gradient-to-r from-brand-600 to-violet-600 hover:from-brand-500 hover:to-violet-500 text-white px-8 rounded-lg font-bold transition-all shadow-lg hover:shadow-brand-500/25">
                  Search
                </button>
              </div>

              <!-- Filter Dropdowns -->
              <div class="flex flex-wrap gap-3">
                <!-- Job Type Filter -->
                <div class="relative flex-1 min-w-[160px]">
                  <select name="type" class="w-full bg-slate-900/80 border border-slate-700/50 rounded-xl py-3 pl-10 pr-4 text-sm font-semibold text-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all appearance-none cursor-pointer">
                    <option value="" class="bg-slate-900">All Job Types</option>
                    <?php while ($t = mysqli_fetch_assoc($types_result)): ?>
                      <option value="<?php echo htmlspecialchars($t['type']); ?>" class="bg-slate-900" <?php echo ($type_filter == $t['type']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($t['type']); ?>
                      </option>
                    <?php endwhile; ?>
                  </select>
                  <i class="fa-solid fa-clock absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs pointer-events-none"></i>
                  <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs pointer-events-none"></i>
                </div>

                <!-- Location Filter -->
                <div class="relative flex-1 min-w-[160px]">
                  <select name="location" class="w-full bg-slate-900/80 border border-slate-700/50 rounded-xl py-3 pl-10 pr-4 text-sm font-semibold text-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all appearance-none cursor-pointer">
                    <option value="" class="bg-slate-900">All Locations</option>
                    <?php while ($l = mysqli_fetch_assoc($locations_result)): ?>
                      <option value="<?php echo htmlspecialchars($l['location']); ?>" class="bg-slate-900" <?php echo ($location_filter == $l['location']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($l['location']); ?>
                      </option>
                    <?php endwhile; ?>
                  </select>
                  <i class="fa-solid fa-location-dot absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs pointer-events-none"></i>
                  <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-500 text-xs pointer-events-none"></i>
                </div>

                <?php if ($has_filters): ?>
                <a href="jobs.php" class="flex items-center px-4 py-3 rounded-xl bg-red-500/10 hover:bg-red-500/20 text-red-400 text-sm font-bold border border-red-500/20 transition-all">
                  <i class="fa-solid fa-xmark mr-2"></i>Clear
                </a>
                <?php endif; ?>
              </div>
            </form>
          </div>

          <!-- Active filters pills -->
          <?php if ($has_filters): ?>
          <div class="flex flex-wrap gap-2 mt-4 justify-center">
            <?php if (!empty($filter)): ?>
              <span class="inline-flex items-center bg-brand-500/10 text-brand-300 border border-brand-500/20 px-3 py-1.5 rounded-full text-xs font-bold">
                <i class="fa-solid fa-magnifying-glass mr-1.5"></i><?php echo htmlspecialchars($filter); ?>
              </span>
            <?php endif; ?>
            <?php if (!empty($type_filter)): ?>
              <span class="inline-flex items-center bg-violet-500/10 text-violet-300 border border-violet-500/20 px-3 py-1.5 rounded-full text-xs font-bold">
                <i class="fa-solid fa-clock mr-1.5"></i><?php echo htmlspecialchars($type_filter); ?>
              </span>
            <?php endif; ?>
            <?php if (!empty($location_filter)): ?>
              <span class="inline-flex items-center bg-emerald-500/10 text-emerald-300 border border-emerald-500/20 px-3 py-1.5 rounded-full text-xs font-bold">
                <i class="fa-solid fa-location-dot mr-1.5"></i><?php echo htmlspecialchars($location_filter); ?>
              </span>
            <?php endif; ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <!-- All Jobs -->
    <section class="bg-slate-900 px-4 py-20 relative overflow-hidden border-t border-white/5">
      <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-between mb-10">
          <div>
            <h2 class="text-2xl font-extrabold text-white">
              <?php echo $has_filters ? 'Search Results' : 'Available Roles'; ?>
            </h2>
            <p class="text-slate-400 text-sm font-medium mt-1"><?php echo mysqli_num_rows($result); ?> role<?php echo mysqli_num_rows($result) != 1 ? 's' : ''; ?> found</p>
          </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <?php
          if (mysqli_num_rows($result) > 0) {
              while ($job = mysqli_fetch_assoc($result)) {
                  echo '
                  <a href="job-details.php?id=' . $job['id'] . '" class="group block">
                    <div class="h-full bg-[#151c2c] rounded-2xl border border-slate-700/50 hover:border-brand-500/30 p-6 transition-all duration-300 hover:shadow-[0_0_30px_rgba(124,58,237,0.1)] hover:-translate-y-1">
                      <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-brand-500/20 to-violet-500/20 flex items-center justify-center">
                            <i class="fa-solid fa-building text-brand-400"></i>
                          </div>
                          <span class="text-sm text-slate-400 font-semibold truncate max-w-[180px]">' . htmlspecialchars($job['company'] ?? 'Company') . '</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                          <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" title="Actively Hiring"></div>
                          <span class="text-xs font-bold text-emerald-400">Hiring</span>
                        </div>
                      </div>
                      <h3 class="text-2xl font-bold text-white mb-3 group-hover:text-brand-300 transition-colors leading-tight line-clamp-2">' . htmlspecialchars($job['title']) . '</h3>
                      <p class="text-slate-400 text-sm leading-relaxed mb-4 line-clamp-2">' . htmlspecialchars(substr($job['description'], 0, 120)) . '...</p>
                      <div class="flex flex-wrap gap-2 mb-4">
                        <span class="px-3 py-1 rounded-lg bg-brand-500/10 text-brand-300 text-xs font-bold border border-brand-500/10">' . htmlspecialchars($job['type']) . '</span>
                        <span class="px-3 py-1 rounded-lg bg-slate-800 text-slate-300 text-xs font-bold border border-slate-700/50"><i class="fa-solid fa-location-dot mr-1.5 text-slate-500"></i>' . htmlspecialchars($job['location']) . '</span>
                      </div>
                      <div class="pt-4 border-t border-slate-700/50 flex items-center justify-between">
                        <span class="text-sm font-bold text-emerald-400">' . htmlspecialchars($job['salary']) . '</span>
                        <span class="text-xs font-bold text-slate-500 group-hover:text-brand-400 transition-colors">View Details <i class="fa-solid fa-arrow-right ml-1"></i></span>
                      </div>
                    </div>
                  </a>';
              }
          } else {
              echo '
                    <div class="col-span-full py-16 text-center bg-[#151c2c] rounded-2xl border border-slate-700/50 border-dashed">
                      <div class="inline-flex w-16 h-16 rounded-full bg-slate-800 items-center justify-center mb-4">
                        <i class="fa-solid fa-magnifying-glass text-2xl text-slate-500"></i>
                      </div>
                      <h3 class="text-xl font-bold text-white mb-2">No roles found</h3>
                      <p class="text-slate-400 font-medium">Try adjusting your search criteria or keywords.</p>
                      <a href="jobs.php" class="inline-block mt-6 px-6 py-2 rounded-lg bg-white/5 hover:bg-white/10 text-white font-medium transition-colors border border-white/10">Clear Filters</a>
                    </div>';
          }
          ?>
        </div>
      </div>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>