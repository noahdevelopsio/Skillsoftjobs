<?php
session_start();
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
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="css/styles.css" />
    <link rel="stylesheet" href="css/profile.css" />
    <link rel="icon" type="image/png" href="/favicon.ico" />
    <title>Profile | Skillsoft</title>
 
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
                  class="text-white hover:bg-gray-900 hover:text-white rounded-md px-3 py-2"
                  >Add Job</a
                >
                <?php endif; ?>
                <a href="profile.php" class="text-indigo-500 border-indigo-500 bg-indigo-100 hover:bg-gray-900 hover:text-white rounded-full px-3 py-2">
                  <i class="fa-solid fa-user"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Profile Section -->
    <section class="bg-indigo-50 py-10">
      <div class="container m-auto max-w-2xl px-4">
        <div class="profile-container">
          <h2 class="text-3xl font-bold text-indigo-500">Profile</h2>

          <!-- Display User Information -->
          <div class="profile-info">
            <label>First Name:</label>
            <p><?php echo htmlspecialchars($user['Firstname']); ?></p>
          </div>

          <div class="profile-info">
            <label>Last Name:</label>
            <p><?php echo htmlspecialchars($user['Lastname']); ?></p>
          </div>

          <div class="profile-info">
            <label>Username:</label>
            <p><?php echo htmlspecialchars($user['Username']); ?></p>
          </div>

          <div class="profile-info">
            <label>Gender:</label>
            <p><?php echo htmlspecialchars($user['Gender']); ?></p>
          </div>

          <div class="profile-info">
            <label>Occupation:</label>
            <p><?php echo htmlspecialchars($user['Occupation']); ?></p>
          </div>

          <div class="profile-info">
            <label>Email:</label>
            <p><?php echo htmlspecialchars($user['Email']); ?></p>
          </div>

          <div class="profile-info">
            <label>Role:</label>
            <p><?php echo htmlspecialchars($user['Role']); ?></p>
          </div>

          <!-- Edit Profile and Logout Buttons -->
          <div class="button-container">
            <a href="edit-profile.php">Edit Profile</a>
            <form method="POST" action="logout.php" class="w-full">
              <button type="submit">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>