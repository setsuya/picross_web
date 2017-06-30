<?php
	include("include_top.php");
?>
		<div id="main">
			<div id="left_col">
				<div id="start_div"></div>
				<div id="start">Start!</div>
				<div id="picross_area"></div>
			</div>
			<div id="right_col">
				<p id="countdown">20:00</p>
				<div id="picross_errors">
					<img src="img/x_bg.png" /><img src="img/x_bg.png" /><img src="img/x_bg.png" /><img src="img/x_bg.png" /><img src="img/x_bg.png" />
				</div>
				<p id="back_button"><a href="select.php">&lt;&lt;Back</a></p>
			</div>
		</div>
		<script>makePicross("<?php echo $_POST["size"]; ?>", "<?php echo $_POST["title"]; ?>");</script>
		<input type="hidden" id="picross_name" value="<?php echo $_POST["title"]; ?>" />
<?php
	include("include_bot.php");
?>