<?php
class APP_Model_Tag extends APP_Model_Application  {

	protected $_name = 'tag';
	protected $_primary = 'id';
	
	function __construct() {
		parent::__construct($this->_name, $this->_primary);
	}
	
	
	function getTagIDFromTitle($p_sTagTitle) {
		$aTag = $this->getList('title = ' . $this->quote($p_sTagTitle))->fetch();
		return empty($aTag) ? 0 : $aTag['id'];
	}
	
}