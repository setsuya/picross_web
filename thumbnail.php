<?php
	$file = $_GET["p"];
	$size = $_GET["s"];

	$file_contents = file("stages/" . $size . "/" . $file . ".picross", FILE_IGNORE_NEW_LINES);

	$picross = str_split(substr($file_contents[3], 1));

	$thumb = imagecreate($size, $size);

	$black = imagecolorallocate($thumb, 0, 0, 0);
	$white = imagecolorallocate($thumb, 255, 255, 255);

	for($i = 0; $i < $size; $i++){
		for($j = 0; $j < $size; $j++){
			if($picross[($size * $j) + $i] == "1"){
				imagesetpixel($thumb, $i, $j, $black);
			}else{
				imagesetpixel($thumb, $i, $j, $white);
			}
		}
	}

	$final = imagecreate(60, 60);

	imagecopyresized($final, $thumb, 0, 0, 0, 0, 60, 60, $size, $size);

	header("Content-Type: image/png");

	imagepng($final);

	imagedestroy($thumb);
	imagedestroy($final);
?>