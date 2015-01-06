	var holder = document.getElementById('uploadVideoArea');
	console.log(holder);
	holder.ondragover = function() {
		$("#uploadVideoArea").addClass("dragIn");
		return false;
	};
	holder.ondragend = function() {
		$("#uploadVideoArea").removeClass("dragIn");
		return false;
	};

	holder.ondrop = function (e) {
		e.stopPropagation();
		e.preventDefault();
		$("#uploadVideoArea").removeClass("dragIn");

		var file = e.dataTransfer.files[0];
		var fileName = file.name;
		$("#uploadVideoName").html(fileName); 
		console.log(e.dataTransfer.files);
		uploadFile(file);
	};

function uploadFile(file){
	//overwrite file name
	file.name = Date.now();
	console.log(file);
	progress = $("#uploadVideoProgress");
	// now post a new XHR request
	var formData = new FormData();
	
	formData.append('file',file);

	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'api/uploadFile.php');
	xhr.onload = function() {
		progress.html("100%");
	};
	xhr.upload.onprogress = function (event) {
		if (event.lengthComputable) {
			var complete = (event.loaded / event.total * 100 | 0);
			progress.html(complete+"%");
		}
	};
	xhr.onreadystatechange = function(event) {
		if ( 4 == this.readyState ) {
			responseText = event.currentTarget.responseText;
			$("#videoId").val(responseText);
			$("#videoIdShow").val(responseText);
		}
	};
	xhr.send(formData);
}