<?php
include(__DIR__ . "/session_helper.php");
init_session();
destroy_session();
header("Location: ../login.php");
exit();
