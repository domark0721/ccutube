<?php
// get file and extension
$file = $_FILES['file'];
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);

// give the id
$id = date("U");
$newFileName = $id. "." . $extension;
$targetDir = "../uploads/video/";
$targetFile = $targetDir . $newFileName;

// move temp file to video folder
if ( move_uploaded_file($file["tmp_name"], $targetFile) ) {
	// screenshot
	$screenshotPath = "../uploads/screenshot/" . $id . ".jpg";
	shell_exec("../ffmpeg/ffmpeg -i $targetFile -deinterlace -an -ss 1 -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $screenshotPath 2>&1");

        echo $id;
} else {
        echo "error";
}

?>