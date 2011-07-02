<?php
class APP_Controller_Search extends APP_Controller_Application {
	
	function index() {
		$sSearchTerm = $this->get('index');
		if(trim($sSearchTerm) == '') {
			throw new PPI_Exception('Search term cannot be blank');
		}
	}
	
}