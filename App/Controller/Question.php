<?php
class APP_Controller_Question extends APP_Controller_Application {
	
	function index() {
		
		$oQuestion = new APP_Model_Question();
		$aTopQuestions = $oQuestion->getTopQuestions();
		$this->load('home/index', array(
			'aTopQuestions' => $aTopQuestions
		));
	}
	
	function view() {
		
		if( ($iQuestionID = $this->get('view')) === '') {
			throw new PPI_Exception('Unable to get question information.');
		}

		$oQuestion = new APP_Model_Question();
		$aQuestion = $oQuestion->find($iQuestionID);
		if(empty($aQuestion)) {
			throw new PPI_Exception('Unable to get question information.');
		}
		
		if($this->isAdminLoggedIn() === false) {
			$oQuestion->increaseViews($iQuestionID, $aQuestion);
		}
		
		$oUser              = new APP_Model_User();
		$oQuestionTag       = new APP_Model_Question_Tag();
		$aQuestion['owner'] = $oUser->find($aQuestion['user_id']);
		$aQuestion['tags']  = $oQuestionTag->getQuestionTags($aQuestion['id']);
		
		$this->addJavascript('question/view.js');
		$this->addStylesheet('question/view.css');
		$this->load('question/view', array(
			'aQuestion' => $aQuestion
		));
		
	}
	
	/**
	 * Ajax request to vote up a question
	 * @todo Make sure a user can't vote twice
	 * @return void
	 */
	function ajax_vote_up() {
		
		if( ($iQuestionID = $this->post('question_id', '')) === '' ) {
			die('E_INVALID_PARAM');
		}
		
		
		$oQuestion = new APP_Model_Question();
		$aQuestion = $oQuestion->find($iQuestionID);
		if(empty($aQuestion)) {
			die('E_INVALID_QUESTION_ID');
		}
		
		$oQuestion->voteUp($iQuestionID, $aQuestion);
		die('E_OK');
		
	}
	
	function ask() {
		
		$this->loginCheck();
		if($this->isPost()) {
			$this->_askSave();
		}
		$oTag = new APP_Model_Tag();
		$this->addStylesheet('smoothness/jquery-ui-1.8.6.custom.css');
		$this->addJavascript('jquery-ui-1.8.6.min.js');
		$this->load('question/ask', array(
			'aTags' => $oTag->getList('', 'title ASC')
		));
		
	}
	
	private function _askSave() {
		
		$oQuestion     = new APP_Model_Question();
		$oTag          = new APP_Model_Tag();
		$oQuestionTag  = new APP_Model_Question_Tag();		
		
		$aQuestion = $this->post();
		$aQuestion['user_id'] = $this->getAuthData(false)->id;		
		$aQuestion['tags'] = array_map('trim', explode(',', $aQuestion['tags']));
		$aFormTags = $aQuestion['tags'];
		unset($aQuestion['tags']);
		
		// -- Insert
		$iQuestonID = $oQuestion->putRecord($aQuestion);
		
		// -- Prepare and insert the tags for this question
		$aTags = array();
		foreach($aFormTags as $tag) {
			$aTags[] = array(
				'tag_id'      => $oTag->getTagIDFromTitle($tag), 
				'question_id' => $iQuestonID);
		}
		$oQuestionTag->insertMultiple($aTags);		
		
		// -- Render stuff
		$this->setFlashMessage('Question successfully posted.');
		$this->redirect('question/view/' . $iQuestonID . '/' . urlencode(str_replace(' ', '-', $aQuestion['title'])));
		
	}
	
	function reply() {
		$this->loginCheck();
		$iQuestionID = $this->get('reply');
		$oQuestion   = new APP_Model_Question();
		$aQuestion   = $oQuestion->find($iQuestionID);
		if(empty($aQuestion)) {
			throw new PPI_Exception('Invalid Question ID');
		}
		
		if($this->isPost()) {
			$this->_replySave();
		}
		
		$this->load('question/reply');
		
	}
	
	private function _replySave() {

		$this->setFlashMessage('Reply successfully posted.');
		$this->redirect();		
		
	}
	
	private function ajax_reply() {
		
	}
	
}