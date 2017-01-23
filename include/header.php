<?php
include(__DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . "config.php");
?>

<!DOCTYPE html>
<html lang="sv">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">
        <title><?= $title ?></title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="icon" type="image/png" href="favicon.png" />
        <!-- <link rel='shortcut icon' href='img/favicon.ico'/> -->
    </head>

    <body>
        <header>
            <nav class="navbar">
                <a href="index.php" class="<?= basename($_SERVER['REQUEST_URI']) == "index.php" ? "selected" : ""; ?>">Hem</a>
                <a href="object.php" class="<?= basename($_SERVER['REQUEST_URI']) == "object.php" ? "selected" : ""; ?>">Objekt</a>
                <a href="article.php" class="<?= basename($_SERVER['REQUEST_URI']) == "article.php" ? "selected" : ""; ?>">Artiklar</a>
                <a href="maggy.php" class="<?= basename($_SERVER['REQUEST_URI']) == "maggy.php" ? "selected" : ""; ?>">Seder och bruk</a>
                <a href="about.php" class="<?= basename($_SERVER['REQUEST_URI']) == "about.php" ? "selected" : ""; ?>">Om oss</a>
                <a href="gallery.php" class="<?= basename($_SERVER['REQUEST_URI']) == "gallery.php" ? "selected" : ""; ?>">Bildgalleri</a>
                <!-- class="<?= basename($_SERVER['REQUEST_URI']) == "stylechooser.php" ? "selected" : ""; ?>" -->
            </nav>
            <a href="index.php"><img src="img/logo.png" alt="logo" class="logo"/></a>
        </header>

        <main>
