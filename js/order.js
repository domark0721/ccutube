$(document).ready(function(){
	$("#orderByTitle").click(function(e){
		e.preventDefault();
		selectedCategory = $(this).attr("cate");
		var orderType = $(this).attr("orderBy");
		console.log(selectedCategory);
		orderby(selectedCategory,orderType);

		var orderbyLink ="";
		orderbyLink +="<li>order by</li>";
		orderbyLink +="<li><a id=\"orderByTitle\" style=\"color: red\">Title<a></li>";
		orderbyLink +="<li><a id=\"orderByViewcount\">Viewcount</a></li>";
		$("#howtoDisplay").html(orderbyLink);
	});

	function orderby(category, orderType){
		$.ajax({
		  url: "../api/orderBy.php?category="+category+"&orderType="+orderType,
		  type: "GET",
		  dataType: "json",
		})
		.success(function( jdata ) {
		    videolistHtml = "";
		    //render video lists
		    for(var i in jdata.hits) {
		    	var video = jdata.hits[i];
		    	//console.log(video);
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