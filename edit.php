<?php
	session_start();
?>
<!doctype html>
<html lang="se">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">  
	<title>Soloäventyr - Redigera</title>
</head>
<body>
<nav id="navbar">
	<a href="index.php">Hem</a>
	<a href="play.php">Spela</a>
	<a class="active" href="edit.php">Redigera</a>
</nav>	
<main class="content">
	<section>
		<h1>Redigera</h1>

		<table class="editTable">
			<tr>
				<th>ID</th>
				<th>Text</th> 
				<th>Place</th>
				<th></th>
			</tr>
<?php
	include_once 'include/dbinfo.php';
	$dbh = new PDO('mysql:host=localhost;dbname=te16;charset=utf8mb4', $dbuser, $dbpass);

	if(isset($_GET['delete'])) {

		$filteredId = filter_input(INPUT_GET, "delete", FILTER_VALIDATE_INT);
		$stmt = $dbh->prepare("DELETE FROM story WHERE id = :id");
		$stmt->bindParam(':id', $filteredId);
		$stmt->execute();

		echo "deleted id: " . $filteredId;
	}

	$stmt = $dbh->prepare("SELECT * FROM story");
	$stmt->execute();

	$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

	foreach ($row as $value) {
		echo "<tr>";
		echo "<td>" . $value['id'] . "</td>";
		echo "<td>" . substr($value['text'], 0, 40) . "...</td>"; // substr pajjar teckenkodning?
		echo "<td>" . $value['place'] . "</td>";
		echo "<td><a href=\"edit.php?edit=" . $value['id'] . "\"><i class=\"material-icons m-center\">edit</i></a>";
		echo "<a href=\"edit.php?delete=" . $value['id'] . "\"><i class=\"material-icons m-center\">delete_forever</i></a></td>";
		echo "</tr>";
	}
?>
		</table>	
	</section>
	<section class="forms">
<?php
	echo "<form action=\"edit.php\" method=\"post\">";
	echo "<label for=\"text\">Story</label>";
	echo "<textarea name=\"text\" id=\"text\" rows=\"5\" cols=\"50\">";
	if(isset($_GET['edit'])) {

		$filteredId = filter_input(INPUT_GET, "edit", FILTER_VALIDATE_INT);
		$stmt = $dbh->prepare("SELECT * FROM story WHERE id = :id");
		$stmt->bindParam(':id', $filteredId);
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		echo $row['text'];
	}
	echo "</textarea>";
	echo "<label for=\"place\">Place</label>";
	if(isset($_GET['edit'])) {
		echo "<input type=\"text\" name=\"place\" id=\"place\" value=\"" . $row['place'] . "\">";	
		echo "<input type=\"hidden\" name=\"id\" id=\"id\" value=\"" . $row['id'] . "\">";	
		echo "<input type=\"submit\" name=\"update\" id=\"update\" value=\"Uppdatera\">";		
	}
	else {
		echo "<input type=\"text\" name=\"place\" id=\"place\">";
		echo "<input type=\"submit\" name=\"add\" id=\"add\" value=\"Lägg till\">";
	}
	echo "</form>";
	echo "</section>";

	if(isset($_POST['add'])) {

		$filteredText = filter_input(INPUT_POST, "text", FILTER_SANITIZE_SPECIAL_CHARS);
		$filteredPlace = filter_input(INPUT_POST, "place", FILTER_SANITIZE_SPECIAL_CHARS);

		$stmt = $dbh->prepare("INSERT INTO story (text, place) VALUES (:text, :place)");
		$stmt->bindParam(':text', $filteredText);
		$stmt->bindParam(':place', $filteredPlace);
		$stmt->execute();

		header('location: edit.php');

	}
	elseif(isset($_POST['update'])) {

		$filteredText= filter_input(INPUT_POST, "text", FILTER_SANITIZE_SPECIAL_CHARS);
		$filteredPlace = filter_input(INPUT_POST, "place", FILTER_SANITIZE_SPECIAL_CHARS);
		$filteredId = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);
		$stmt = $dbh->prepare("UPDATE story SET text = :text, place = :place WHERE id = :id");
		$stmt->bindParam(':text', $filteredText);
		$stmt->bindParam(':place', $filteredPlace);
		$stmt->bindParam(':id', $filteredId);
		$stmt->execute();

		header('location: edit.php');
	}
?>
	<section>

<?php
	
	if(isset($_GET['edit'])) {
		$filteredId = filter_input(INPUT_GET, "edit", FILTER_VALIDATE_INT);

		$stmt = $dbh->prepare("SELECT * FROM storylinks WHERE storyid = :id");
		$stmt->bindParam(':id', $filteredId);
		$stmt->execute();

		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

		foreach ($row as $value) {
			echo "<pre>" . print_r($value,1) . "</pre>";
		}
	}
?>


	</section>
</main>
<script src="js/navbar.js"></script>
</body>
</html>