<?php
class APP_Controller_Ticket extends APP_Controller_Application {

	public function index() {
		$filter = $this->get('filter', '');
		$tickets = array();

		// If we're filtering by cat
		if($filter === 'cat' && ($repo = $this->get($filter, '')) !== '') {
			$ticketParams['filter_type'] = 'cat';
			$ticketParams['filter']      = str_replace('-', ' ', $repo);
			$filter                      = str_replace('-', ' ', $this->get($filter));
			$ticketParams['repo']        = $repo;
			$ticketParams['username']    = $this->getConfig()->custom->login_github;
			$ticket                      = new APP_Model_Ticket();
			$tickets                     = $ticket->getTickets($ticketParams);
		}

		// If we're filtering by 'mine'
		/*if($filter === 'mine' && $this->isLoggedIn() === true) {
			$aTicketParams['filter_type'] = 'mine';
			$aTicketParams['filter'] = $this->getAuthData(false)->id;
			$sFilter = 'mine';
		}*/

		$this->addStylesheet('ticket-table.css');
		$this->load('ticket/index', compact('tickets', 'filter', 'ticketParams'));
	}

	public function view() {
		$id       = $this->get('view');
		$repo     = $this->get($id);
		$username = $this->getConfig()->custom->login_github;
		if($username === '') {
			throw new PPI_Exception('Invalid Username');
		}

		$iTicketID = $this->get('view', 0);
		if($iTicketID < 1) {
			throw new PPI_Exception('Invalid Ticket ID');
		}
		$oTicket = new APP_Model_Ticket();
		$aTicket = $oTicket->getTicket(array('id' => $iTicketID, 'repo' => $repo,'username' => $username));
		if(count($aTicket) == 0) {
			throw new PPI_Exception('Unable to find ticket data');
		}
		$oComment  = new APP_Model_Ticket_Comment();
		$aComments = $oComment->getComments(array('ticket_id' => $aTicket['id'], 'repo' => $repo, 'username' => $username));

		$this->addCSS('ticket');

		$this->load('ticket/view', compact('aTicket', 'aComments', 'repo', 'username'));
	}

	public function create() {
		$this->addEditHandler('create');
	}

	public function edit() {
	    $this->addEditHandler('edit');
	}

	private function addEditHandler($p_sMode = 'create') {
		$this->loginCheck();
		$bEdit = $p_sMode === 'edit';
		$oTicket = new APP_Model_Ticket();
		$oForm   = new PPI_Model_Form();
		$oForm->init('ticket_create');
		$oForm->disableSubmit();
		$oForm->setFormStructure($oTicket->getAddEditFormStructure($p_sMode, array(
			'isAdmin' => $this->getAuthData(false)->role_name !== 'member'
		)));
		// Get the ticket ID
		$iTicketID = $this->get($p_sMode, 0);

		if($oForm->isSubmitted() && $oForm->isValidated()) {
			$aSubmitValues = $oForm->getSubmitValues();
			$aSubmitValues += array(
				'status'           => 'open',
				'severity'         => 'minor',
				'assigned_user_id' => 0,
				'user_id'          => $this->getAuthData(false)->id,
				'created'          => time()
			);

			if($bEdit && $iTicketID > 0) {
			    $oTicket->update($aSubmitValues, $oTicket->getPrimaryKey() . " = " . $oTicket->quote($iTicketID));
			} else {
                $iTicketID = $oTicket->insert($aSubmitValues);
			}

			$this->setFlashMessage('Ticket successfully ' . ($bEdit ? 'updated.' : 'created'));
			$this->redirect('ticket/view/' . $iTicketID . '/' . str_replace(' ', '-', $aSubmitValues['title']));
		}

		if($p_sMode === 'edit' && $iTicketID > 0) {
		    $oForm->setDefaults($oTicket->find($iTicketID));
		}
		$formBuilder = $oForm->getRenderInformation();
		$aTicket = $oTicket->find($iTicketID);
		$this->load('ticket/create', compact('aTicket', 'formBuilder'));
	}

	public function delete() {
		$this->loginCheck();
		$iTicketID = $this->_input->get('delete');
		$oTicket   = new APP_Model_Ticket();
		$oTicket->delete($iTicketID);
		$this->redirect('ticket');
	}

	public function cdelete() {
		$this->loginCheck();
		$iCommentID = $this->_input->get('cdelete');
		$iTicketID  = $this->_input->get('tid');
		$oComment   = new APP_Model_Comment();
		$oTicket->delete($iTicketID);
		$this->redirect('ticket');
	}

	public function ccreate() {
		$this->loginCheck();
		$oComment = new APP_Model_Ticket_Comment();
		$oComment->insert(array(
			'created'   => time(),
			'content'   => $this->post('content'),
			'ticket_id' => $this->post('ticket_id'),
			'user_id'   => $this->getAuthData(false)->id
		));
		$this->setFlashMessage('Comment created.');
		$this->redirect('ticket/view/' . $this->post('ticket_id'));
	}
}
