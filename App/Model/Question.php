<?php
class APP_Model_Question extends APP_Model_Application  {

	protected $_name = 'question';
	protected $_primary = 'id';
	
	function __construct() {
		parent::__construct($this->_name, $this->_primary);
	}
	
	function getTopQuestions($p_iLimit = 0) {
		$rows    = $this->getList('', 'created_date DESC', $p_iLimit !== 0 ? $p_iLimit : '');
		$oAnswer = new APP_Model_Answer();
		foreach($rows as $key => $row) {
			$row['numAnswers'] = count($oAnswer->getList('question_id = ' . $this->quote($row['id'])));
			$row['numVotes']   = 0;
			$rows[$key] = $row;
		}
		return $rows;
	}
	
	/**
	 * Vote up a question
	 *
	 * @param integer $p_iQuestionID The Question ID
	 * @param array $p_aQuestion The Question Data. If this is not passed, we look it up automatically
	 * @return integer
	 */
	function voteUp($p_iQuestionID, $p_aQuestion = array()) {
		if(empty($p_aQuestion)) {
			$p_aQuestion = $this->find($p_iQuestionID);
		}
		return $this->putRecord(array(
			$this->_primary => $p_iQuestionID, 
			'votes'         => (int) $p_aQuestion['votes'] + 1
		));
	}
	
	/**
	 * Increase the amount of views for a question
	 *
	 * @param integer $p_iQuestionID The Question ID
	 * @param array $p_aQuestion The Question Data. If this is not passed, we look it up automatically
	 * @return unknown
	 */
	function increaseViews($p_iQuestionID, $p_aQuestion = array()) {
		if(empty($p_aQuestion)) {
			$p_aQuestion = $this->find($p_iQuestionID);
		}		
		return $this->putRecord(array(
			$this->_primary => $p_iQuestionID, 
			'views'         => (int) $p_aQuestion['views'] + 1
		));
	}


}