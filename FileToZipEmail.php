<?php
/**
 * Class for sending the hashed link into the given email
 * @author Shikiryu
 */
class FileToZipEmail{
	private $_email; // email obviously
	private $_shortcut; // shortcut (uniqid)
	
	public function __construct($email, $zip){
		$this->_email = $email;
		$this->_shortcut = $zip;
		$this->_protection();
	}
	
	/**
	 * Prevent hackingn see php doc
	 */
	private function _protection(){
		$email = trim($this->_email);
		if ((strpos ($email,"\\r")!==false) || 
			(strpos ($email,"\\n")!==false) || 
			(stripos ($email,"Content-Transfer-Encoding")!==false) || 
			(stripos ($email,"MIME-Version")!==false) || 
			(stripos ($email,"Content-Type")!==false) || 
			(empty($_SERVER['HTTP_USER_AGENT']))) 
				die('Incorrect request') ; //stop spammers 
		mail('email', '[SPAMMER] someone is trying to hack you.', "Hello, \n\n".$this->_email." tried to hack you.\n\nBye o/");
	}
	
	/**
	 * obvious
	 */
	public function send(){
		mail($this->_email, 'A new file to download', "Hello, \n\nYou can download a new file here : ".BASE_URL."/".$this->_shortcut."\n\nBye o/");
	}
}
