<?php
$title = "Om oss | BMO";
include("include/header.php");

$db = connectToDatabaseByPath($path);
$sql = "SELECT title, content, pubdate FROM Article WHERE category = 'about'";
$stmt = $db->prepare($sql);
$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

// var_dump($res);

$tit = $res[0]['title'];
$content = $res[0]['content'];
$pubdate = $res[0]['pubdate'];

$result = <<<EOD
<article class="article">
    <p class="article-title">
        $tit
    </p>
    <br>
    <p class="article-content">
        $content
    </p>
    <br>
    <p class="article-pubdate">
        $pubdate
    </p>
</article>
EOD;

print($result);
?>
<hr>
<center><p class="about-me">Utvecklare</p></center>
<img src="img/me.jpg" alt="My image" class="me-img" />
<p class="about-me">
    Jag heter Alexey och jag är 21 år gammal. Innan jag hade flyttat till Karlskrona så bodde jag med mina föräldrar
    i norra Stockholm, och innan dess så bodde jag i Moskva. Jag var alltid intreserad av teknik allmänt, men ännu mer av
    datorer och programmering. Jag tycker att det är spännande att skapa nya saker och automatisera dagliga rutiner.
    Jag brukar alltid vara den "händige" som fixar datorer/telefoner och så vidare. Sedan jag var en 14-åring så fick
    jag laga kompisars mobiler och datorer.<br>
    Jag har även utvecklat 2 mindre webbplatser åt en företag. Då hade jag använt mig av
    bootstrap, smoothscroll, ajax och ett par andra prylar. Nu så ser jag fram emot nya utmaningar och kunskaper!
</p>

<?php
include("include/footer.php");
