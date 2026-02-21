<?php
include("php/session_helper.php");
init_session();
include("php/config.php");

// Redirect to login if the user is not authenticated
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
    exit();
}

// Only admins (employers) can post jobs
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: jobs.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $type = mysqli_real_escape_string($con, $_POST['type']);
    $title = mysqli_real_escape_string($con, $_POST['title']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $salary = mysqli_real_escape_string($con, $_POST['salary']);
    $location = mysqli_real_escape_string($con, $_POST['location']);
    $company = mysqli_real_escape_string($con, $_POST['company']);
    $company_description = mysqli_real_escape_string($con, $_POST['company_description']);
    $contact_email = mysqli_real_escape_string($con, $_POST['contact_email']);
    $contact_phone = mysqli_real_escape_string($con, $_POST['contact_phone']);
    $candidate_requirements = mysqli_real_escape_string($con, $_POST['candidate_requirements']);

    // Application Requirements
    $req_passport = isset($_POST['req_passport']) ? 1 : 0;
    $req_id = isset($_POST['req_id']) ? 1 : 0;
    $req_coverletter = isset($_POST['req_coverletter']) ? 1 : 0;

    // Validate required fields
    if (empty($type) || empty($title) || empty($description) || empty($salary) || empty($location) || empty($contact_email)) {
        echo "<script>alert('Please fill in all required fields.');</script>";
    } else {
        // Retrieve user_id from session to act as employer_id
        $employer_id = $_SESSION['id'];
        
        // Insert job data into the database
        $query = "INSERT INTO jobs (employer_id, type, title, description, candidate_requirements, salary, location, company, company_description, contact_email, contact_phone, req_passport, req_id, req_coverletter) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("issssssssssiii", $employer_id, $type, $title, $description, $candidate_requirements, $salary, $location, $company, $company_description, $contact_email, $contact_phone, $req_passport, $req_id, $req_coverletter);
        $result = $stmt->execute();

        if ($result) {
            echo "<script>alert('Job added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding job. Please try again.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("includes/head.php"); ?>
    <title>Skillsoft | Add job</title>
  </head>
  <body>
    <?php include("includes/navbar.php"); ?>

    <section class="min-h-screen relative flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 overflow-hidden bg-slate-900">
      <!-- Animated Mesh/Glow Background -->
      <div class="absolute inset-0 w-full h-full bg-slate-900 z-0"></div>
      <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-violet-600/20 blur-[120px] mix-blend-screen animate-pulse z-0"></div>
      <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-brand-600/20 blur-[120px] mix-blend-screen z-0" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite 2s;"></div>
      
      <!-- Glassmorphic Card -->
      <div class="relative w-full max-w-4xl z-10 my-8">
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 p-8 md:p-12 rounded-3xl shadow-2xl relative overflow-hidden">
          
          <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent opacity-50 pointer-events-none"></div>

          <div class="text-center mb-10 relative z-10">
            <h2 class="text-4xl font-extrabold text-white tracking-tight mb-2">Post a Position</h2>
            <p class="text-slate-400 font-medium">Find elite talent for your team.</p>
          </div>

          <div class="relative z-10">
            <form method="POST" action="" class="space-y-8">
              
              <!-- Role Details Section -->
              <div class="space-y-6">
                <h3 class="text-xl font-bold text-white border-b border-slate-700/50 pb-2 mb-4">Role Details</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <!-- Job Listing Name -->
                  <div class="group md:col-span-2">
                    <label for="title" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Job Title</label>
                    <input
                      type="text"
                      id="title"
                      name="title"
                      class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                      placeholder="e.g. Senior Frontend Engineer"
                      required
                    />
                  </div>

                  <!-- Job Type -->
                  <div class="group">
                    <label for="type" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Job Type</label>
                    <div class="relative">
                        <select
                          id="type"
                          name="type"
                          class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white appearance-none focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                          required
                        >
                          <option value="Full-Time" class="bg-slate-800">Full-Time</option>
                          <option value="Part-Time" class="bg-slate-800">Part-Time</option>
                          <option value="Remote" class="bg-slate-800">Remote</option>
                          <option value="Internship" class="bg-slate-800">Internship</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    </div>
                  </div>

                  <!-- Salary -->
                  <div class="group">
                    <label for="salary" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Salary Range</label>
                    <div class="relative">
                        <select
                          id="salary"
                          name="salary"
                          class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white appearance-none focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                          required
                        >
                          <option value="Under $50K" class="bg-slate-800">Under $50K</option>
                          <option value="$50K - 60K" class="bg-slate-800">$50K - $60K</option>
                          <option value="$60K - 70K" class="bg-slate-800">$60K - $70K</option>
                          <option value="$70K - 80K" class="bg-slate-800">$70K - $80K</option>
                          <option value="$80K - 90K" class="bg-slate-800">$80K - $90K</option>
                          <option value="$90K - 100K" class="bg-slate-800">$90K - $100K</option>
                          <option value="$100K - 125K" class="bg-slate-800">$100K - $125K</option>
                          <option value="$125K - 150K" class="bg-slate-800">$125K - $150K</option>
                          <option value="$150K - 175K" class="bg-slate-800">$150K - $175K</option>
                          <option value="$175K - 200K" class="bg-slate-800">$175K - $200K</option>
                          <option value="Over $200K" class="bg-slate-800">Over $200K</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    </div>
                  </div>

                  <!-- Location -->
                  <div class="group md:col-span-2">
                    <label for="location" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Location</label>
                    <input
                      type="text"
                      id="location"
                      name="location"
                      class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                      placeholder="e.g. San Francisco, CA (or Remote)"
                      required
                    />
                  </div>

                  <!-- Description -->
                  <div class="group md:col-span-2">
                    <label for="description" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Description</label>
                    <textarea
                      id="description"
                      name="description"
                      class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300 resize-y"
                      rows="6"
                      placeholder="Detail the responsibilities, requirements, and benefits..."
                      required
                    ></textarea>
                  </div>
                </div>
              </div>

              <!-- Company Info Section -->
              <div class="space-y-6 pt-6 mt-6 border-t border-slate-700/50">
                <h3 class="text-xl font-bold text-white border-b border-slate-700/50 pb-2 mb-4">Company Details</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <!-- Company Name -->
                  <div class="group md:col-span-2">
                    <label for="company" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Company Name</label>
                    <input
                      type="text"
                      id="company"
                      name="company"
                      class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                      placeholder="e.g. Acme Corp"
                      required
                    />
                  </div>

                  <!-- Contact Email -->
                  <div class="group">
                    <label for="contact_email" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Contact Email</label>
                    <input
                      type="email"
                      id="contact_email"
                      name="contact_email"
                      class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                      placeholder="careers@company.com"
                      required
                    />
                  </div>

                  <!-- Contact Phone -->
                  <div class="group">
                    <label for="contact_phone" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Contact Phone (Optional)</label>
                    <input
                      type="tel"
                      id="contact_phone"
                      name="contact_phone"
                      class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                      placeholder="(555) 123-4567"
                    />
                  </div>

                  <!-- Company Description -->
                  <div class="group md:col-span-2">
                    <label for="company_description" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Company Overview</label>
                    <textarea
                      id="company_description"
                      name="company_description"
                      class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300 resize-y"
                      rows="4"
                      placeholder="What is your company's mission and culture?"
                    ></textarea>
                  </div>

                  <!-- Candidate Requirements -->
                  <div class="group md:col-span-2">
                    <label for="candidate_requirements" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Candidate Requirements & Experience</label>
                    <textarea
                      id="candidate_requirements"
                      name="candidate_requirements"
                      class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300 resize-y"
                      rows="4"
                      placeholder="e.g. 2+ years of PHP experience, excellent communication skills..."
                      required
                    ></textarea>
                  </div>
                </div>
              </div>

              <!-- Application Requirements -->
              <div class="bg-slate-900/30 border border-slate-700/30 rounded-2xl p-6 md:p-8 space-y-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-brand-500/5 rounded-full blur-3xl pointer-events-none"></div>
                <h3 class="text-xl font-bold text-white border-b border-slate-700/50 pb-2 mb-4">Application Requirements</h3>
                <p class="text-sm text-slate-400 mb-4">Select which documents applicants must provide. (Resume/CV is always required)</p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                  <label class="flex items-center space-x-3 cursor-pointer group">
                    <div class="relative flex items-center justify-center">
                      <input type="checkbox" name="req_passport" value="1" class="peer sr-only" checked>
                      <div class="w-5 h-5 border-2 border-slate-600 rounded peer-checked:bg-brand-500 peer-checked:border-brand-500 transition-all"></div>
                      <i class="fa-solid fa-check absolute text-white text-xs opacity-0 peer-checked:opacity-100 drop-shadow-sm pointer-events-none"></i>
                    </div>
                    <span class="text-slate-300 font-medium group-hover:text-brand-400 transition-colors">Passport Photo</span>
                  </label>

                  <label class="flex items-center space-x-3 cursor-pointer group">
                    <div class="relative flex items-center justify-center">
                      <input type="checkbox" name="req_id" value="1" class="peer sr-only" checked>
                      <div class="w-5 h-5 border-2 border-slate-600 rounded peer-checked:bg-brand-500 peer-checked:border-brand-500 transition-all"></div>
                      <i class="fa-solid fa-check absolute text-white text-xs opacity-0 peer-checked:opacity-100 drop-shadow-sm pointer-events-none"></i>
                    </div>
                    <span class="text-slate-300 font-medium group-hover:text-brand-400 transition-colors">National ID / License</span>
                  </label>

                  <label class="flex items-center space-x-3 cursor-pointer group">
                    <div class="relative flex items-center justify-center">
                      <input type="checkbox" name="req_coverletter" value="1" class="peer sr-only">
                      <div class="w-5 h-5 border-2 border-slate-600 rounded peer-checked:bg-brand-500 peer-checked:border-brand-500 transition-all"></div>
                      <i class="fa-solid fa-check absolute text-white text-xs opacity-0 peer-checked:opacity-100 drop-shadow-sm pointer-events-none"></i>
                    </div>
                    <span class="text-slate-300 font-medium group-hover:text-brand-400 transition-colors">Cover Letter</span>
                  </label>
                </div>
              </div>

              <!-- Submit Button -->
              <div class="pt-6">
                <button
                  type="submit"
                  class="w-full py-4 px-6 rounded-xl bg-gradient-to-r from-brand-600 to-violet-600 hover:from-brand-500 hover:to-violet-500 text-white font-bold text-lg transition-all shadow-[0_0_20px_rgba(124,58,237,0.3)] hover:shadow-[0_0_30px_rgba(124,58,237,0.5)] transform hover:-translate-y-1"
                >
                  Publish Role
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>