<?php
class APP_Model_Question_Tag extends APP_Model_Application  {

	protected $_name = 'question_tag';
	protected $_primary = 'id';
	
	function __construct() {
		parent::__construct($this->_name, $this->_primary);
	}
	
	function getQuestionTags($p_iQuestionID) {
		return $this->select()
			->columns('qt.*, t.title')
			->from($this->_name .' qt')
			->leftJoin('tag t', 'qt.tag_id = t.id')
			->where('question_id = ' . $this->quote($p_iQuestionID))
			->getList();
	}
	
}