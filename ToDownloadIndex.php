<?php
/**
 * Class managing todl.txt (file which match zipped file to a uniqid
 * @author Shikiryu
 */
class ToDownloadIndex{
	const FILE = 'todl.txt';
	private $_content = '';
	private $_lines = array();
	
	public function __construct(){
		$this->_content = file_get_contents(dirname(__FILE__).'/'.self::FILE);
		$lines = explode("\n", $this->_content);
		foreach($lines as $line){
			$parts = explode(' => ', $line);
			if(count($parts) == 2) $this->_lines[$parts[0]] = $parts[1];
		}
	}
	
	public function saveNewLine($url, $shortcut = ''){
		if(empty($shortcut)) $shortcut = $this->_generateUID();
		$this->_lines[$shortcut] = $url;
		$this->_rebuildFile();
		return $shortcut;
	}
	
	public function readLine($shortcut){
		return array_key_exists($shortcut, $this->_lines) ? $this->_lines[$shortcut] : '';
	}
	
	public function deleteLine($shortcut){
		if(array_key_exists($shortcut, $this->_lines)){
			unset($this->_lines[$shortcut]);
		}
		$this->_rebuildFile();
	}	
	
	private function _rebuildFile(){
		$stringBuffer = '';
		foreach($this->_lines as $shortcut => $url){
			$stringBuffer .= $shortcut.' => '.$url."\n";
		}
		$this->_content = $stringBuffer;
		file_put_contents(dirname(__FILE__).'/'.self::FILE, $stringBuffer);
	}
	
	private function _generateUID(){
		return uniqid();
	}
}