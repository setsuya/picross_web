<?php
	include("include_top.php");
?>
		<div id="backup">
			<p>To make a backup of your progress, copy the text inside the box that says <i>"Current save"</i> and store it in a safe place.</p>
			<p>In case you want to use your save file in another device or it gets erased, insert your backup in the box that says <i>"Upload save"</i> and click <i>"Upload!"</i></p>
			<div id="current_save">Current save: <textarea id="backup_record" readonly></textarea><br /><div id="copy_btn" onclick="copyRecords()">Copy to clipboard</div></div><div id="upload_save">Upload save: <textarea id="upload_record" name="save"></textarea><br /><div id="upload_btn" onclick="putRecords()">Upload!</div></div>
			<div id="delete_save" onclick="deleteRecords()">Delete save</div> <span id="warning">Warning: this cannot be undone!</span>
		</div>
		<script type="text/JavaScript">getRecords();</script>
<?php
	include("include_bot.php");
?>