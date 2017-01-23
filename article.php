<?php
$title = "Artiklar | BMO";
include("include/header.php");
$selected = isset($_SESSION["search"]) ? $_SESSION["search"] : "";

$db = connectToDatabaseByPath($path);
if ($selected == "") {
    $sql = "SELECT title, content, author, pubdate FROM Article WHERE category = 'article'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
} else {
    $sql = "SELECT title, content, author, pubdate FROM Article WHERE category = 'article' AND title = ?";
    $stmt = $db->prepare($sql);
    $params = isset($_SESSION['search']) ? $_SESSION['search'] : "Begravningskonfekt";
    $stmt->execute([$params]);
}

$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
$related = '';

// var_dump($res);

?>
<form action="postform-article.php" method="post">
    <p>
        Visa artikel:
        <select name="search" onchange="form.submit()">
            <option <?=$selected == "" ? "selected" : ""?> value="">Alla</option>
            <option <?=$selected == "Begravningskonfekt" ? "selected" : ""?> value="Begravningskonfekt">Begravningskonfekt</option>
            <option <?=$selected == "Minnestavlor" ? "selected" : ""?> value="Minnestavlor">Minnestavlor</option>
            <option <?=$selected == "Pärlkransar" ? "selected" : ""?> value="Pärlkransar">Pärlkransar</option>
            <option <?=$selected == "Begravningsfest och Gravöl - ett stort kalas" ? "selected" : ""?> value="Begravningsfest och Gravöl - ett stort kalas">Begravningsfest</option>
        </select>
    </p>
</form>

<?php
printArticle($res);


include("include/footer.php");
