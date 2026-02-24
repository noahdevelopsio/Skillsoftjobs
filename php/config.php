<?php 
// Extremely basic .env loader for local development
if (file_exists(__DIR__ . '/.env')) {
    $lines = file(__DIR__ . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        list($name, $value) = explode('=', $line, 2);
        putenv(trim($name) . '=' . trim($value));
    }
}

$db_host = getenv("DB_HOST");
$db_user = getenv("DB_USER");
$db_pass = getenv("DB_PASS");
$db_name = getenv("DB_NAME");
$db_port = getenv("DB_PORT") ? (int)getenv("DB_PORT") : 3306;

$con = mysqli_init();
// Ensure SSL connection is utilized if supported/required by the remote server (e.g. Aiven)
mysqli_real_connect($con, $db_host, $db_user, $db_pass, $db_name, $db_port, NULL, MYSQLI_CLIENT_SSL) or die("Couldn't connect: " . mysqli_connect_error());
?>