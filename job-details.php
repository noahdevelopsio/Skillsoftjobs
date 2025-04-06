<?php
session_start();
include("php/config.php");

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

// Get the job ID from the URL
$job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch job details from the database
$query = "SELECT * FROM jobs WHERE id = $job_id";
$result = mysqli_query($con, $query);

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
    <link rel="icon" type="image/png" href="/favicon.ico" />
    <title>Skillsoft Tech | Career</title>
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
                alt="Skillsoft"
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
                  class="text-white hover:bg-gray-900 hover:text-white rounded-md px-3 py-2"
                  >Jobs</a
                >
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
                <a
                  href="add-job.php"
                  class="text-white bg-black hover:bg-gray-900 hover:text-white rounded-md px-3 py-2"
                  >Add Job</a
                >
                <?php endif; ?>
                <a class="text-indigo-500 border-indigo-500 bg-indigo-100 hover:bg-gray-900 hover:text-white rounded-full px-3 py-2">
                  <i class="fa-solid fa-user"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Go Back -->
    <section>
      <div class="container m-auto py-6 px-6">
        <a
          href="jobs.php"
          class="text-indigo-500 hover:text-indigo-600 flex items-center"
        >
          <i class="fas fa-arrow-left mr-2"></i> Back to Job Listings
        </a>
      </div>
    </section>

    <section class="bg-indigo-50">
      <div class="container m-auto py-10 px-6">
        <div class="grid grid-cols-1 md:grid-cols-70/30 w-full gap-6">
          <main>
            <div
              class="bg-white p-6 rounded-lg shadow-md text-center md:text-left"
            >
              <div class="text-gray-500 mb-4"><?php echo htmlspecialchars($job['type']); ?></div>
              <h1 class="text-3xl font-bold mb-4">
                <?php echo htmlspecialchars($job['title']); ?>
              </h1>
              <div
                class="text-gray-500 mb-4 flex align-middle justify-center md:justify-start"
              >
                <i
                  class="fa-solid fa-location-dot text-lg text-orange-700 mr-2"
                ></i>
                <p class="text-orange-700"><?php echo htmlspecialchars($job['location']); ?></p>
              </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md mt-6">
              <h3 class="text-indigo-800 text-lg font-bold mb-6">
                Job Description
              </h3>

              <p class="mb-4">
                <?php echo htmlspecialchars($job['description']); ?>
              </p>

              <h3 class="text-indigo-800 text-lg font-bold mb-2">Salary</h3>

              <p class="mb-4"><?php echo htmlspecialchars($job['salary']); ?></p>
            </div>

            <!-- Job Requirements -->
            <div class="bg-white p-6 rounded-lg shadow-md mt-6">
              <h3 class="text-indigo-800 text-lg font-bold mb-6">
                Job Requirements
              </h3>

              <p class="mb-4">
                <ul>
                  <li>No Experience Needed, but individuals must be computer literate.</li>
                  <li>Resume / CV</li>
                  <li>Cover letter</li>
                  <li>Add a short note on why you are the right person for the job and how available you are.</li>
                  <li>Training for 2 Weeks: ($30/hour)</li> 
                </ul>                             
              </p>
              <a 
                href="apply.php?id=<?php echo $job['id']; ?>" 
                class="bg-indigo-500 hover:bg-indigo-600 text-white text-center font-bold py-2 px-4 rounded-full w-full focus:outline-none focus:shadow-outline mt-4 block"
              >
                Apply
              </a>
            </div>
          </main>

          <!-- Sidebar -->
          <aside>
            <!-- Company Info -->
            <div class="bg-white p-6 rounded-lg shadow-md">
              <h3 class="text-xl font-bold mb-6">Company Info</h3>

              <h2 class="text-2xl"><?php echo htmlspecialchars($job['company']); ?></h2>

              <p class="my-2">
                <?php echo htmlspecialchars($job['company_description']); ?>
              </p>

              <hr class="my-4" />

              <h3 class="text-xl font-bold">Contact Email:</h3>

              <p class="my-2 bg-indigo-100 p-2 font-bold">
                <?php echo htmlspecialchars($job['contact_email']); ?>
              </p>

              <h3 class="text-xl font-bold">Contact Phone:</h3>

              <p class="my-2 bg-indigo-100 p-2 font-bold">
                <?php echo htmlspecialchars($job['contact_phone']); ?>
              </p>
            </div>
          </aside>
        </div>
      </div>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>