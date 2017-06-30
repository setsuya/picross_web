<?php
	include("include_top.php");
?>
		<div id="main">
			<div id="left_col">
				<p>Name: <input type="text" id="nome" /></p>
				<p>Creator: <input type="text" id="criador" /></p>
				<p>Size: 
					<select id="picross_size">
						<option value="5">5x5</option>
						<option value="10">10x10</option>
						<option value="15">15x15</option>
						<option value="20">20x20</option>
					</select><div id="create" onclick="createModel()">Create model</div>
				</p>
			</div>
			<div id="right_col">
				<div id="create_picross"></div>
			</div>
		</div>
<?php
	include("include_bot.php");
?>