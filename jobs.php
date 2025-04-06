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
if (!empty($filter)) {
    $query = "SELECT * FROM jobs 
              WHERE title LIKE '%$filter%' 
              OR location LIKE '%$filter%' 
              OR type LIKE '%$filter%' 
              OR description LIKE '%$filter%'";
} else {
    $query = "SELECT * FROM jobs";
}

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/jobs.css" />
    <link rel="icon" type="image/png" href="/favicon.ico" />
    <title>Skillsoft</title>

  </head>
  <body>
    <nav class="bg-indigo-700 border-b border-indigo-500">
      <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between">
          <div
            class="flex flex-1 items-center justify-center md:items-stretch md:justify-start"
          >
            <!-- Logo -->
            <a class="flex flex-shrink-0 items-center mr-4" href="index.php">
              <img
                class="h-10 w-auto"
                src="images/logo.png"
                alt="React Jobs"
              />
              <span class="hidden md:block text-white text-2xl font-bold ml-2"
                >Skillsoft</span
              >
            </a>
            <div class="md:ml-auto">
              <div class="flex space-x-2">
                <a
                  href="index.php"
                  class="text-white hover:bg-gray-900 hover:text-white rounded-md px-3 py-2"
                  >Home</a
                >
                <a
                  href="jobs.php"
                  class="text-white bg-black hover:bg-gray-900 hover:text-white rounded-md px-3 py-2"
                  >Jobs</a
                >
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                <a
                  href="add-job.php"
                  class="text-white hover:bg-gray-900 hover:text-white rounded-md px-3 py-2"
                  >Add Job</a
                >
                <?php endif; ?>
                <!-- Profile Icon -->
                 <a href="profile.php" class="text-indigo-500 border-indigo-500  bg-indigo-100 hover:bg-gray-900 hover:text-white rounded-full px-3 py-2">
                    <i class="fa-solid fa-user"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Filter Jobs -->
    <section class="bg-blue-50 py-4">
      <div class="container mx-auto px-4">
        <div class="search-container">
          <form method="GET" action="jobs.php">
            <input
              type="text"
              name="filter"
              class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:border-indigo-500"
              placeholder="Filter jobs by title, location, or type..."
              value="<?php echo htmlspecialchars($filter); ?>"
            />
            <button type="submit">
              <i class="fa-solid fa-magnifying-glass"></i>
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
                  <div class="bg-white rounded-xl shadow-md relative">
                    <div class="p-4">
                      <div class="mb-6">
                        <div class="text-gray-600 my-2">' . htmlspecialchars($job['type']) . '</div>
                        <h3 class="text-xl font-bold">' . htmlspecialchars($job['title']) . '</h3>
                      </div>

                      <div class="mb-5">
                        ';
                        $description = htmlspecialchars($job['description']);
                        if (strlen($description) > 90) {
                            echo substr($description, 0, 90) . '...';
                        } else {
                            echo $description;
                        }
                        echo '
                      </div>

                      <h3 class="text-indigo-500 mb-2">' . htmlspecialchars($job['salary']) . '</h3>

                      <div class="border border-gray-100 mb-5"></div>

                      <div class="flex flex-col lg:flex-row justify-between mb-4">
                        <div class="text-orange-700 mb-3">
                          <i class="fa-solid fa-location-dot text-lg"></i>
                          ' . htmlspecialchars($job['location']) . '
                        </div>
                        <a
                          href="job-details.php?id=' . $job['id'] . '"
                          class="h-[36px] bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded-lg text-center text-sm"
                        >
                          Read More
                        </a>
                      </div>
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