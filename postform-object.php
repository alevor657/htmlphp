<?php
include("config.php");

$search = isset($_POST['search-obj'])
    ? $_POST['search-obj']
    : null;

if ($search !== null) {
    $_SESSION['search-obj'] = $search;
}

header("Location: object.php");
