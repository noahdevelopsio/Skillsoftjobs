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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $occupation = mysqli_real_escape_string($con, $_POST['occupation']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Update user data in the database
    $update_query = "UPDATE users SET Firstname = '$firstname', Lastname = '$lastname', Username = '$username', Gender = '$gender', Occupation = '$occupation', Email = '$email' WHERE id = $user_id";
    mysqli_query($con, $update_query);

    // Redirect to profile page
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include("includes/head.php"); ?>
    <title>Edit Profile | Skillsoft</title>
    <style>
      /* Additional Custom Styles */
      .form-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 2rem;
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }
      .form-group {
        margin-bottom: 1.5rem;
      }
      .form-group label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 0.5rem;
      }
      .form-group input,
      .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        font-size: 1rem;
        color: #4a5568;
        background-color: #f7fafc;
        transition: border-color 0.2s, box-shadow 0.2s;
      }
      .form-group input:focus,
      .form-group select:focus {
        border-color: #667eea;
        outline: none;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
      }
      .form-group select {
        appearance: none;
        background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1rem;
      }
      .button-container {
        display: flex;
        justify-content: center;
        margin-top: 2rem;
      }
      .button-container button {
        background-color: #667eea;
        color: #ffffff;
        font-weight: 600;
        padding: 0.75rem 2rem;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.2s;
      }
      .button-container button:hover {
        background-color: #5a67d8;
      }
    </style>
  </head>
  <body>
    <?php include("includes/navbar.php"); ?>

    <!-- Edit Profile Section -->
    <section class="bg-indigo-50 py-10">
      <div class="container m-auto max-w-2xl px-4">
        <div class="form-container">
          <h2 class="text-3xl font-bold text-indigo-500 mb-6 text-center">Edit Profile</h2>

          <!-- Edit Profile Form -->
          <form method="POST" action="">
            <div class="form-group">
              <label for="firstname">First Name:</label>
              <input
                type="text"
                id="firstname"
                name="firstname"
                value="<?php echo htmlspecialchars($user['Firstname']); ?>"
                required
              />
            </div>

            <div class="form-group">
              <label for="lastname">Last Name:</label>
              <input
                type="text"
                id="lastname"
                name="lastname"
                value="<?php echo htmlspecialchars($user['Lastname']); ?>"
                required
              />
            </div>

            <div class="form-group">
              <label for="username">Username:</label>
              <input
                type="text"
                id="username"
                name="username"
                value="<?php echo htmlspecialchars($user['Username']); ?>"
                required
              />
            </div>

            <div class="form-group">
              <label for="gender">Gender:</label>
              <select id="gender" name="gender" required>
                <option value="Male" <?php echo ($user['Gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($user['Gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                <option value="Others" <?php echo ($user['Gender'] == 'Others') ? 'selected' : ''; ?>>Other binaries</option>
                <option value="private" <?php echo ($user['Gender'] == 'private') ? 'selected' : ''; ?>>Prefer not to say</option>
              </select>
            </div>

            <div class="form-group">
              <label for="occupation">Occupation:</label>
              <input
                type="text"
                id="occupation"
                name="occupation"
                value="<?php echo htmlspecialchars($user['Occupation']); ?>"
                required
              />
            </div>

            <div class="form-group">
              <label for="email">Email:</label>
              <input
                type="email"
                id="email"
                name="email"
                value="<?php echo htmlspecialchars($user['Email']); ?>"
                required
              />
            </div>

            <div class="button-container">
              <button type="submit">Save Changes</button>
            </div>
          </form>
        </div>
      </div>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>