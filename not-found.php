<?php
include("php/session_helper.php");
init_session();

include("php/config.php");
if (!isset($_SESSION['valid'])) {
    header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php include("includes/head.php"); ?>
    <title>Skillsoft | 404 Not Found</title>
  </head>
  <body>
    <?php include("includes/navbar.php"); ?>

    <section class="text-center flex flex-col justify-center items-center h-96">
      <i class="fas fa-exclamation-triangle text-yellow-400 fa-4x mb-4"></i>
      <h1 class="text-6xl font-bold mb-4">404 Not Found</h1>
      <p class="text-xl mb-5">This page does not exist</p>
      <a
        href="index.php"
        class="text-white bg-indigo-700 hover:bg-indigo-900 rounded-md px-3 py-2 mt-4"
        >Go Back</a
      >
    </section>

    <script src="js/main.js"></script>
  </body>
</html>
