<?php
$mysqli = new mysqli('localhost', 'root', '', 'matcha_coffee');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>