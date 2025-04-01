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
    <link rel="icon" type="image/png" href="/favicon.ico" />
    <title>Skillsoft | Begin a Career in Tech</title>
  </head>
  <body>
    <section class="bg-indigo-50">
      <div class="container m-auto max-w-2xl py-24">
        <div class="bg-white px-6 py-8 mb-4 shadow-md rounded-md border m-4 md:m-0">
          <?php
          include("php/config.php");

          if (isset($_POST['submit'])) {
              // Sanitize inputs
              $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
              $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
              $username = mysqli_real_escape_string($con, $_POST['username']);
              $gender = mysqli_real_escape_string($con, $_POST['gender']);
              $occupation = mysqli_real_escape_string($con, $_POST['occupation']);
              $email = mysqli_real_escape_string($con, $_POST['email']);
              $password = mysqli_real_escape_string($con, $_POST['password']);

              // Verify unique email
              $verify_query = mysqli_query($con, "SELECT Email FROM users WHERE Email='$email'");

              if (mysqli_num_rows($verify_query) != 0) {
                  echo "<div class='message'>
                            <p>This email is already in use. Please try another one.</p>
                        </div> <br>";
                  echo "<a href='javascript:self.history.back()'><button class='bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full w-full focus:outline-none focus:shadow-outline'>Go Back</button></a>";
              } else {
                  // Insert user into the database (without hashing the password)
                  $insert_query = "INSERT INTO users (Firstname, Lastname, Username, Gender, Occupation, Role, Email, Password) 
                                   VALUES ('$firstname', '$lastname', '$username', '$gender', '$occupation', 'user', '$email', '$password')";

                  if (mysqli_query($con, $insert_query)) {
                      echo "<div class='message'>
                                <p>Registration successful!</p>
                            </div> <br>";
                      echo "<a href='login.php'><button class='bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full w-full focus:outline-none focus:shadow-outline'>Login Now</button></a>";
                  } else {
                      echo "<div class='message'>
                                <p>Error occurred during registration. Please try again.</p>
                            </div> <br>";
                      echo "<a href='javascript:self.history.back()'><button class='bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full w-full focus:outline-none focus:shadow-outline'>Go Back</button></a>";
                  }
              }
          } else {
          ?>
          <form action="" method="post">
            <h2 class="text-3xl text-center font-semibold mb-6">Sign Up</h2>
            <div class="mb-4">
              <label for="firstname" class="block text-gray-700 font-bold mb-2">First Name</label>
              <input
                type="text"
                id="firstname"
                name="firstname"
                class="border rounded w-full py-2 px-3"
                placeholder="John"
                required
              />
            </div>

            <div class="mb-4">
              <label for="lastname" class="block text-gray-700 font-bold mb-2">Last Name</label>
              <input
                type="text"
                id="lastname"
                name="lastname"
                class="border rounded w-full py-2 px-3"
                placeholder="Doe"
                required
              />
            </div>

            <div class="mb-4">
              <label for="username" class="block text-gray-700 font-bold mb-2">Username</label>
              <input
                type="text"
                id="username"
                name="username"
                class="border rounded w-full py-2 px-3"
                placeholder="Johndoe"
                required
              />
            </div>

            <div class="mb-4">
              <label for="gender" class="block text-gray-700 font-bold mb-2">Gender</label>
              <select
                id="gender"
                name="gender"
                class="border rounded w-full py-2 px-3"
                required
              >
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Others">Other binaries</option>
                <option value="private">Prefer not to say</option>
              </select>
            </div>

            <div class="mb-4">
              <label for="occupation" class="block text-gray-700 font-bold mb-2">Occupation</label>
              <input
                type="text"
                id="occupation"
                name="occupation"
                class="border rounded w-full py-2 px-3"
                placeholder="EX: Doctor"
                required
              />
            </div>

            <div class="mb-4">
              <label for="email" class="block text-gray-700 font-bold mb-2">Email</label>
              <input
                type="email"
                id="email"
                name="email"
                class="border rounded w-full py-2 px-3"
                placeholder="Johndoe@example.com"
                required
              />
            </div>

            <div class="mb-4">
              <label for="password" class="block text-gray-700 font-bold mb-2">Password</label>
              <input
                type="password"
                id="password"
                name="password"
                class="border rounded w-full py-2 px-3"
                placeholder="Input Password"
                required
              />
            </div>

            <div>
              <input
                class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded-full w-full focus:outline-none focus:shadow-outline"
                type="submit"
                name="submit"
                value="Register"
              />
            </div>
            <p class="text-center">
              Already have an account? <a class="text-orange-700" href="./login.php">Sign in</a>
            </p>
          </form>
          <?php } ?>
        </div>
      </div>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>