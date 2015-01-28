<link rel="stylesheet" type="text/css" href="style.css">

<?php

$host = 'itp460.usc.edu';
$dbname = 'dvd';
$user = 'student';
$pass = 'ttrojan';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);

$rating = $_GET['rating_name'];

?>

<h1>
    <strong>Rating: </strong> <?php echo $rating ?>
</h1>

<?php

$sql = "
        SELECT title, rating_name
        FROM dvds
        INNER JOIN ratings
        ON dvds.rating_id = ratings.id
        WHERE rating_name = ?
";

$statement = $pdo->prepare($sql);
$statement->bindParam(1, $rating);
$statement->execute();
$dvds = $statement->fetchAll(PDO::FETCH_OBJ);

?>

<ul>
<?php foreach($dvds as $dvd) : ?>

<li><?php echo $dvd->title ?></li>

<?php endforeach ?>
</ul>