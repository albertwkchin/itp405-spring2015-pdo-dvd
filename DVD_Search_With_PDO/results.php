<link rel="stylesheet" type="text/css" href="style.css">

<?php

$dvd_title = $_GET['dvd_title'];

if (!isset($_GET['dvd_title'])) {
    header('Location: search.php');
}

if (empty($dvd_title)) {
    header('Location: search.php');
}

if ($dvd_title == '') {
    header('Location: search.php');
}


$host = 'itp460.usc.edu';
$dbname = 'dvd';
$user = 'student';
$password = 'ttrojan';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

$sql = "
    SELECT title, genre_name, format_name, rating_name
    FROM dvds
    INNER JOIN genres
    ON dvds.genre_id = genres.id
    INNER JOIN formats
    ON dvds.format_id = formats.id
    INNER JOIN ratings
    ON dvds.rating_id = ratings.id

    WHERE title LIKE ?
";

$statement = $pdo->prepare($sql);

$like = '%' . $dvd_title . '%';
$statement->bindParam(1, $like);

$statement->execute();
$dvds = $statement->fetchAll(PDO::FETCH_OBJ);

?>

<?php if(empty($dvds)) : ?>
    <div>
        <p1> Your search returned no results. </p1>
        <p3><br><a href = "search.php">Return to search</a></br></p3>
    </div>

<?php else : ?>
    <div>
        <h1>You searched for: <?php echo $dvd_title ?><h1>
    </div>
<?php endif; ?>

<?php foreach($dvds as $dvd) : ?>
    <div>
        <p1>
            <?php echo $dvd->title ?>
        </p1>
        <br> Genre:  <?php echo $dvd->genre_name ?> </br>
        <br> Format: <?php echo $dvd->format_name ?></br>
        <a href="ratings.php?rating_name=<?php echo $dvd->rating_name ?>">
            Rated: <?php echo $dvd->rating_name ?></a>
        <br> </br>
    </div>
<?php endforeach ?>

