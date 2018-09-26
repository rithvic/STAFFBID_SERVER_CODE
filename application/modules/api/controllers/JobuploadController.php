<?php
class Api_JobuploadController extends Zend_Controller_Action {
	
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
		
		$this->upload = new Application_Model_Jobupload;
		$this->applyjobs = new Application_Model_Applyjobs;
		
		
	}  
		/*public function preDispatch() {
			
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
		}*/

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
		
		public function jobUploadAction(){
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
			
			$Title = trim ( $this->getRequest ()->getParam ( 'Title' ) );
			$Location = trim ( $this->getRequest ()->getParam ( 'Location' ) );
			$EOC = trim ( $this->getRequest ()->getParam ( 'EOC' ) );
			$Contact = trim ( $this->getRequest ()->getParam ( 'Contact' ) );
			$Description = trim ( $this->getRequest ()->getParam ( 'Description' ) );
			$User_id = trim ( $this->getRequest ()->getParam ( 'User_id' ) );
			//$Job_id = trim ( $this->getRequest ()->getParam ( 'Job_id' ) );
			$Job_id = uniqid();
			
			/*$Title = "Networking";
			$Location = "Chennai";
			$EOC = "2 Lacks";
			$Contact = "7418686277";
			$Description = "CCNA";
			$User_id = "xyz1234567";*/
			
			
			$this->upload->_title=$Title;
			$this->upload->_location=$Location;
			$this->upload->_eoc=$EOC;
			$this->upload->_contact=$Contact;
			$this->upload->_description=$Description;
			$this->upload->_userid=$User_id;
			$this->upload->_jobid=$Job_id;
			
			$dataview = $this->upload->jobupload();
			
			if($dataview){
					echo $encode = json_encode ( array (
					"Response" => "success",
					"Jobseeker_profile" => $dataview ));
			}else{
					echo $encode = json_encode ( array (
					"Response" =>"No data found"));
			}
			
		}
		
		public function getUploadedJobsAction(){
			if (!$this->getRequest()->isGet())
			{
				$encode = json_encode(array('error'=>"This function accepts only GET."));
				$this->header->setHttpResponseCode ( 405 );
				$respcode = $this->header->getHttpResponseCode ();
				$this->header->setHeader ( "Status", $respcode );
				echo $this->header->setHeader ( "Content-Length", strlen($encode));			
				echo $encode;
				exit;
			}
			
			$dataview = $this->upload->getuploadedjobs();
			
			if($dataview){
					echo $encode = json_encode ( array (
					"Response" => "success",
					"Jobseeker_profile" => $dataview ));
			}else{
					echo $encode = json_encode ( array (
					"Response" =>"No data found"));
			}
		}
		
		public function getEmployeeUploadJobsAction(){
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
			
			$User_id = trim ( $this->getRequest ()->getParam ( 'User_id' ) );
			//$User_id = "xyz12345";
			$this->upload->_userid=$User_id;
			
			$dataview = $this->upload->userjoblist();
			
			if($dataview){
					echo $encode = json_encode ( array (
					"Response" => "success",
					"User_Job_list" => $dataview ));
			}else{
					echo $encode = json_encode ( array (
					"Response" =>"No data found"));
			}
		}
		
		public function applyJobsAction(){
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
			$json = file_get_contents('php://input');
			$array = json_decode($json);
			
			if($array == null){
				echo json_encode(array("Error" =>"Does not valid Request"));
			}else{
				$Title = $array->{'Title'};
			 	$Location = $array->{'Location'};
			 	$EOC = $array->{'EOC'};
			 	$Contact = $array->{'Contact'};
			 	$Description = $array->{'Description'};
			 	$User_id = $array->{'User_id'};
			 	$Job_id = $array->{'Job_id'};

				
				$this->applyjobs->_title=$Title;
				$this->applyjobs->_location=$Location;
				$this->applyjobs->_eoc=$EOC;
				$this->applyjobs->_contact=$Contact;
				$this->applyjobs->_description=$Description;
				$this->applyjobs->_userid=$User_id;
				$this->applyjobs->_jobid=$Job_id;
				
				$details = $this->applyjobs->applytimelimit();
				
				if($details[0]['count(*)']>0){
					$encode = json_encode(array("Response" =>"Already Apllied"));
					echo $encode; 			
				}else{
					$dataview = $this->applyjobs->jobapply();
				
					if($dataview){
						echo json_encode(array("Response" => "Successfully Apllied"));
					}else{
						echo json_encode(array("Response" =>"Error occured in Insert Data"));
					}
				}
			}	
		}
		
		
}
?>		 