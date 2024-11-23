<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
//$stmt = $conn->query("SELECT * FROM countries");

$stmt = $conn->prepare('SELECT * FROM countries WHERE name LIKE :country');

$country =  isset($_GET['country']) ? filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING) : '';

//$stmt->bindParam(':country', $country,PDO::PARAM_STR);
$stmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<ul>
<?php foreach ($results as $row): ?>
	<!--
	<li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
	-->
	<li><?= htmlspecialchars($row['name']) . ' is ruled by ' . htmlspecialchars($row['head_of_state']); ?></li>
<?php endforeach; ?>
</ul>
