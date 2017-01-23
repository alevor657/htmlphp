<?php
$title = "Gallery | BMO";
include("include/header.php");
$db = connectToDatabaseByPath(PATH);
$sql = "SELECT image, id FROM Object";
$stmt = $db->prepare($sql);
$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<article class="article-gallery">
    <?php printGallery($res); ?>
</article>
<?php

include("include/footer.php");
