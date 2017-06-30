$(document).ready(function(){
	function list_picross(type){
		$.get("list.php?type=" + type, function(data){
			$("#picross_list").html(data);
			$(".picross_box").each(function(){
				if(localStorage.getItem($(this).find("[name='title']").val())){
					recordInfo = JSON.parse(localStorage.getItem($(this).find("[name='title']").val()));

					$(this).find("img:first").attr("src", "thumbnail.php?p=" + $(this).find("[name='title']").val() + "&s=" + $(this).find("[name='size']").val());
					$(this).find(".game_info:first .value").text(recordInfo.best_time);
					$(this).find(".game_info:last .value").text(recordInfo.best_error);
				}
			});
			bindClicks();
		});
	}

	function bindClicks(){
		$(".picross_box").bind("click", function(){
			$(this).find("form").submit();
		});
	}

	list_picross("size_all");

	$(".size_box").click(function(){
		list_picross($(this).attr("id"));
		$(".size_box").removeClass("selected");
		$(this).addClass("selected");
		bindClicks();
		$("body").scrollTop(0);
		$("#size_list").css("padding-top", "20px");
	});

	if($("#size_list").length){
		$(window).scroll(function(){
			scroll_top = $("body").scrollTop();
			list_offset = $("#size_list").offset().top;

			if(scroll_top > list_offset){
				if($("#size_list").innerHeight() < $("#contents").innerHeight()){
					$("#size_list").css("padding-top", (scroll_top - list_offset) + 20);
					//$("#size_list").animate({"padding-top": (scroll_top - list_offset) + 20}, 300, "linear");
				}
			}else{
				if($("#size_list").css("padding-top") != "20px"){
					$("#size_list").css("padding-top", "20px");
				}
			}
		});
	}
});