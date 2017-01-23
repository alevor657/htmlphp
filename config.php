<?php
$name = substr(preg_replace('/[^a-z\d]/i', '', __DIR__), -30);
session_name($name);
session_start();

$path = __DIR__ . DIRECTORY_SEPARATOR . "db" . DIRECTORY_SEPARATOR . "bmo2.sqlite";
define('PATH', $path);
$dsn = "sqlite:$path";
define("DSN", $dsn);


function connectToDatabaseByPath()
{
    // Open the database file and catch the exception it it fails.
    try {
        $db = new PDO(DSN);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo "Failed to connect to the database using DSN:<br>".DSN."<br>";
        throw $e;
    }
    return $db;
}

function getObject($title)
{
    $db = connectToDatabaseByPath(PATH);
    $sql = "SELECT title, text, image, owner, id FROM Object WHERE category LIKE ?";
    $stmt = $db->prepare($sql);
    $params = [$title];
    $stmt->execute($params);
    $resObj = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $resObj;
}

function printArticle($res)
{
    for ($i = 0; $i < count($res); $i ++) {
        $related = <<<EOD
        <h3>Relatedate Objekt:<h3>
EOD;
        $tit = $res[$i]['title'];
        $content = $res[$i]['content'];
        $author = $res[$i]['author'];
        $pubdate = $res[$i]['pubdate'];
        $object = getObject($tit);

        foreach ($object as $key => $value) {
            $id = $object[$key]['id'];
            $related .= <<<EOD
            <a href="object.php?id=$id"><img src="img/80x80/{$value['image']}"/></a>
EOD;
        }
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
            <p class="article-author">
                $author
            </p>
            <p class="article-pubdate">
                $pubdate
            </p>
            $related
        </article>
EOD;
        print($result);
    }
}


function printObject($res)
{
    $result = "";
    for ($i = 0; $i < count($res); $i ++) {
        $tit = $res[$i]['title'];
        $text = $res[$i]['text'];
        $image = $res[$i]['image'];
        $owner = $res[$i]['owner'];
        $id = $res[$i]['id'];

        $result = <<<EOD
        <article class="article-object">
            <img src="img/80x80/$image" />
            <a href="object.php?id=$id">
                <p>$tit</p>
            </a>
            <p>
                $text
            </p>
            <p class="object-owner">
                <span>Ägare: </span>$owner
            </p>
        </article>
EOD;
        if (!is_null($tit)) {
            print($result);
        }
    }
}

function printObjectByID()
{
    $db = connectToDatabaseByPath(PATH);
    $sql = "SELECT title, category, text, image, owner, id FROM Object WHERE id = ?";
    $stmt = $db->prepare($sql);
    $params = isset($_GET['id']) ? $_GET['id'] : null;
    $stmt->execute([$params]);
    $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = "";
    for ($i = 0; $i < count($res); $i ++) {
        $tit = $res[$i]['title'];
        // $category = $res[$i]['category'];
        $text = $res[$i]['text'];
        $image = $res[$i]['image'];
        $owner = $res[$i]['owner'];
        $id = $res[$i]['id'];
        $next = $id + 1;
        $prev = $id - 1;
        $disabledPrev = $id == 1 ? "disabled" : "";
        $disabledNext = $id == 30 ? "disabled" : "";

        $result = <<<EOD
            <article>
            <a href="object.php"><button>Till alla objekt</button></a>
            <a href="object.php?id=$prev"><button $disabledPrev>Föregående</button></a>
            <a href="object.php?id=$next"><button $disabledNext>Nästa</button></a>
            <a href="object.php?id=$id">
                <h1 class="centered">$tit</h1>
            </a>
                <img src="img/550x550/$image" class="centered main-image" />
            <p>
                $text
            </p>
            <p>
                <span>Ägare: </span>$owner
            </p>
        </article>
EOD;
        print($result);
    }
}

function printGallery($res)
{
    $current = isset($_GET['current']) ? $_GET['current'] : 0;
    $next = $current + 15;
    $prev = $current - 15;
    $disabledPrev = $current == 0 ? "disabled" : "";
    $disabledNext = $current == 15 ? "disabled" : "";

    $result = <<<EOD
    <div>
        <h2>Detta är museums bildsamling, du kan gå till objektet eller direkt till bilden</h2>
        <a href="gallery.php?current=$prev"><button $disabledPrev>Föregående</button></a>
        <a href="gallery.php?current=$next"><button $disabledNext>Nästa</button ></a>
    </div>
EOD;
    print($result);

    galleryFor($res, $current, $next);
}

function galleryFor($res, $current, $next)
{
    for ($i = $current; $i < count($res); $i++) {
        //<mos>: Skriv om det i redovisningstexten och förklara varför funktoinen
        //ser ut som den gör, i projektet får det finnas en visst utrymme
        //causes 125 pts complexity
        if ($i >= $next) {
            break;
        }
        $image = $res[$i]['image'];
        $id = $res[$i]['id'];
        $result = <<<EOD
            <figure class="gallery-figure">
                <a href="img/full-size/$image"><img src="img/250x250/$image" /></a>
                <a href="object.php?id=$id">
                    <figcaption>
                        Gå till obekt
                    </figcaption>
                </a>
            </figure>
EOD;
        print($result);
    }
}
