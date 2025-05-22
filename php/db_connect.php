<?php
// Log folder path
$log_dir = "/home/it-future/www/itf/logs/";
$success_log = $log_dir . "db_success.log";
$error_log = $log_dir . "db_error.log";

// Ensure error reporting is enabled for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if log directory exists and is writable
if (!file_exists($log_dir)) {
    mkdir($log_dir, 0775, true);
    file_put_contents($error_log, "Log directory created at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
}
if (!is_writable($log_dir)) {
    file_put_contents($error_log, "Log directory is not writable at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
    echo "Log directory is not writable!";
    exit();
}

// Log before attempting connection
file_put_contents($success_log, "Attempting database connection at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

$host = "mysql2103.db.sakura.ne.jp";
$dbname = "it-future_itf";
$username = "it-future_itf";
$password = "future1800";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("SET NAMES utf8");
    // Log success
    file_put_contents($success_log, "Database connection successful at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
} catch (PDOException $e) {
    // Log detailed error
    $error_message = "Database Connection Failed: " . $e->getMessage() . " | Host: $host | DB: $dbname | User: $username | Time: " . date('Y-m-d H:i:s');
    file_put_contents($error_log, $error_message . "\n", FILE_APPEND);
    echo "Connection failed: " . $e->getMessage();
    exit();
}
?>