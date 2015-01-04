$(document).ready( function(){
	//first time enter this page (load default category)
	getCategoryVideo("animals");

	$("#categoryNav a").click(function(e){
		e.preventDefault();
		var selectedCategory = $(this).attr("cate");
		getCategoryVideo(selectedCategory);

		$("#categoryNav a.active").removeClass("active");
		$(this).addClass("active");
	});
	
	function getCategoryVideo(category){
		$.ajax({
		  url: "api/getCategory.php?category="+category,
		  type: "GET",
		  dataType: "json",
		})
		.success(function( jdata ) {
		    videolistHtml = "";
		    //render video lists
		    for(var i in jdata.hits) {
		    	var video = jdata.hits[i];
		    	console.log(video);
		    	var videoHtml ="";
		    	videoHtml +=  "<li class=\"videoItem\" ><div class=\"videoCard\"><div class=\"video-img\" ><img src=\"http://img.youtube.com/vi/"+video._source.id+"/mqdefault.jpg\"></div>";
		    	videoHtml += "<div class=\"video-info\"><a href=\"video.php?vid="+video._id+"\">"+video._source.title+"</a><span class=\"video-info-author\">by "+video._source.author+"</span>";
		      	videoHtml += "<span><i class=\"fa fa-eye\"> "+video._source.viewCount+"</i><i class=\"fa fa-clock-o\"> "+video._source.duration+"</i><i class=\"fa fa-cloud-upload\"> "+video._source.published+"</i></span>";
		     	videoHtml += "<p class=\"video-content\">"+"put content here"+"</p></div></div></li>";
		    	
		    	videolistHtml += videoHtml;
		    }

		    $("#videolist").html(videolistHtml);
		})
		.error(function(){
		    alert("ajax error");
		});	
	}
});