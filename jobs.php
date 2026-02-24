<?php
session_start();
include("php/config.php");

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

// Handle filter input
$filter = isset($_GET['filter']) ? trim(mysqli_real_escape_string($con, $_GET['filter'])) : '';

if (!empty($filter)) {
    // Split the search string into individual keywords
    $keywords = explode(' ', $filter);
    
    // Build dynamic SQL for keyword searching
    $conditions = [];
    $types = "";
    $params = [];
    
    foreach ($keywords as $word) {
        $word = trim($word);
        if (strlen($word) > 1) { // Ignore single-character words
            $conditions[] = "(title LIKE ? OR location LIKE ? OR type LIKE ? OR company LIKE ? OR description LIKE ?)";
            $types .= "sssss";
            $searchTerm = "%{$word}%";
            // Add the same parameter 5 times for the 5 columns checked
            array_push($params, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
        }
    }
    
    if (count($conditions) > 0) {
        $query = "SELECT * FROM jobs WHERE " . implode(" AND ", $conditions) . " ORDER BY id DESC";
        $stmt = $con->prepare($query);
        
        // Dynamically bind parameters
        $stmt->execute(array_merge([$types], $params));
        $result = $stmt->get_result();
    } else {
        // Fallback if no valid keywords were entered
        $query = "SELECT * FROM jobs ORDER BY id DESC";
        $result = mysqli_query($con, $query);
    }
} else {
    $query = "SELECT * FROM jobs ORDER BY id DESC";
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

    <!-- Filter Jobs Console -->
    <section class="bg-slate-900 pt-32 pb-20 relative overflow-hidden">
      <!-- Animated Background Elements -->
      <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80')] bg-cover bg-center opacity-10 mix-blend-overlay"></div>
      <div class="absolute top-0 inset-x-0 h-40 bg-gradient-to-b from-slate-900 to-transparent z-10"></div>
      
      <!-- Glowing Orbs -->
      <div class="absolute top-1/2 left-1/4 w-96 h-96 bg-brand-600/20 rounded-full blur-[128px] mix-blend-screen pointer-events-none transform -translate-y-1/2"></div>
      <div class="absolute top-1/2 right-1/4 w-96 h-96 bg-violet-600/20 rounded-full blur-[128px] mix-blend-screen pointer-events-none transform -translate-y-1/2" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite 1s;"></div>

      <div class="container mx-auto px-4 relative z-20">
        <div class="text-center mb-10">
          <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight mb-4">Command <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-400 to-violet-400">Center</span></h1>
          <p class="text-lg text-slate-400 max-w-2xl mx-auto">Find the perfect tech role tailored to your skills and aspirations.</p>
        </div>

        <div class="max-w-3xl mx-auto backdrop-blur-xl bg-white/5 p-3 rounded-2xl border border-white/10 shadow-[0_0_40px_rgba(0,0,0,0.5)] transform hover:scale-[1.01] transition-transform duration-300 relative group">
          <div class="absolute inset-0 bg-gradient-to-r from-brand-500/10 via-transparent to-violet-500/10 opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-500 pointer-events-none"></div>
          
          <form method="GET" action="jobs.php" class="relative flex items-center">
            <i class="fa-solid fa-magnifying-glass absolute left-6 text-slate-500 text-lg group-focus-within:text-brand-400 transition-colors"></i>
            <input
              type="text"
              name="filter"
              class="w-full py-4 pl-14 pr-36 bg-slate-900/50 border border-slate-700/50 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 text-white text-lg placeholder:text-slate-500 font-medium transition-all"
              placeholder="Search by role, location, or tech stack..."
              value="<?php echo htmlspecialchars($filter); ?>"
            />
            <button type="submit" class="absolute right-2 top-2 bottom-2 bg-gradient-to-r from-brand-600 to-violet-600 hover:from-brand-500 hover:to-violet-500 text-white px-8 rounded-lg font-bold transition-all shadow-lg hover:shadow-brand-500/25">
              Search
            </button>
          </form>
        </div>
      </div>
    </section>

    <!-- All Jobs -->
    <section class="bg-slate-900 px-4 py-20 relative overflow-hidden border-t border-white/5">
      <div class="container-xl lg:container m-auto relative z-10 max-w-7xl">
        <div class="flex justify-between items-center mb-10">
          <h2 class="text-3xl font-bold text-white tracking-tight">
            <?php echo empty($filter) ? 'Latest Roles' : 'Search Results'; ?>
          </h2>
          <span class="text-slate-400 font-medium"><?php echo mysqli_num_rows($result); ?> Roles</span>
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
                        $description = htmlspecialchars($job['description']);
                        if (strlen($description) > 90) {
                            echo substr($description, 0, 90) . '...';
                        } else {
                            echo $description;
                        }
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
              echo '<div class="col-span-full py-16 text-center bg-slate-800/30 rounded-3xl border border-slate-700/50 border-dashed">
                      <div class="inline-flex w-16 h-16 rounded-full bg-slate-800 items-center justify-center mb-4">
                        <i class="fa-solid fa-magnifying-glass text-2xl text-slate-500"></i>
                      </div>
                      <h3 class="text-xl font-bold text-white mb-2">No roles found</h3>
                      <p class="text-slate-400 font-medium">Try adjusting your search criteria or tech stack filters.</p>
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