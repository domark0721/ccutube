$(document).ready( function(){
	//first time enter this page (load default category)
	getCategoryVideo("animals");
	selectedCategory = "animals";

	$("#categoryNav a").click(function(e){
		$("#videolist").html('<span class="relatedLoader"><img  src="img/loaderBig.gif"></span>');
		e.preventDefault();
		selectedCategory = $(this).attr("cate");
		getCategoryVideo(selectedCategory);

		$("#categoryNav a.active").removeClass("active");
		$(this).addClass("active");
		//hover effect
		$("#orderByDuration").removeClass("orderActive");
		$("#orderByViewcount").removeClass("orderActive");
		$("#orderByDuration").addClass("clicked");
		$("#orderByViewcount").addClass("clicked");		
	});

	$("#orderByDuration").click(function(e){
		//hover effect
		$(this).addClass("orderActive");
		$("#orderByViewcount").addClass("clicked");
		$(this).removeClass("clicked");
		$("#orderByViewcount").removeClass("orderActive");
		
		if($(this).hasClass("orderActive")){
			console.log("hi");
			$(".loading").show();
			orderby(selectedCategory, "duration");
		}
	});	

	$("#orderByViewcount").click(function(e){
		//hover effect
		$(this).addClass("orderActive");
		$("#orderByDuration").addClass("clicked");
		$(this).removeClass("clicked");
		$("#orderByDuration").removeClass("orderActive");

		if($(this).hasClass("orderActive")){
			console.log("ve");
			$(".loading").show();
			orderby(selectedCategory, "viewCount");
		}
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
		    	//console.log(video);
		    	var videoHtml ="";
		    	videoHtml +=  "<li class=\"videoItem\" ><div class=\"videoCard\"><div class=\"video-img\" ><img src=\"http://img.youtube.com/vi/"+video._source.id+"/mqdefault.jpg\"></div>";
		    	videoHtml += "<div class=\"video-info\"><a href=\"video.php?vid="+video._id+"\">"+video._source.title.substring(0,40)+"</a><span class=\"video-info-author\">by "+video._source.author+"</span>";
		      	videoHtml += "<span><i class=\"fa fa-eye\"> "+video._source.viewCount+"</i><i class=\"fa fa-clock-o\"> "+video._source.duration+"</i><i class=\"fa fa-cloud-upload\"> "+video._source.published+"</i></span>";
		     	videoHtml += "<p class=\"video-content\">"+ video._source.content.substring(0,50)+"</p></div></div></li>";
		    	
		    	videolistHtml += videoHtml;
		    }
			// var orderbyLink ="";
			// orderbyLink +="<li>order by</li>";
			// orderbyLink +="<li><a id=\"orderByTitle\" href=\"#\" cate=\""+ category +"\" orderBy=\"title\">Title<a></li>";
			// orderbyLink +="<li><a id=\"orderByViewcount\" href=\"#\" cate=\""+ category +"\" orderBy=\"viewcount\">Viewcount</a></li>";
			$("#videolist").html(videolistHtml);
		    //$("#howtoDisplay").html(orderbyLink);

		})
		.error(function(){
		    alert("ajax error");
		});	
	}

	function orderby(category, orderCol){
		$.ajax({
		  url: "api/orderBy.php?category="+category+"&orderCol="+orderCol,
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
			$(".loading").hide();
		})
		.error(function(){
		    alert("ajax error");
		});	
	}
});