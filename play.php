<?php
	session_start();
?>
<!doctype html>
<html lang="se">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">  
	<title>Soloäventyr - Spela</title>
</head>
<body>
<nav id="navbar">
	<a href="index.php">Hem</a>
	<a class="active" href="play.php">Spela</a>
	<a href="edit.php">Redigera</a>
</nav>	
<main class="content">
	<section>
		<h1>Spela</h1>
		<p>För att starta äventyret, klicka <a href="play?page=1" title="Starta spelet">här</a></p>
<?php
	include_once 'include/dbinfo.php';

	// PDO
	$dbh = new PDO('mysql:host=localhost;dbname=te16;charset=utf8mb4', $dbuser, $dbpass);

	if (isset($_GET['page'])) {
		// TODO load requested page from DB using GET
		$filteredPage = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);

		$stmt = $dbh->prepare("SELECT * FROM story WHERE id = :id");
		$stmt->bindParam(':id', $filteredPage);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		echo "<pre>" . print_r($row,1) . "</pre>";

		// echo "<p>" . $row['text'] . "</p>";

		$stmt = $dbh->prepare("SELECT * FROM storylinks WHERE storyid = :id");
		$stmt->bindParam(':id', $filteredPage);
		$stmt->execute();

		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);		

		echo "<pre>" . print_r($row,1) . "</pre>";

		foreach ($row as $val) {
			echo "<a href=\"?page=" . $val['target'] . "\">" . $val['text'] . "</a>";
		}

	} elseif(isset($_SESSION['page'])) {
		// TODO load page from db
		// use for returning player / cookie
	} else {
		// TODO load start of story from DB
	}

?>
</main>
<script src="js/navbar.js"></script>
</body>
</html>