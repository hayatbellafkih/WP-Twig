<?php 

class TWP_Exception extends Exception
{
	public function __construct($message, $code = 0)
	{
		parent::__construct($message, $code);
	}

	public function __toString()
	{
		return "message";
	}
	public function display()
	{
		//include dirname(dirname(__FILE__))."/log/error-page.php";
	}
}
?>