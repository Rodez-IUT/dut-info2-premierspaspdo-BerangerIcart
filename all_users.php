<?php
$host = 'localhost';
$db   = 'my-activities';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
     throw new PDOException($e->getMessage(), (int)$e->getCode());
}

$status_id = "2";
$userLike = "e%";

$get = $pdo->query("	SELECT u.id, u.username, u.email, s.name status_intitul 
						FROM users u 
						INNER JOIN status s ON s.id = u.status_id 
						WHERE u.status_id = $status_id AND u.username LIKE '$userLike'
						ORDER BY u.username ASC");

?>
<html>
<head>
	<meta charset="utf-8">
</head>
<body>
	<h1>All users</h1>
	<table>
		<tr>
			<th>Id</th>
			<th>Username</th>
			<th>Email</th>
			<th>Status</th>
		</tr>
		<?php
		while ($fetch = $get->fetch()) {
			?>
			<tr>
				<td><?= $fetch["id"] ?></td>
				<td><?= $fetch["username"] ?></td>
				<td><?= $fetch["email"] ?></td>
				<td><?= $fetch["status_intitul"] ?></td>
			</tr>
			<?php
		}
		?>
	</table>
</body>
</html>