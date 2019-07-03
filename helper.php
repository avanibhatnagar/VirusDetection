<?php
function alert($msg){
	echo '<script type = "text/javascript">alert("'.$msg.'");</script>';
}
function extractFileSignature($file){
	$extInfo = pathinfo($file);
	if(!file_exists($file)){
		alert("Please upload a file to be scanned! There is no file right now.");
	} else {
		$fileOpen = fopen($file, "rb");
		$size = filesize($file);
		$contents = fread($fileOpen, $size);
		fclose($fileOpen);
		bit = "";
		if($size >= 20){
			for($i = 0; $i < 20; $i++){
				$char = $contents[$i];
				$baseTen = ord($char);
				$bin = base_convert($baseTen, 10, 2);
				$hex = base_convert($bin, 2, 16);
				bit .= $hex;
			}
			return bit;
		} else {
			for($i = 0; $i < $size; $i++){
				$char = $contents[$i];
				$baseTen = ord($char);
				$bin = base_convert($baseTen, 10, 2);
				$hex = base_convert($bin, 2, 16);
				bit .= $hex;
			}
			return bit;
		}
	}
}
function extractTestFileSignature($file){
	$extInfo = pathinfo($file);
	if(!file_exists($file)){
		alert("Please upload a file to be scanned! There is no file right now.");
	} else {
		$fileOpen = fopen($file, "rb");
		$size = filesize($file);
		$contents = fread($fileOpen, $size);
		fclose($fileOpen);
		bit = "";
		for($i = 0; $i < $size; $i++){
			$char = $contents[$i];
			$baseTen = ord($char);
			$bin = base_convert($baseTen, 10, 2);
			$hex = base_convert($bin, 2, 16);
			bit .= $hex;
		}
		return bit;
	}
}
?>
