<?php
class APP_Controller_Home extends APP_Controller_Application {

	function index() {

        $this->addjs('home');
		$oTicket = new APP_Model_Ticket();
		$oTicketCat = new APP_Model_Ticket_Category();
		$customRepos = $this->getConfig()->repos->toArray();
        $repos = array();
		foreach($customRepos as $key => $repo) {
			list($user, $repoName) = explode(':', $repo, 2);
            $repos[$key]["repoName"] = $repoName;
            $repos[$key]["user"] = $user;
		}
        
		$this->addStylesheet('ticket-table.css');
		$this->load('home/index', compact('tickets', 'repos'));
	}

	function search() {
		if( ($keyword = $this->get('keyword', '')) == '') {
			$this->redirect('');
		}
		$oTicket = new APP_Model_Ticket();
		$tickets = $oTicket->getTickets(compact('keyword'));
		$this->load('home/index', compact('tickets', 'keyword'));
	}

}
