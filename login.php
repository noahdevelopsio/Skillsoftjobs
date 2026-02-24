<?php
include("php/session_helper.php");
init_session();
include("php/config.php");

if (isset($_POST['submit'])) {
    // Sanitize inputs
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    // Fetch user from the database
    $query = "SELECT * FROM users WHERE Email=?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = mysqli_fetch_assoc($result);

        // Verify password (if hashed, use password_verify())
        if ($password === $row['Password']) { // Replace with password_verify($password, $row['Password']) if hashed
            // Set session variables
            $_SESSION['valid'] = $row['Email'];
            $_SESSION['username'] = $row['Username'];
            $_SESSION['role'] = $row['Role'];
            $_SESSION['id'] = $row['id'];

            // Save session to cookie for serverless persistence
            save_session();

            // Redirect to the home page
            header("Location: index.php");
            exit();
        } else {
            echo "<div class='message'>
                      <p>Wrong Username or Password</p>
                  </div> <br>";
            echo "<a href='login.php'><button class='bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full w-full focus:outline-none focus:shadow-outline'>Go Back</button></a>";
        }
    } else {
        echo "<div class='message'>
                  <p>User not found. Please check your email.</p>
              </div> <br>";
        echo "<a href='login.php'><button class='bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full w-full focus:outline-none focus:shadow-outline'>Go Back</button></a>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("includes/head.php"); ?>
    <title>Skillsoft | Sign In</title>
  </head>
  <body>
    <section class="min-h-screen relative flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 overflow-hidden bg-slate-900">
      <!-- Animated Mesh/Glow Background -->
      <div class="absolute inset-0 w-full h-full bg-slate-900 z-0"></div>
      <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-brand-600/20 blur-[120px] mix-blend-screen animate-pulse z-0"></div>
      <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-violet-600/20 blur-[120px] mix-blend-screen z-0" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite 2s;"></div>
      
      <!-- Glassmorphic Card -->
      <div class="relative w-full max-w-md z-10">
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 p-10 rounded-3xl shadow-2xl relative overflow-hidden">
          
          <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent opacity-50 pointer-events-none"></div>

          <div class="text-center mb-10">
            <h2 class="text-4xl font-extrabold text-white tracking-tight mb-2">Welcome Back</h2>
            <p class="text-slate-400 font-medium">Sign in to continue to Skillsoft</p>
          </div>

          <form action="" method="post" class="space-y-6 relative z-10">
            <!-- Email Input -->
            <div class="relative group">
              <label for="email" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Email Address</label>
              <div class="relative">
                <i class="fa-solid fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-500 group-focus-within:text-brand-500 transition-colors"></i>
                <input
                  type="email"
                  id="email"
                  name="email"
                  class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                  placeholder="name@example.com"
                  required
                />
              </div>
            </div>

            <!-- Password Input -->
            <div class="relative group">
              <label for="password" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Password</label>
              <div class="relative">
                <i class="fa-solid fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-slate-500 group-focus-within:text-brand-500 transition-colors"></i>
                <input
                  type="password"
                  id="password"
                  name="password"
                  class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3.5 pl-12 pr-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                  placeholder="••••••••"
                  required
                />
              </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-2">
              <input
                class="w-full bg-gradient-to-r from-brand-600 to-violet-600 hover:from-brand-500 hover:to-violet-500 text-white font-bold py-4 px-6 rounded-xl cursor-pointer shadow-[0_0_20px_rgba(124,58,237,0.3)] hover:shadow-[0_0_25px_rgba(124,58,237,0.5)] transform hover:-translate-y-0.5 transition-all duration-300"
                type="submit"
                name="submit"
                value="Sign In"
              />
            </div>
            
            <p class="text-center text-slate-400 mt-6 font-medium">
              New here? <a class="text-brand-400 hover:text-brand-300 transition-colors underline decoration-brand-400/30 underline-offset-4" href="./register.php">Create an account</a>
            </p>
          </form>
        </div>
      </div>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>