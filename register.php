<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("includes/head.php"); ?>
    <title>Skillsoft | Create Account</title>
  </head>
  <body>
    <section class="min-h-screen relative flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 overflow-hidden bg-slate-900">
      <!-- Animated Mesh/Glow Background -->
      <div class="absolute inset-0 w-full h-full bg-slate-900 z-0"></div>
      <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-violet-600/20 blur-[120px] mix-blend-screen animate-pulse z-0"></div>
      <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-brand-600/20 blur-[120px] mix-blend-screen z-0" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite 2s;"></div>
      
      <!-- Glassmorphic Card -->
      <div class="relative w-full max-w-2xl z-10 my-8">
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 p-8 md:p-12 rounded-3xl shadow-2xl relative overflow-hidden">
          
          <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent opacity-50 pointer-events-none"></div>

          <div class="text-center mb-10 relative z-10">
            <h2 class="text-4xl font-extrabold text-white tracking-tight mb-2">Join Skillsoft</h2>
            <p class="text-slate-400 font-medium">Create your account to browse premium roles</p>
          </div>

          <div class="relative z-10">
          <?php
          include("php/config.php");

          if (isset($_POST['submit'])) {
              // Sanitize inputs
              $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
              $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
              $username = mysqli_real_escape_string($con, $_POST['username']);
              $gender = mysqli_real_escape_string($con, $_POST['gender']);
              $occupation = mysqli_real_escape_string($con, $_POST['occupation']);
              $country = mysqli_real_escape_string($con, $_POST['country']);
              $city = mysqli_real_escape_string($con, $_POST['city']);
              $email = mysqli_real_escape_string($con, $_POST['email']);
              $password = mysqli_real_escape_string($con, $_POST['password']);

              // Verify unique email
              $stmt = $con->prepare("SELECT Email FROM users WHERE Email=?");
              $stmt->bind_param("s", $email);
              $stmt->execute();
              $verify_query = $stmt->get_result();

              if ($verify_query->num_rows != 0) {
                  echo "<div class='bg-red-500/10 border border-red-500/30 rounded-xl p-4 mb-6 text-center text-red-400 font-medium'>
                            <p>This email is already in use. Please try another one.</p>
                        </div>";
                  echo "<a href='javascript:self.history.back()' class='block w-full text-center bg-white/10 hover:bg-white/20 text-white font-bold py-3 px-4 rounded-xl transition-all border border-white/10'>Go Back</a>";
              } else {
                  // Insert user into the database (without hashing the password)
                  $insert_query = "INSERT INTO users (Firstname, Lastname, Username, Gender, Occupation, Role, Email, Country, City, Password) 
                                   VALUES (?, ?, ?, ?, ?, 'user', ?, ?, ?, ?)";
                  $stmt = $con->prepare($insert_query);
                  $stmt->bind_param("sssssssss", $firstname, $lastname, $username, $gender, $occupation, $email, $country, $city, $password);

                  if ($stmt->execute()) {
                      echo "<div class='bg-emerald-500/10 border border-emerald-500/30 rounded-xl p-4 mb-6 text-center text-emerald-400 font-medium'>
                                <p>Registration successful! Welcome aboard.</p>
                            </div>";
                      echo "<a href='login.php' class='block w-full text-center bg-gradient-to-r from-brand-600 to-violet-600 hover:from-brand-500 hover:to-violet-500 text-white font-bold py-4 px-6 rounded-xl transition-all shadow-lg'>Login Now</a>";
                  } else {
                      echo "<div class='bg-red-500/10 border border-red-500/30 rounded-xl p-4 mb-6 text-center text-red-400 font-medium'>
                                <p>Error occurred during registration. Please try again.</p>
                            </div>";
                      echo "<a href='javascript:self.history.back()' class='block w-full text-center bg-white/10 hover:bg-white/20 text-white font-bold py-3 px-4 rounded-xl transition-all border border-white/10'>Go Back</a>";
                  }
              }
          } else {
          ?>
          <form action="" method="post" class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- First Name -->
              <div class="group">
                <label for="firstname" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">First Name</label>
                <input
                  type="text"
                  id="firstname"
                  name="firstname"
                  class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                  placeholder="John"
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
                  placeholder="Doe"
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
                  placeholder="johndoe99"
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
                  <option value="" disabled selected class="bg-slate-900">Select Gender...</option>
                  <option value="Male" class="bg-slate-900">Male</option>
                  <option value="Female" class="bg-slate-900">Female</option>
                  <option value="Others" class="bg-slate-900">Other / Non-binary</option>
                  <option value="private" class="bg-slate-900">Prefer not to say</option>
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
                placeholder="Software Engineer, Designer, etc."
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
                placeholder="Lagos"
                required
              />
            </div>

            <!-- Email Input -->
            <div class="group relative">
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
            <div class="group relative">
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
            <div class="pt-4">
              <input
                class="w-full bg-gradient-to-r from-brand-600 to-violet-600 hover:from-brand-500 hover:to-violet-500 text-white font-bold py-4 px-6 rounded-xl cursor-pointer shadow-[0_0_20px_rgba(124,58,237,0.3)] hover:shadow-[0_0_25px_rgba(124,58,237,0.5)] transform hover:-translate-y-0.5 transition-all duration-300"
                type="submit"
                name="submit"
                value="Create Account"
              />
            </div>
            
            <p class="text-center text-slate-400 mt-6 font-medium">
              Already have an account? <a class="text-brand-400 hover:text-brand-300 transition-colors underline decoration-brand-400/30 underline-offset-4" href="./login.php">Sign in</a>
            </p>
          </form>
          <?php } ?>
          </div>
        </div>
      </div>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>