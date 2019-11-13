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

if (isset($_POST["submit"]) AND isset($_POST["statut"]) AND isset($_POST["lettre"])) {
	$status_id = $_POST["statut"];
	$userLike = $_POST["lettre"] ."%";

	$get = $pdo->prepare("	SELECT u.id, u.username, u.email, s.name status_intitul 
							FROM users u 
							INNER JOIN status s ON s.id = u.status_id 
							WHERE u.status_id = :status_id AND u.username LIKE :userLike
							ORDER BY u.username ASC");

	$get->execute(["status_id" => $status_id, "userLike" => $userLike]);
}

?>
<html>
<head>
	<meta charset="utf-8">
</head>
<body>
	<h1>All users</h1>
	<div>
		<form action="" method="POST">
			Nom commençant par la lettre: <input type="text" name="lettre">
			<br>Avec statut:
			<select name="statut">
				<option value="1">Waiting for account validation</option>
				<option value="2">Active account</option>
				<option value="3">Waiting for account deletion</option>
			</select>
			<br><br><input type="submit" name="submit" value="Valider">
		</form>
	</div>
	<table>
		<tr>
			<th>Id</th>
			<th>Username</th>
			<th>Email</th>
			<th>Status</th>
		</tr>
		<?php
		if (isset($get)) {
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
		}
		?>
	</table>
</body>
</html>