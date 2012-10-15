<?php
/**
We need to find the matching file thanks to the todl.txt file
Read it, send it then delete it from the txt file
*/
$idx = new ToDownloadIndex();

$shortcut = !empty($_GET['sc']) ? $_GET['sc'] : '';

if($shortcut == ''){
	header('HTTP/1.0 404 Not Found');
	exit;
}

$file = $idx->readLine($shortcut);

if($file == null || !is_readable(dirname(__FILE__).'/'.$file)){
	header('HTTP/1.0 404 Not Found');
	exit;
}

header("Content-type: application/zip");
header("Content-Disposition: attachment; filename=".$file);
header("Pragma: no-cache");
header("Expires: 0");
readfile(dirname(__FILE__).'/'.$file);
unlink(dirname(__FILE__).'/'.$file);

$idx->deleteLine($shortcut);

exit;