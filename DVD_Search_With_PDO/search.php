<?php

$dvd_title = $_GET['dvd_title'];

if (!isset($_GET['dvd_title'])) {
    header('Location: index.php');
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

<div>
    <p>You searched for: <?php echo $dvd_title ?></p>
</div>

<?php foreach($dvds as $dvd) : ?>
    <div>
        <p>
            <?php echo $dvd->title ?>
        </p>
        Genre:  <?php echo $dvd->genre_name ?>
        <br> Format: <?php echo $dvd->format_name ?></br>
        <br><a href="results.php?rating=<?php echo $dvd->rating_name ?>">
            <?php echo $dvd->rating_name ?></a></br>
        <br> </br>
    </div>
<?php endforeach ?>

