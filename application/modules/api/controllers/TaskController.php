<?php
class Api_TaskController extends Zend_Controller_Action {
		
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
		
		$this->refer = new Application_Model_Sam;
		$this->referr = new Application_Model_Samp;
		$this->referrr = new Application_Model_Sample;
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

	public function gettAction(){

if(!$this->getRequest()->isPost()){
$encode = json_encode(array('Error'=>"This function accepts only POST."));
$this->header->setHttpResponseCode ( 405 );
$respcode = $this->header->getHttpResponseCode ();
$this->header->setHeader ("Status", $respcode );
echo $this->header->setHeader ("Content-Length", strlen($encode));			
echo $encode;
exit;
}


 $json = file_get_contents('php://input');
			$array = json_decode($json);
			
			if($array == null){
				echo json_encode(array("Error" =>"Does not valid Request"));
			}else{
				
				
				$Start_date = $array->{'Start_date'};
				$End_date = $array->{'End_date'};
				$Title = $array->{'Title'};
				
			$this->refer->_startdate = $Start_date;

			$this->refer->_enddate = $End_date;

			$this->refer->_title = $Title;
			 
				$detail=$this->refer->flow($Title,$Start_date,$End_date);

				echo json_encode($detail);
			}

}

			public function searchListAction(){
				if(!$this->getRequest()->isPost()){
					$encode = json_encode(array('Error'=>"This function accepts only POST."));
					$this->header->setHttpResponseCode ( 405 );
					$respcode = $this->header->getHttpResponseCode ();
					$this->header->setHeader ("Status", $respcode );
					echo $this->header->setHeader ("Content-Length", strlen($encode));			
					echo $encode;
					exit;
				}
				
				$json = file_get_contents('php://input');
				$array = json_decode($json);
				
				if($array == null){
					echo json_encode(array("Error" =>"Does not valid Request"));
				}else{
					
					$Title = $array->{'Title'};
					$Start_date = $array->{'Start_date'};
					$End_date = $array->{'End_date'};
					
					/* $this->refer->_title = $Title;
					$this->refer->_startdate = $Start_date;
					$this->refer->_enddate = $End_date; */
					$modelview = $this->refer->search($Title,$Start_date,$End_date);
				    echo json_encode($modelview);
				}
				
				//$modelview = $this->refer->search();
				//echo json_encode($modelview);
				//echo "hjgyjugyugh";
			}
			
			public function searchAction(){
				if(!$this->getRequest()->isPost()){
					$encode=json_encode(array("Error"=>"This method accept only POST!"));
				$this->header->setHttpResponseCode(405);
				$respcode=$this->header->getHttpResponseCode();
				$this->header->setHeader("Status",$respcode);
				echo $this->header->setHeader("Content-Length",strlen($encode));
				echo $encode;
				exit;
				}
				
			}
			
			public function editAction(){
				if(!$this->getRequest()->isPost()){
					$encode=json_encode(array("Error"=>"This method accept only POST!"));
				$this->header->setHttpResponseCode(405);
				$respcode=$this->header->getHttpResponseCode();
				$this->header->setHeader("Status",$respcode);
				echo $this->header->setHeader("Content-Length",strlen($encode));
				echo $encode;
				exit;
				}
				$json = file_get_contents('php://input');
				$array = json_decode($json);
				if($array == null){
					echo json_encode(array("Error" =>"Does not valid Request"));
				}else{
					
					
					$Firstname = $array->{'Firstname'};
					$Lastname = $array->{'Lastname'};
					$Dateofbirth = $array->{'Dateofbirth'};
					$Mobile_number = $array->{'Mobile_number'};
					$Company_name = $array->{'Company_name'};
					$Job_role = $array->{'Job_role'};
					$Start_date = $array->{'Start_date'};
					$End_date = $array->{'End_date'};
					$Description = $array->{'Description'};
					$Rate = $array->{'Rate'};
					$User_id = $array->{'User_id'};
					
					
					$this->referr->_firstname = $Firstname;
					$this->referr->_lastname = $Lastname; 
					$this->referr->_dateofbirth = $Dateofbirth; 
					$this->referr->_mobilenumber = $Mobile_number; 
					$this->referr->_companyname = $Company_name; 
					$this->referr->_jobrole = $Job_role; 
					$this->referr->_startdate = $Start_date; 
					$this->referr->_enddate = $End_date; 
					$this->referr->_description = $Description; 
					$this->referr->_rate = $Rate; 
					$this->referr->_userid = $User_id; 
					
					
					$details = $this->referr->updat();
					if($details[0]['count(*)']>0){
							
							$detail = $this->referr->updatee();
							echo $encode=json_encode ( array (
												"Response" => "Updated successfully",
												"User_id" => $User_id ));
									
						}
						else{	
							//$det = $this->referr->updateee();
							
				    echo $encode=json_encode ( array (
												"Response" => "Update failed",
												"User_id" => $User_id ));
				}
				
			}		
}


public function edittAction(){
				if(!$this->getRequest()->isPost()){
					$encode=json_encode(array("Error"=>"This method accept only POST!"));
				$this->header->setHttpResponseCode(405);
				$respcode=$this->header->getHttpResponseCode();
				$this->header->setHeader("Status",$respcode);
				echo $this->header->setHeader("Content-Length",strlen($encode));
				echo $encode;
				exit;
				}
				$json = file_get_contents('php://input');
				$array = json_decode($json);
				if($array == null){
					echo json_encode(array("Error" =>"Does not valid Request"));
				}else{
					
					
					$Brand_name = $array->{'Brand_name'};
					$Company_number = $array->{'Company_number'};
					$VAT_number = $array->{'VAT_number'};
					$Contact_name = $array->{'Contact_name'};
					$Phone_number = $array->{'Phone_number'};
					$Address_line_1 = $array->{'Address_line_1'};
					$Address_line_2 = $array->{'Address_line_2'};
					$Start_date = $array->{'Start_date'};
					$End_date = $array->{'End_date'};
					$Company_description = $array->{'Company_description'};
					$Rate = $array->{'Rate'};
					$User_id = $array->{'User_id'};
					
					
					$this->referrr->_brandname = $Brand_name;
					$this->referrr->_companynumber = $Company_number; 
					$this->referrr->_vatnumber = $VAT_number; 
					$this->referrr->_contactname = $Contact_name; 
					$this->referrr->_phonenumber = $Phone_number; 
					$this->referrr->_addressline1 = $Address_line_1; 
					$this->referrr->_addressline2 = $Address_line_2; 
					$this->referrr->_startdate = $Start_date; 
					$this->referrr->_enddate = $End_date; 
					$this->referrr->_companydescription = $Company_description; 
					$this->referrr->_rate = $Rate; 
					$this->referrr->_userid = $User_id; 
					
					
					$details = $this->referrr->up();
					if($details[0]['count(*)']>0){
							
							$detail = $this->referrr->up1();
							echo(json_encode("Updated Successfully"));
									
						}
						else{	
							//$det = $this->referr->updateee();
							
				    echo json_encode(array("User_id Not exist"));
				}
				
			}		
}


}
?>