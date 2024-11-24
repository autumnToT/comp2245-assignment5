<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
//$stmt = $conn->query("SELECT * FROM countries");

//$stmt = $conn->prepare('SELECT * FROM countries WHERE name LIKE :country');

$country =  isset($_GET['country']) ? filter_input(INPUT_GET, 'country', FILTER_SANITIZE_STRING) : '';
$lookup = isset($_GET['lookup']) ? filter_input(INPUT_GET, 'lookup', FILTER_SANITIZE_STRING) : '';

if($lookup == 'cities'){
	$stmt = $conn->prepare('SELECT cities.name, cities.district, cities.population FROM countries JOIN cities ON countries.code = cities.country_code WHERE countries.name LIKE :country');
	//$stmt->bindParam(':country', $country,PDO::PARAM_STR);
	$stmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
	
}else{
	$stmt = $conn->prepare('SELECT * FROM countries WHERE name LIKE :country');
	$stmt->bindValue(':country', '%' . $country . '%', PDO::PARAM_STR);
}
	
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!--
<ul>
<?php foreach ($results as $row): ?>

	<li><?= $row['name'] . ' is ruled by ' . $row['head_of_state']; ?></li>
	
	<li><?= htmlspecialchars($row['name']) . ' is ruled by ' . htmlspecialchars($row['head_of_state']); ?></li>
<?php endforeach; ?>
</ul>
-->
<?php if(empty($results)): ?>
	<p style="color: red;">No countries found matching your search.</p>
<?php else: ?>
	<?php if($lookup == 'cities'): ?>
		<table>
			<tr>
				<th><?='Name';?></th>
				<th><?='District';?></th>
				<th><?='Population';?></th>
			</tr>
			<?php foreach ($results as $row): ?>
			<tr>
				<td><?=$row['name'];?></td>
				<td><?=$row['district'];?></td>
				<td><?=$row['population'];?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	<?php else: ?>
		<table>
			<tr>
				<th><?='Name';?></th>
				<th><?='Continent';?></th>
				<th><?='Independence';?></th>
				<th><?='Head of State';?></th>
			</tr>
			<?php foreach ($results as $row): ?>
			<tr>
				<td><?=$row['name'];?></td>
				<td><?=$row['continent'];?></td>
				<td><?=$row['independence_year'];?></td>
				<td><?=$row['head_of_state'];?></td>
			</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>
<?php endif; ?>