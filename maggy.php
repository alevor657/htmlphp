<?php
$title = "Maggy | BMO";
include("include/header.php");

$db = connectToDatabaseByPath($path);
$sql = "SELECT title, content, pubdate, author FROM Article WHERE category = 'maggy'";
$stmt = $db->prepare($sql);
$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($res);

$tit = $res[0]['title'];
$content = $res[0]['content'];
$pubdate = $res[0]['pubdate'];
$author = $res[0]['author'];

$result = <<<EOD
<article class="article">
    <p class="article-title">
        $tit
    </p>
    <br>
    <p class="article-content">
        $content
    </p>
    <p class="article-author">
        $author
    </p>

    <p class="article-pubdate">
        $pubdate
    </p>
</article>
EOD;

print($result);

include("include/footer.php");
