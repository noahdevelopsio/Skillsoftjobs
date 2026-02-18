<?php
session_start();
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
    <title>Skillsoft | Begin a Career in Tech</title>
  </head>
  <body>
    <?php include("includes/navbar.php"); ?>


    <!-- Hero -->
    <section class="bg-indigo-700 py-20 mb-4">
      <div
        class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center"
      >
        <div class="text-center">
          <h1
            class="text-4xl font-extrabold text-white sm:text-5xl md:text-6xl"
          >
            Start a Tech Career
          </h1>
          <p class="my-4 text-xl text-white">
            Find the job that fits your skills and needs
          </p>
        </div>
      </div>
    </section>

    <!-- Employers -->
    <section class="py-4">
      <div class="container-xl lg:container m-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 rounded-lg">
          <div class="bg-gray-100 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold">For Job Seekers</h2>
            <p class="mt-2 mb-4">
              Browse our jobs and start your career today
            </p>
            <a
              href="jobs.php"
              class="inline-block bg-black text-white rounded-lg px-4 py-2 hover:bg-gray-700"
            >
              Browse Jobs
            </a>
          </div>
          <div class="bg-indigo-100 p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold">For Employers</h2>
            <p class="mt-2 mb-4">
              List your job to find the perfect employees for the role
            </p>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') : ?>
            <a
              href="add-job.php"
              class="inline-block bg-indigo-500 text-white rounded-lg px-4 py-2 hover:bg-indigo-600"
            >
              Add Job
            </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>

    <!-- Browse Jobs -->
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
              echo '<p class="text-center text-gray-600">No jobs found.</p>';
          }
          ?>
        </div>
      </div>
    </section>

    <section class="m-auto max-w-lg my-10 px-6">
      <a
        href="jobs.php"
        class="block bg-black text-white text-center py-4 px-6 rounded-xl hover:bg-gray-700"
        >View All Jobs</a
      >
    </section>

    <script src="js/main.js"></script>
  </body>
</html>