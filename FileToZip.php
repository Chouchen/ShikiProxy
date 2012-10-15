<?php
/**
 * Class for the downloaded and zipped file 
 * @author Shikiryu
 */
class FileToZip{
	private $_fileName 		= ''; // original file name
	private $_finalFileName = ''; // zipped file name
	private $_filePath 		= ''; // original URL
	private $_fileContent	= null; // content of the original file
	private $_zipFile		= null; // ZipArchive file
	
	public function __construct($path){
		$this->_filePath 		= $path;
		$this->_fileName 		= end(explode('/',$this->_filePath));
		$this->_finalFileName 	= $this->_fileName.'.zip';
		
		// create a new CURL resource 
		$ch = curl_init(); 
		
		// set URL and other appropriate options 
		curl_setopt($ch, CURLOPT_URL, $this->_filePath); //set an url
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //do not output directly, use variable
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1); //do a binary transfer
		curl_setopt($ch, CURLOPT_FAILONERROR, 1); //stop if an error occurred
		
		$this->_fileContent = curl_exec($ch); //store the content in variable
		// close CURL resource, and free up system resources 
		curl_close($ch); 
	}

	/**
	 * Create a zip with the original file in it
	 * @return null or $this
	 */
	public function build(){
		$this->_zipFile = new ZipArchive;
		$res = $this->_zipFile->open($this->_finalFileName, ZipArchive::CREATE);
		if ($res === TRUE) {
			$this->_zipFile->addFromString($this->_fileName, $this->_fileContent);
			$this->_zipFile->close();
			return $this;
		} else {
			return null;
		}
	}
	
	/**
	 * just a getter
	 */
	public function getFinalFileName(){
		return $this->_finalFileName;
	}
}