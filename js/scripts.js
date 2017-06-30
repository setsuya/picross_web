var picrossArray = [];
var errors       = 0;
var total        = 0;
var marked       = 0;

var seconds;
var countdownTimer;
var error;

function createModel(){
	size = $("#picross_size").val();
	contents = "";

	for(i = 0; i < size; i++){
		contents += "<tr>";

		for(j = 0; j < size; j++){
			contents += "<td class=\"white\"></td>";
		}

		contents += "</tr>";
	}

	$("#create_picross").html("<table id=\"picross\">" + contents + "</table> <div id=\"create_file\">Save picross</div>");
	bindClicksModel();
}

function bindClicksModel(){
	$("#picross td").bind("click", function(){
		$(this).toggleClass("white black");
	});

	$("#create_file").bind("click", function(){
		picross = "";

		$("#picross td").each(function(){
			if($(this).hasClass("white")){
				picross += "0";
			}else{
				picross += "1";
			}
		});

		picross_file  = "#" + $("#nome").val() + "\n";
		picross_file += "#" + $("#criador").val() + "\n";
		picross_file += "#" + $("#picross_size").val() + "\n";
		picross_file += "#" + picross;

		$.get("save.php?size=" + $("#picross_size").val() + "&picross=" + encodeURIComponent(picross_file), function(data){
			popupMsg(data);
		});
	});
}

function makePicross(size, picross){
	$.get("play.php?size=" + size + "&picross=" + picross, function(data){
		$("#picross_errors").html("<img src=\"img/x_bg.png\" /><img src=\"img/x_bg.png\" /><img src=\"img/x_bg.png\" /><img src=\"img/x_bg.png\" /><img src=\"img/x_bg.png\" />");
		resetAll();
		picrossArray = data.picross_array;
		total = data.qtd_marcados;
		$("#picross_area").html(data.picross_table);
		bindClicks();
		bindHover();
	}, "json");
}

function bindClicks(){
	$("#picross td[id]").bind("click", function(){
		if(errors < 5){
			if(!(($(this).hasClass("black")) || ($(this).hasClass("red")))){
				if($(this).hasClass("mark")){
					$(this).removeClass("mark");
				}else{
					if(picrossArray[$(this).attr("id")] == 1){
						$(this).removeClass("white").addClass("black");
						checkEnd();
					}else{
						$(this).removeClass("white").addClass("red").addClass("mark");
						checkErrors();
					}
				}
				return false;
			}else{
				return false;
			}
		}else{
			resetAll();
			return false;
		}
	});

	$("#picross td[id]").bind("contextmenu", function(){
		if(errors < 5){
			if(!(($(this).hasClass("black")) || ($(this).hasClass("red")))){
				if($(this).hasClass("mark")){
					$(this).removeClass("mark");
				}else{
					$(this).addClass("mark");
				}
				return false;
			}else{
				return false;
			}
		}else{
			resetAll();
			return false;
		}
	});
}

function bindHover(){
	$("#picross td").bind({
		mouseenter: function(){
			pos = $(this).index();

			$(this).parent("tr").find(".hint_x").addClass("hover_td");
			$("#picross .hint_y:eq(" + (pos - 1) + ")").addClass("hover_td");
		},
		mouseleave: function(){
			pos = $(this).index();

			$(this).parent("tr").find(".hint_x").removeClass("hover_td");
			$("#picross .hint_y:eq(" + (pos - 1) + ")").removeClass("hover_td");
		}
	});
}

function checkErrors(){
	seconds = seconds - error;
	if(error < 320){
		error = error * 2;
	}

	errors++;
	$("#picross_errors img:last").remove("img");
	$("#picross_errors").prepend("<img src=\"img/x.png\" />");

	if(errors == 5){
		popupMsg("Game over... =(");
	}
}

function checkEnd(){
	marked++;
	if(marked == total){
		gameErrors = errors;
		gameMinutes = zeroPad(Math.round(((1200 - seconds) - 30) / 60));
		gameSeconds = zeroPad((1200 - seconds) % 60);
		gameTime = gameMinutes + ":" + gameSeconds;

		resetAll();
		clearInterval(countdownTimer);

		popupMsg("Game ended!<br />Time: " + gameMinutes + ":" + gameSeconds + "<br />Mistakes: " + gameErrors);

		if(localStorage.getItem($("#picross_name").val())){
			picrossObj = JSON.parse(localStorage.getItem($("#picross_name").val()));

			if(Date.parse("04/11/1986 00:" + picrossObj.best_time) > Date.parse("04/11/1986 00:" + gameTime)){
				picrossObj.best_time = gameTime;
			}

			if(picrossObj.best_error > gameErrors){
				picrossObj.best_error = gameErrors;
			}
		}else{
			picrossObj = {"best_time": gameTime, "best_error": gameErrors};
		}

		localStorage.setItem($("#picross_name").val(), JSON.stringify(picrossObj));
	}
}

function resetAll(){
	marked   = 0;
	errors   = 0;
	$("#picross td").unbind();
}

function secondsPassed(){
	if(seconds <= 0){
		seconds = 0;
		clearInterval(countdownTimer);
	}else{
		seconds--;
	}

	var minutes = zeroPad(Math.round((seconds - 30) / 60));
	var remainingSeconds = zeroPad(seconds % 60);

	$("#countdown").html(minutes + ":" + remainingSeconds);
}

function zeroPad(n){
	if((n + 0) < 10){
		n = "0" + n;
	}else{
		n = "" + n;
	}

	return n;
}

function getRecords(){
	$("#backup_record").val(LZString.compressToEncodedURIComponent(JSON.stringify(localStorage)));
}

function copyRecords(){
	selection = $("#backup_record").select();
	document.execCommand("copy");
	
	popupMsg("Text copied to the clipboard.");
}

function putRecords(){
	cont = 0;
	backup = JSON.parse(LZString.decompressFromEncodedURIComponent($("#upload_record").val()));

	for(item in backup){
		localStorage.setItem(item, backup[item]);
		cont++;
	}

	popupMsg("Imported " + cont + " records successfully.");
}

function deleteRecords(){
	localStorage.clear();
	popupMsg("Save file deleted!");
}

function popupMsg(msg){
	$("body").append("<div id=\"overlay\"><div id=\"message\"><p>" + msg + "</p><div id=\"close_btn\" onclick=\"closeMsg(this)\">OK</div></div>").fadeIn("medium");
}

function closeMsg(popup){
	$(popup).parents("#overlay").fadeOut("medium", function(){
		$(this).remove();
	});
}

$(document).ready(function(){
	if(Math.floor($("#start").innerWidth()) % 2 == 1){
		$("#start").innerWidth(Math.floor($("#start").innerWidth()) + 1);
	}

	if(Math.floor($("#start").innerHeight()) % 2 == 1){
		$("#start").innerHeight(Math.floor($("#start").innerHeight()) + 1);
	}

	$("#start").click(function(){
		$("#start_div, #start").hide();

		error = 60;
		clearInterval(countdownTimer);
		seconds = 1200;
		countdownTimer = setInterval("secondsPassed()", 1000);
	});
});