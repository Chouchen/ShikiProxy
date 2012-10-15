<?php
/**
 * Class to dispatch the zipped file with the given method
 * @author Shikiryu
 */
class FileToZipDispatcher{
	private $_method = array();
	private $_zip;
	
	public function __construct(array $method, FileToZip $zip){
		$this->_method = $method;
		$this->_zip = $zip;
	}
	
	public function dispatch($options){
		foreach($this->_method as $method){
			if(method_exists($this, '_'.$method)) { 
				return call_user_func(array($this, '_'.$method), $options); 
			}else{ 
				throw new Exception(sprintf('The required method "%s" does not exist for %s', $method, get_class($this))); 
			} 
		}
		if(!in_array('toDownloadLater', $this->_method)){
			unlink($this->_zip->getFinalFileName());
		}
	}
	
	private function _toDownloadNow($options){
		header("Content-type: application/zip");
		header("Content-Disposition: attachment; filename=".$this->_zip->getFinalFileName());
		header("Pragma: no-cache");
		header("Expires: 0");
		readfile($this->_zip->getFinalFileName());
	}
	
	private function _toDownloadLater($options){
		$index = new ToDownloadIndex();
		$shortcut = $index->saveNewLine($this->_zip->getFinalFileName());
		$email = new FileToZipEmail($options['email'], $shortcut);
		$email->send();
	}	
}