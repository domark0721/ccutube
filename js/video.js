$(document).ready(function(){
	videoTitle =$(".title").html();
	getVid = $("#likeBtn").attr("vid");

	getRelatedVideos(videoTitle);
	incViewCount(getVid);

	$("#likeBtn").click(function(e){
		$(".loading").show();
		setLike(getVid);
	});
	$("#laterBtn").click(function(e){
		$(".loading").show();
		setLater(getVid);
	});

	function checkLiked(vid){
		$.ajax({
			url: "api/checkLiked.php?vid=" + vid,
			type: "GET",
			dataType: "json",
		})
		//
		.success(function(jdata){
			if(jdata.result=="ok"){
				totalLike = jdata.totalLike; 
				$("#likeCount").html(totalLike);
				$(".loading").hide();
			}
			console.log(jdata);
		})
		.error(function(){
		    alert("ajax error");
		});		
	}	
	function setLike(vid){
		$.ajax({
			url: "api/setLike.php?vid=" + vid,
			type: "GET",
			dataType: "json",
		})
		//
		.success(function(jdata){
			if(jdata.result=="ok"){
				totalLike = jdata.totalLike;
				var likeBtnYes = "<div  class=\"video-button-yes\" id=\"likeBtnYes\" ><span id=\"likeCount\"><?php echo $videoLikesNum ?></span> Like</div>";
				$("#likeBtnCheck").hide().html(likeBtnYes).fadeIn(800);
				$("#likeCount").html(totalLike);
				$(".loading").hide();
			}
			console.log(jdata);
		})
		.error(function(){
		    alert("ajax error");
		});		
	}

	function setLater(vid){
		$.ajax({
			url: "api/setLater.php?vid=" + vid,
			type: "GET",
			dataType: "json",
		})
		.success(function(jdata){
			if(jdata.result=="ok"){
				var added ="已加入";
				var LaterBtnYes = "<div class=\"video-button-yes\" id=\"laterBtn\" ><span id=\"laterWatch\">已加入</span></div>";
				$("#laterBtnCheck").hide().html(LaterBtnYes).fadeIn(800);
				$("#laterWatch").html(added);
				$(".loading").hide();
			}
		})
		.error(function(){
		    alert("ajax error");
		});		
	}

	function getRelatedVideos(videoTitle){
		$.ajax({
			url: "api/relatedVideo.php",
			data:  {title: videoTitle},	
			type: "POST",
			dataType: "json",
		})
		.success(function(jdata){
			relatedlistHtml = "";
			//render video lists
			for(var i in jdata.video) {
				var video = jdata.video[i];
				console.log(videoTitle);
				if(video.title.localeCompare(videoTitle)){
					//console.log(video);
					var videoHtml ="";
					videoHtml += "<li class=\"relatedItem\"><a href=\"video.php?vid="+video._id.$id+"\" title=\""+video.title+"\"><div class=\"relatedPic\"><img src=\"http://img.youtube.com/vi/"+video.id+"/mqdefault.jpg\"></div>";
					videoHtml += "<div class=\"relatedContent\"><div class=\"relatedTitle\">"+video.title.substring(0,50)+"</div>";
					videoHtml += "<div class=\"relatedAuthor\">by "+video.author+"</div>";
					videoHtml += "<div class=\"relatedViewcount\"><i class=\"fa fa-eye\"> "+video.viewCount+"</i></div></div></a></li>";
					
					relatedlistHtml += videoHtml;					
				}
			}
			$("#relativeList").hide().html(relatedlistHtml).fadeIn("slow");
		})
		.error(function(){
		    alert("ajax error");
		});		
	}

	function incViewCount(vid){
		$.ajax({
			url: "api/incViewCount.php?vid="+vid,
			type: "GET",
			dataType: "json",
		})
	}

});