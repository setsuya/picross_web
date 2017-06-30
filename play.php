<?php
	$filename = "stages/" . $_GET["size"] . "/" . $_GET["picross"] . ".picross";

	  //////////////////////////////////////////
	 // Looks for the selected picross file. //
	//////////////////////////////////////////
	if(file_exists($filename)){
		$info = file($filename);
	}else{
		$info = file("stages/null.picross");
	}

	  /////////////////////////////////////////
	 // Fetches picross data from the file. //
	/////////////////////////////////////////
	$nome    = substr($info[0], 1, strlen($info[0]) - 2);
	$criador = substr($info[1], 1, strlen($info[1]) - 2);
	$tamanho = substr($info[2], 1, strlen($info[2]) - 2);
	$picross = substr($info[3], 1, strlen($info[3]) - 2);

	     /////////////////////////////////////////////////////////////////////
	    // Creates hints for every line/column from the passed parameters. //
	   // ~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~.~ //
	  // $pos  : defines which line or column should be created;         //
	 //  $axis : defines if it is going to be a line(X) or a column(Y). //
	/////////////////////////////////////////////////////////////////////
	function generate_hints($pos, $axis){
		global $picross, $tamanho;

		$hints_x = "";
		$soma_x = 0;

		$hints_y = "";
		$soma_y = 0;

		  /////////////////////////////////////
		 // Creates the hints for the line. //
		/////////////////////////////////////
		for($i = ($pos * $tamanho); $i < (($pos * $tamanho) + $tamanho); $i++){
			if($picross{$i} == "1"){
				$soma_x += 1;
			}else{
				if($soma_x != 0){
					$hints_x .= $soma_x . " ";
					$soma_x = 0;
				}
			}
		}

		  ///////////////////////////////////////
		 // Creates the hints for the column. //
		///////////////////////////////////////
		for($j = $pos; $j <= (($tamanho * $tamanho) - ($tamanho - $pos)); $j += $tamanho){
			if($picross{$j} == "1"){
				$soma_y += 1;
			}else{
				if($soma_y != 0){
					$hints_y .= $soma_y . " ";
					$soma_y = 0;
				}
			}
		}

		if($soma_x != 0){
			$hints_x .= $soma_x;
		}

		if($soma_y != 0){
			$hints_y .= $soma_y;
		}

		if($hints_x == ""){
			$hints_x = "0";
		}

		if($hints_y == ""){
			$hints_y = "0";
		}

		if($axis == "x"){
			$final_hints_x = "";
			$numeros = explode(" ", $hints_x);

			if($numeros{count($numeros) - 1} == ""){
				array_pop($numeros);
			}

			for($c = 0; $c < count($numeros); $c++){
				$final_hints_x .= "[" . $numeros{$c} . "] ";
			}

			return $final_hints_x;
		}else{
			$final_hints_y = "";
			$numeros = explode(" ", $hints_y);

			if($numeros{count($numeros) - 1} == ""){
				array_pop($numeros);
			}

			for($c = 0; $c < count($numeros); $c++){
				$final_hints_y .= "[" . $numeros{$c} . "]<br />";
			}

			return $final_hints_y;
		}
	}

	  //////////////////////////////////////////////////////////////
	 // Creates the final table with the picross anad the hints. //
	//////////////////////////////////////////////////////////////
	$picross_table = "<table id=\"picross\"><tr><td></td>";

	for($i = 0; $i < (int)$tamanho; $i++){
		$picross_table .= "<td class=\"hint_y\">" . generate_hints($i, "y") . "</td>";
	}

	$picross_table .= "</tr>";

	for($i = 0; $i < (int)$tamanho; $i++){
		$picross_table .= "<tr><td class=\"hint_x\">" . generate_hints($i, "x") . "</td>";

		for($j = ($i * $tamanho); $j < (($i * $tamanho) + $tamanho); $j++){
			$picross_table .= "<td id=\"" . $j . "\"class=\"white\"></td>";
		}

		$picross_table .= "</tr>";
	}

	$picross_table .= "</table>";

	  ////////////////////////////////////////////////////
	 // JSON encodes the data and returns the request. //
	////////////////////////////////////////////////////
	$array_info = json_encode(array(
		"nome"          => $nome,
		"criador"       => $criador,
		"picross_array" => str_split($picross),
		"picross_table" => $picross_table,
		"qtd_marcados"  => array_sum(str_split($picross))
	));

	echo $array_info;
?>