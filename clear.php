<?php

$password = "flashvault2025";

// Check if password is provided

if (!isset($_GET['p']) || $_GET['p'] !== $password) {

    die("Access Denied");

}

// Clear the log file

if (file_exists('logins.txt')) {

    file_put_contents('logins.txt', '');

}

// Redirect back to viewer

header("Location: view.php?p=" . $password);

exit;

?>