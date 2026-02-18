<?php
session_start();
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
            $_SESSION['id'] = $row['Id'];

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
          <form action="" method="post">
            <h2 class="text-3xl text-center font-semibold mb-6">Sign in</h2>

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
                value="Sign In"
              />
            </div>
            <p class="text-center">
              Don't have an account? <a class="text-orange-700" href="./register.php">Create an account</a>
            </p>
          </form>
        </div>
      </div>
    </section>

    <script src="js/main.js"></script>
  </body>
</html>