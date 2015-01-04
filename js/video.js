$(document).ready(function(){

	$("#likeBtn").click(function(e){
		var getVid = $(this).attr("vid");
		setLike(getVid);
	});
	$("#laterBtn").click(function(e){
		var getVid = $(this).attr("vid");
		setLater(getVid);
	});

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
				$("#likeCount").html(totalLike);
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
		//
		.success(function(jdata){
			if(jdata.result=="ok"){
				var added ="已加入";
				$("#laterWatch").html(added);				
			}
		})
		.error(function(){
		    alert("ajax error");
		});		
	}	

});