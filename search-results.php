<?php
$title = "Search results | BMO";
include("include/header.php");

if (isset($_POST['search'])) {
    $db = connectToDatabaseByPath(PATH);
    $sql = "SELECT * FROM Article WHERE category = 'article' AND (title LIKE ? OR content LIKE ?)";
    $stmt = $db->prepare($sql);
    $params = array();
    for ($i = 0; $i < 2; $i ++) {
        array_push($params, is_string($_POST['search']) ? "%".$_POST['search']."%" : null);
    }
    $stmt->execute($params);
    $resArticle = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['search-results-article'] = $resArticle;

    $sql = "SELECT * FROM Object WHERE title LIKE ? OR text LIKE ?";
    $stmt = $db->prepare($sql);
    $params = array();
    for ($i = 0; $i < 2; $i ++) {
        array_push($params, is_string($_POST['search']) ? "%".$_POST['search']."%" : null);
    }
    $stmt->execute($params);
    $resObject = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_SESSION['search-results-object'] = $resObject;
}
print("<p>\"{$_POST['search']}\" bland artiklar:</p>");
printArticle($_SESSION['search-results-article']);
print("<p>\"{$_POST['search']}\" bland objekt:</p>");
printObject($_SESSION['search-results-object']);
include("include/footer.php");
