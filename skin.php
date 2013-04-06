<?php
$username = isset($_GET['user'])? $_GET['user'] : "Notch";
$new = isset($_GET['new']);

if(!(strlen($username) > 2 && strlen($username) < 17 && preg_match("/^[A-Za-z0-9_]+$/", $username))){
    die("Script error 100: Invalid Username");
}

if($new && file_exists("finalskincache/new_$username.png") && !isset($_GET['update'])){
    $finalimage = imagecreatefrompng("finalskincache/new_$username.png");
    header("Content-Type: image/png");
    imagepng($finalimage);
    die();
} else if(!$new && file_exists("finalskincache/$username.png") && !isset($_GET['update'])){
    $finalimage = imagecreatefrompng("finalskincache/$username.png");
    header("Content-Type: image/png");
    imagepng($finalimage);
    die();
} else if(file_exists ("skincache/$username.png") && !isset($_GET['update'])){
    $original_skin = imagecreatefrompng("skincache/$username.png");
} else {
    set_time_limit(5);
    $original_skin = @imagecreatefrompng("http://s3.amazonaws.com/MinecraftSkins/$username.png");
    set_time_limit(25);
    if(!$original_skin) die("Script error 101: Access denied or skin doesn't exist");
    imagepng($original_skin, "skincache/$username.png");
}

$finalimage = imagecreatetruecolor(100, 170);

$ablack = imagecolorallocate($finalimage, 1, 0, 0);
$black = imagecolorallocate($finalimage, 0, 0, 0);
imagefill($finalimage, 0, 0, $ablack);
imagecolortransparent($finalimage, $ablack);


imagefilledrectangle($finalimage, 0, 0, 100, 100, $black);
imagefilledrectangle($finalimage, 10, 100, 90, 140, $black);
imagefilledrectangle($finalimage, 30, 140, 70, 170, $black);
imagecopyresized($finalimage, $original_skin, 10, 10, 8, 8, 80, 80, 8, 8);    	//head

if($new){
	imagecopyresized($finalimage, $original_skin, 20, 100, 40, 20, 10, 30, 4, 12);	//arm 1
	imagecopyresized($finalimage, $original_skin, 70, 100, 40, 20, 10, 30, 4, 12);	//arm 2
	imagecopyresized($finalimage, $original_skin, 40, 100, 20, 20, 20, 30, 8, 12);	//body
	
	imagecopyresized($finalimage, $original_skin, 40, 150, 8, 16, 10, 10, 4, 4);	//foot 1
	imagecopyresized($finalimage, $original_skin, 50, 150, 8, 16, 10, 10, 4, 4);	//foot 2
    imagepng($finalimage, "finalskincache/new_$username.png");
} else {
	imagecopyresized($finalimage, $original_skin, 20, 110, 40, 30, 10, 20, 1, 2);	//arm 1
	imagecopyresized($finalimage, $original_skin, 70, 110, 40, 30, 10, 20, 1, 2);	//arm 2
	imagecopyresized($finalimage, $original_skin, 40, 100, 23, 21, 20, 30, 2, 3);	//body
	
	imagecopyresized($finalimage, $original_skin, 40, 150, 8, 16, 10, 10, 1, 1);	//foot 1
	imagecopyresized($finalimage, $original_skin, 50, 150, 8, 16, 10, 10, 1, 1);	//foot 2
    imagepng($finalimage, "finalskincache/$username.png");
}

header("Content-Type: image/png");

imagepng($finalimage);
imagedestroy($finalimage);
?>
