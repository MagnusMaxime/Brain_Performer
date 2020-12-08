<?php
$path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);

if (!file_exists(__DIR__.$path)) {
    include "index.php";
}
else {
    return false;
}
?>
