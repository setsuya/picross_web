<?php
	$file_contents = urldecode($_GET["picross"]);
	$size = $_GET["size"];

	$filename = "stages/" . $size . "/p_" . time() . ".picross";
	$file = fopen($filename, "w");
	fwrite($file, $file_contents . "\n");
	fclose($file);

	echo "File saved as " . $filename . "!";
?>
