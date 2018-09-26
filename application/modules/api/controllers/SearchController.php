<?php
class Api_SearchController extends Zend_Controller_Action {
		
	public function init() {
		
		$this->header = Zend_Controller_Front::getInstance ()->getResponse ();
		$this->header->setHeader ( "Content-Type", "application/json" );
		$this->header->setHeader ( "Method", $_SERVER ['REQUEST_METHOD'] );
		$this->header->setHeader ( "HOST", $_SERVER ['SERVER_NAME'] );
		$this->_filedate = date("Ymd", time());
		
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$this->Rest = new Classes_Rest;
		$this->Auth = new Classes_Auth;
		
		$this->register = new Application_Model_Registerinformation;
		$this->employee = new Application_Model_Employee;
		$this->jobseeker = new Application_Model_Jobseeker;	

	}  
		public function preDispatch() {
			
			 if (! $this->Auth->authAccepted($this->getRequest()))
			 {
			$encode = json_encode(array('error'=>"Your request is not authenticated."));
				$this->header->setHttpResponseCode ( 401 );
				$respcode = $this->header->getHttpResponseCode ();
				$this->header->setHeader ( "Status", $respcode );
				echo $this->header->setHeader ( "Content-Length", strlen($encode));
				echo $encode;
						
			exit;
			}
		}

		public function indexAction() {

			if (!$this->getRequest()->isPost())
			{
				$encode = json_encode(array('error'=>"This function accepts only POST."));
				$this->header->setHttpResponseCode ( 405 );
				$respcode = $this->header->getHttpResponseCode ();
				$this->header->setHeader ( "Status", $respcode );
				echo $this->header->setHeader ( "Content-Length", strlen($encode));			
				echo $encode;
				exit;
			}
		}
}
?>