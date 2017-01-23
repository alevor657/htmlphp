<?php
include("config.php");

$search = isset($_POST['search'])
    ? $_POST['search']
    : "Begravningskonfekt";

if ($search !== null) {
    $_SESSION['search'] = $search;
}

header("Location: article.php");
