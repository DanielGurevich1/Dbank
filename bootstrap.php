<?php
session_start();

if (!isset($_SESSION['messages'])) {
    $_SESSION['messages']['success'] = [];
    $_SESSION['messages']['error'] = [];
    $_SESSION['messages']['warning'] = [];
}
define('URL', 'http://localhost:8898/Dbank/');
define('DIR', __DIR__ . '/');
require DIR . 'functions.php';

foreach ($_SESSION['messages']['success'] as $message) {
    echo "<h3 style='color:green; margin-left: 150px';>$message</h3>";
}
$_SESSION['messages']['success'] = [];


foreach ($_SESSION['messages']['error'] as $message) {
    echo "<h3 style='color:red; margin-left: 150px';>$message</h2>";
}
$_SESSION['messages']['error'] = [];

foreach ($_SESSION['messages']['warning'] as $message) {
    echo "<h3 style='color:orange; margin-left: 150px';>$message</h2>";
}
$_SESSION['messages']['warning'] = [];
// _d($_SESSION);