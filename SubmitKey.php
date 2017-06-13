<!DOCTYPE html>
<html>
<head>
	<title>Submission</title>
</head>
<body>
	<?php
		$conn = mysqli_connect("localhost", "root", "", "music_tap");
		$id = $_GET["id"];
		$key = $_GET["key"];
		$query = mysqli_query($conn, "UPDATE musiclist SET Keywords = \"" . $key . "\" WHERE No = " . $id);
		echo $key . "\n";
		echo $id;
		header("Location: ./Music_Tap.php");
		exit();
	?>
</body>
</html>