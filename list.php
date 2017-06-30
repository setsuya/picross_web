<?php
	switch($_GET["type"]){
		case "size_all":
			$total = one_size("5") . one_size("10") . one_size("15") . one_size("20");
			echo $total;
			break;
		case "size_5":
			one_size("5");
			break;
		case "size_10":
			one_size("10");
			break;
		case "size_15":
			one_size("15");
			break;
		case "size_20":
			one_size("20");
			break;
	}

	function one_size($size){
		if($dir = opendir("stages/" . $size . "/")){
			$list_picross = "";

			$file = scandir("stages/" . $size . "/");

			for($i = 0; $i < count($file); $i++){
				if(($file[$i] != ".") && ($file[$i] != "..")){
					$list_picross .= "<div class=\"picross_box\"><form method=\"POST\" action=\"play_game.php\"><input type=\"hidden\" name=\"size\" value=\"" . $size . "\" /><input type=\"hidden\" name=\"title\" value=\"" . substr($file[$i], 0, strpos($file[$i], ".")) . "\" />" . search_cookie(substr($file[$i], 0, strpos($file[$i], ".")), $size) . "</form></div>";
				}
			}
		}else{
			$list_picross = "Oops... ):";
		}

		echo $list_picross;
	}

	function search_cookie($name, $size){
		return "<img src=\"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADwAAAA8CAQAAACQ9RH5AAAANUlEQVR42u3NAQ0AAAgDoL9/aI3h3KAAzeRExWKxWCwWi8VisVgsFovFYrFYLBaLxWLxp3gBzXQ8ATE/JBsAAAAASUVORK5CYII=\" /><p class=\"size_tag\">" . $size . "&times;" . $size . "</p><div class=\"game_info\"><div class=\"text\">Time:</div><div class=\"value\">--:--</div></div><div class=\"game_info\"><div class=\"text\">Mistakes:</div><div class=\"value\">-</div></div>";
	}
?>