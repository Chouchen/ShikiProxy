<?php
if(isset($_POST['url']) && isset($_POST['method'])){
	
	$file2zip = new FileToZip(filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL));
	
	$method = filter_has_var(INPUT_POST, 'method') ? is_array($_POST['method']) ? $_POST['method'] : array($_POST['method']) : null;
	
	$fileDispatcher = new FileToZipDispatcher($method, $file2zip->build());
	
	$options = $_REQUEST;
	unset($options['method']);
	unset($options['url']);
	
	$fileDispatcher->dispatch($options);
	
	if(!in_array('toDownloadNow', $method)){
		header('Location: '.BASE_URL);
		exit;
	}
}else{
	header('Location: '.BASE_URL);
}