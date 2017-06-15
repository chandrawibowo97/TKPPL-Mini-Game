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
		$key2 = "";
		for($i = 0; $i < strlen($key); $i++)
		{
			if(ord($key[$i]) > 96 && ord($key[$i]) < 123)
				$key2 .= chr(ord($key[$i]) - 32);
			else
				$key2 .= $key[$i];
		}
		$key2 = "00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A00000000A" . $key2;
		$query = mysqli_query($conn, "UPDATE musiclist SET Keywords = \"" . $key2 . "\" WHERE No = " . $id);
		echo $key2 . "\n";
		echo $id;
		header("Location: ./Music_Tap.php");
		exit();
	?>
	00000460a
</body>
</html>