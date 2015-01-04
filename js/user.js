$(document).ready(function(){

	$("#myLike").click(function(e){
		$("#categoryNav a.active").removeClass("active");
		$(this).addClass("active");
		$.ajax({
			url: "api/getLikeVideos.php",
			type: "GET",
			dataType: "json",
		})
		.success(function(jdata){
			generateVideoHtml(jdata.video);
		})
		.error(function(){
			alert("ajax error");
		});
	});

	$("#myLater").click(function(e){
		$("#categoryNav a.active").removeClass("active");
		$(this).addClass("active");
		$.ajax({
			url: "api/getLaterVideos.php",
			type: "GET",
			dataType: "json",
		})
		.success(function(jdata){
			generateVideoHtml(jdata.video);
		})
		.error(function(){
			alert("ajax error");
		});
	});

	function  generateVideoHtml(videoList){
		videolistHtml="";
		for(var i in videoList){
			var video = videoList[i];
			console.log(video);
			var videoHtml="";
			videoHtml +=  "<li class=\"videoItem\" ><div class=\"videoCard\"><div class=\"video-img\" ><img src=\"http://img.youtube.com/vi/"+video.id+"/mqdefault.jpg\"></div>";
		    	videoHtml += "<div class=\"video-info\"><a href=\"video.php?vid="+video._id.$id+"\">"+video.title+"</a><span class=\"video-info-author\">by "+video.author+"</span>";
		      	videoHtml += "<span><i class=\"fa fa-eye\"> "+video.viewCount+"</i><i class=\"fa fa-clock-o\"> "+video.duration+"</i><i class=\"fa fa-cloud-upload\"> "+video.published+"</i></span>";
		     	videoHtml += "<p class=\"video-content\">"+"put content here"+"</p></div></div></li>";

		     	videolistHtml += videoHtml;
		}
		$("#videolist").html(videolistHtml);		
	}
});