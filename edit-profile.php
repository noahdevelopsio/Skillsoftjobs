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

$success = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $gender = mysqli_real_escape_string($con, $_POST['gender']);
    $occupation = mysqli_real_escape_string($con, $_POST['occupation']);
    $country = mysqli_real_escape_string($con, $_POST['country']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    $email = mysqli_real_escape_string($con, $_POST['email']);

    // Update user data in the database
    $update_query = "UPDATE users SET Firstname = '$firstname', Lastname = '$lastname', Username = '$username', Gender = '$gender', Occupation = '$occupation', Country = '$country', City = '$city', Email = '$email' WHERE id = $user_id";
    mysqli_query($con, $update_query);

    // Update session
    $_SESSION['username'] = $username;
    $_SESSION['valid'] = $email;
    save_session();

    // Redirect to profile page
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("includes/head.php"); ?>
    <title>Edit Profile | Skillsoft</title>
  </head>
  <body>
    <?php include("includes/navbar.php"); ?>

    <section class="min-h-screen relative flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 overflow-hidden bg-slate-900">
      <!-- Animated Glow Background -->
      <div class="absolute inset-0 w-full h-full bg-slate-900 z-0"></div>
      <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-violet-600/20 blur-[120px] mix-blend-screen animate-pulse z-0"></div>
      <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-brand-600/20 blur-[120px] mix-blend-screen z-0" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite 2s;"></div>
      
      <!-- Glassmorphic Card -->
      <div class="relative w-full max-w-2xl z-10 my-8">
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 p-8 md:p-12 rounded-3xl shadow-2xl relative overflow-hidden">
          
          <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent opacity-50 pointer-events-none"></div>

          <!-- Back Button -->
          <a href="profile.php" class="inline-flex items-center text-slate-400 font-semibold hover:text-white transition-colors mb-6 group relative z-10">
            <div class="w-8 h-8 rounded-full border border-slate-700 group-hover:bg-white/10 flex items-center justify-center mr-3 transition-colors">
              <i class="fas fa-arrow-left text-sm group-hover:-translate-x-0.5 transition-transform"></i>
            </div>
            Back to Profile
          </a>

          <div class="text-center mb-10 relative z-10">
            <div class="inline-flex w-16 h-16 rounded-2xl bg-gradient-to-br from-brand-500 to-violet-500 items-center justify-center mb-4 shadow-lg">
              <i class="fa-solid fa-user-pen text-2xl text-white"></i>
            </div>
            <h2 class="text-4xl font-extrabold text-white tracking-tight mb-2">Edit Profile</h2>
            <p class="text-slate-400 font-medium">Update your personal information below</p>
          </div>

          <div class="relative z-10">
          <form method="POST" action="" class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- First Name -->
              <div class="group">
                <label for="firstname" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">First Name</label>
                <input
                  type="text"
                  id="firstname"
                  name="firstname"
                  class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                  value="<?php echo htmlspecialchars($user['Firstname']); ?>"
                  required
                />
              </div>

              <!-- Last Name -->
              <div class="group">
                <label for="lastname" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Last Name</label>
                <input
                  type="text"
                  id="lastname"
                  name="lastname"
                  class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                  value="<?php echo htmlspecialchars($user['Lastname']); ?>"
                  required
                />
              </div>

              <!-- Username -->
              <div class="group">
                <label for="username" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Username</label>
                <input
                  type="text"
                  id="username"
                  name="username"
                  class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                  value="<?php echo htmlspecialchars($user['Username']); ?>"
                  required
                />
              </div>

              <!-- Gender -->
              <div class="group">
                <label for="gender" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Gender</label>
                <select
                  id="gender"
                  name="gender"
                  class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300 appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%2394a3b8%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:12px_12px] bg-[right_16px_center] bg-no-repeat"
                  required
                >
                  <option value="Male" class="bg-slate-900" <?php echo ($user['Gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                  <option value="Female" class="bg-slate-900" <?php echo ($user['Gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                  <option value="Others" class="bg-slate-900" <?php echo ($user['Gender'] == 'Others') ? 'selected' : ''; ?>>Other / Non-binary</option>
                  <option value="private" class="bg-slate-900" <?php echo ($user['Gender'] == 'private') ? 'selected' : ''; ?>>Prefer not to say</option>
                </select>
              </div>
            </div>

            <!-- Occupation -->
            <div class="group">
              <label for="occupation" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Current Occupation</label>
              <input
                type="text"
                id="occupation"
                name="occupation"
                class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                value="<?php echo htmlspecialchars($user['Occupation']); ?>"
                required
              />
            </div>

            <!-- Country -->
            <div class="group">
              <label for="country" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Country</label>
              <input
                type="text"
                id="country"
                name="country"
                class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                value="<?php echo htmlspecialchars($user['Country'] ?? ''); ?>"
                placeholder="Nigeria"
                required
              />
            </div>

            <!-- City -->
            <div class="group">
              <label for="city" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">City</label>
              <input
                type="text"
                id="city"
                name="city"
                class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                value="<?php echo htmlspecialchars($user['City'] ?? ''); ?>"
                placeholder="Lagos"
                required
              />
            </div>
            <!-- Email -->
            <div class="group relative">
              <label for="email" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Email Address</label>
              <div class="relative">
                <i class="fa-solid fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-500 group-focus-within:text-brand-500 transition-colors"></i>
                <input
                  type="email"
                  id="email"
                  name="email"
                  class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                  value="<?php echo htmlspecialchars($user['Email']); ?>"
                  required
                />
              </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
              <button
                type="submit"
                class="flex-1 bg-gradient-to-r from-brand-600 to-violet-600 hover:from-brand-500 hover:to-violet-500 text-white font-bold py-4 px-6 rounded-xl cursor-pointer shadow-[0_0_20px_rgba(124,58,237,0.3)] hover:shadow-[0_0_25px_rgba(124,58,237,0.5)] transform hover:-translate-y-0.5 transition-all duration-300"
              >
                Save Changes
              </button>
              <a
                href="profile.php"
                class="flex-1 text-center bg-white/5 hover:bg-white/10 text-white font-bold py-4 px-6 rounded-xl border border-white/10 transition-all duration-300 hover:-translate-y-0.5"
              >
                Cancel
              </a>
            </div>
          </form>
          </div>
        </div>
      </div>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>