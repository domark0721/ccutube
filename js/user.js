$(document).ready(function(){
	generateMyVideo();

	$("#myVideo").click(function(e){
		generateMyVideo();
		$("#categoryNav a.active").removeClass("active");
		$(this).addClass("active");
	});

	$("#myLike").click(function(e){
		generateMyLike();
		$("#categoryNav a.active").removeClass("active");
		$(this).addClass("active");
	});

	$("#myLater").click(function(e){
		generateMyLater();
		$("#categoryNav a.active").removeClass("active");
		$(this).addClass("active");
	});

	$("#upload").click(function(e){
		self.location="upload.php";
		$("#categoryNav a.active").removeClass("active");
		$(this).addClass("active");
	});

	function  generateMyVideo(){
		$.ajax({
			url: "api/getMyVideos.php",
			type: "GET",
			dataType: "json",
		})
		.success(function(jdata){
			var videoList = jdata.video;
			generateVideoList(videoList);
		})
		.error(function(){
			alert("ajax error");
		});
		
	}
	function  generateMyLike(){
		$.ajax({
			url: "api/getLikeVideos.php",
			type: "GET",
			dataType: "json",
		})
		.success(function(jdata){
			var videoList = jdata.video;
			generateVideoList(videoList);
		})
		.error(function(){
			alert("ajax error");
		});
		
	}
	function  generateMyLater(){
		$.ajax({
			url: "api/getLaterVideos.php",
			type: "GET",
			dataType: "json",
		})
		.success(function(jdata){
			var videoList = jdata.video;
			generateVideoList(videoList);
		})
		.error(function(){
			alert("ajax error");
		});
		
	}

	function generateVideoList(videoList) {
		videolistHtml="";
		for(var i in videoList){
			var video = videoList[i];
			console.log(video);
			videoImgPath = (video.isCCUtube) ? "uploads/screenshot/"+video.id+".jpg" : "http://img.youtube.com/vi/"+video.id+"/mqdefault.jpg";
			var videoHtml="";
			videoHtml +=  "<li class=\"videoItem\" ><div class=\"videoCard\"><div class=\"video-img\" ><img src=\""+videoImgPath+"\"></div>";
		    	videoHtml += "<div class=\"video-info\"><a href=\"video.php?vid="+video._id.$id+"\">"+video.title+"</a><span class=\"video-info-author\">by "+video.author+"</span>";
		      	videoHtml += "<span><i class=\"fa fa-eye\"> "+video.viewCount+"</i><i class=\"fa fa-clock-o\"> "+video.duration+"</i><i class=\"fa fa-cloud-upload\"> "+video.published+"</i></span>";
		     	videoHtml += "<p class=\"video-content\">"+"put content here"+"</p></div></div></li>";

		     	videolistHtml += videoHtml;
		}
		$("#videolist").html(videolistHtml);
	}
});