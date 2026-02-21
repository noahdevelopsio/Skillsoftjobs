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
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <?php include("includes/navbar.php"); ?>

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