<?php
class APP_Model_Answer extends APP_Model_Application  {

	protected $_name = 'answer';
	protected $_primary = 'id';
	
	function __construct() {
		parent::__construct($this->_name, $this->_primary);
	}
	
	function getTopQuestions($p_iLimit = 0) {
		
	}


}