<?php
$title = "Objekt | BMO";
include("include/header.php");

$selected = isset($_SESSION["search-obj"]) ? $_SESSION["search-obj"] : "";

$db = connectToDatabaseByPath(PATH);
if ($selected == "") {
    $sql = "SELECT title, category, text, image, owner, id FROM Object";
    $stmt = $db->prepare($sql);
    $stmt->execute();
} else {
    $sql = "SELECT title, category, text, image, owner, id FROM Object WHERE category = ?";
    $stmt = $db->prepare($sql);
    $params = isset($_SESSION['search-obj']) ? $_SESSION['search-obj'] : null;
    $stmt->execute([$params]);
}
$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

$id = isset($_GET['id']) ? $_GET['id'] : null;

?>

<form action="postform-object.php" method="post">
    <p>
        Visa kategori:
        <select name="search-obj" onchange="form.submit()">
            <option <?=$selected == "" ? "selected" : ""?> value="">Alla</option>
            <option <?=$selected == "Begravningskonfekt" ? "selected" : ""?> value="Begravningskonfekt">Begravningskonfekt</option>
            <option <?=$selected == "Begravningssked" ? "selected" : ""?> value="Begravningssked">Begravningssked</option>
            <option <?=$selected == "Begravningstal" ? "selected" : ""?> value="Begravningstal">Begravningstal</option>
            <option <?=$selected == "Begravningsfest och Gravöl - ett stort kalas" ? "selected" : ""?> value="Begravningsfest och Gravöl - ett stort kalas">Begravningsfest</option>
            <option <?=$selected == "Inbjudningsbrev" ? "selected" : ""?> value="Inbjudningsbrev">Inbjudningsbrev</option>
            <option <?=$selected == "Minnestavlor" ? "selected" : ""?> value="Minnestavlor">Minnestavlor</option>
            <option <?=$selected == "Pärlkransar" ? "selected" : ""?> value="Pärlkransar">Pärlkransar</option>
        </select>
    </p>
</form>

<?php
if (isset($id)) {
    printObjectByID();
} else {
    printObject($res);
}
include("include/footer.php");
