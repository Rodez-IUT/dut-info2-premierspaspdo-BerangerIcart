<!--
  ~ yasmf - Yet Another Simple MVC Framework (For PHP)
  ~     Copyright (C) 2019   Franck SILVESTRE
  ~
  ~     This program is free software: you can redistribute it and/or modify
  ~     it under the terms of the GNU Affero General Public License as published
  ~     by the Free Software Foundation, either version 3 of the License, or
  ~     (at your option) any later version.
  ~
  ~     This program is distributed in the hope that it will be useful,
  ~     but WITHOUT ANY WARRANTY; without even the implied warranty of
  ~     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  ~     GNU Affero General Public License for more details.
  ~
  ~     You should have received a copy of the GNU Affero General Public License
  ~     along with this program.  If not, see <https://www.gnu.org/licenses/>.
  -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All users</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
<?php
spl_autoload_extensions(".php");
spl_autoload_register();

use yasmf\HttpHelper;
?>
<h1>All Users</h1>

<form action="hello_world.php" method="get">
    <input hidden name="action" value="defaultAction">
	<input hidden name="controller" value="Users">
    Start with letter:
    <input name="start_letter" type="text" value="<?php echo isset($_GET["start_letter"]) ? $_GET["start_letter"] : ""; ?>">
    and status is:
    <select name="status_id">
        <option value="1" <?php if (isset($_GET["status_id"]) AND $_GET['status_id'] == 1) echo 'selected' ?>>Waiting for account validation</option>
        <option value="2" <?php if (isset($_GET["status_id"]) AND $_GET['status_id'] == 2) echo 'selected' ?>>Active account</option>
    </select>
    <input type="submit" value="OK">
</form>

<table>
    <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Email</th>
        <th>Status</th>
        <th></th>
    </tr>
    <?php if (isset($searchStmt)) {
		while ($row = $searchStmt->fetch()) { ?>
			<tr>
				<td><?php echo $row['user_id'] ?></td>
				<td><?php echo $row['username'] ?></td>
				<td><?php echo $row['email'] ?></td>
				<td><?php echo $row['status'] ?></td>
				<td>
					<?php if ($row['status_id'] != 3) { ?>
						<a href="user.php?&user_id=<?php echo $row['user_id']?>&action=editUser">Edit</a>
					<?php } ?>
				</td>
			</tr>
    <?php }
	}	?>
</table>


</body>
</html>