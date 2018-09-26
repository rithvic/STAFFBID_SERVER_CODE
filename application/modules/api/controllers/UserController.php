<?php
class Api_UserController extends Zend_Controller_Action {
	
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
		 
		
		
		public function signupInformationAction(){
			if (!$this->getRequest()->isPost())
			{
				$encode = json_encode(array('Error'=>"This function accepts only POST."));
				$this->header->setHttpResponseCode ( 405 );
				$respcode = $this->header->getHttpResponseCode ();
				$this->header->setHeader ( "Status", $respcode );
				echo $this->header->setHeader ( "Content-Length", strlen($encode));			
				echo $encode;
				exit;
			} 
			
			$name = trim ( $this->getRequest ()->getParam ( 'name' ) );
			$email = trim ( $this->getRequest ()->getParam ( 'email' ) );
			$pass = trim ( $this->getRequest ()->getParam ( 'password' ) );
			$userid = trim ( $this->getRequest ()->getParam ( 'userid' ) );
			$type = trim ( $this->getRequest ()->getParam ( 'type' ) );
			
			/*$userid = "123456789";
			$name = "Benchmark";
			$type = "Employee";
			$email = "benchsoft@gmail.com"; 
			$pass = "bechmark@123";*/
			
			if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false){
			
			list ($user, $domain) = explode('@', $email);
			list ($domain, $tld) = explode('.', $domain);

			if($domain == "gmail" && $tld == "com"||$domain == "yahoo" && $tld == "com"||$domain == "yahoo" && $tld == "in" && $domain == "hotmail" || $tld == "com"){
			if($pass!=""){ 
				
			$output = false;
			$encrypt_method = "AES-256-CBC";
			$secret_key = 'This is my secret key';
			$secret_iv = 'This is my secret iv';
			$key = hash('sha256', $secret_key);
			$iv = substr(hash('sha256', $secret_iv), 0, 16);
			$output = openssl_encrypt($pass, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
			 
			$this->register->_fullname=$name;
			$this->register->_email=$email;
			$this->register->_password=$output;
			$this->register->_userid=$userid;
			$this->register->_type=$type;
			 
			$details = $this->register->email();
				if($details[0]['count(*)']>0){
					$encode = json_encode("Email already register");
					echo $encode; 			
				}else{
					$detailslist = $this->register->signup();
					foreach($detailslist as $userkeylist){
						$mainkeylist = $userkeylist['User_Id'];
					}
					echo $encode = json_encode ( array (
										"Response" => "success",
										"User_Id" => $mainkeylist));
					}
				}
			}
			else{
				$encode = json_encode("Please correct email");
				echo $encode;	
				}
			}
			else{
				$encode = json_encode("Check your email");
				echo $encode;	
			}		
		}
		
		
		public function defaultLoginAction(){
		
			if (!$this->getRequest()->isPost())
			{
				$encode = json_encode(array('Error'=>"This function accepts only POST."));
				$this->header->setHttpResponseCode ( 405 );
				$respcode = $this->header->getHttpResponseCode ();
				$this->header->setHeader ( "Status", $respcode );
				echo $this->header->setHeader ( "Content-Length", strlen($encode));			
				echo $encode;
				exit;
			} 
	
			$email = trim ( $this->getRequest ()->getParam ( 'email' ) );
			$pass = trim ( $this->getRequest ()->getParam ( 'password' ) );
			$type = trim ( $this->getRequest ()->getParam ( 'type' ) );
			
			$mobjdetail1 = array();
			
			//$email = "bechmarkiphone@gmail.com";
			//$pass = "bechmark@123";
			//$type = "Job seeker";
			
			if($email!=""){
				if($type=="Employee"){
					$this->register->_email  = $email;
					$this->register->_type  = $type;
					$mobjdetail1 = $this->register->getlogin();
					
					$output = false;
					$encrypt_method = "AES-256-CBC";
					$secret_key = 'This is my secret key';
					$secret_iv = 'This is my secret iv';
					
					$key = hash('sha256', $secret_key);
					$iv = substr(hash('sha256', $secret_iv), 0, 16);
					$output = openssl_decrypt(base64_decode($mobjdetail1['0']['Password']),$encrypt_method, $key, 0, $iv);
				
					if($output == $pass){
						foreach($mobjdetail1 as $useriddata){
							$userlist = $useriddata['User_Id'];
						}
						echo $encode = json_encode ( array (
											"Response" => "success",
											"User_Id" => $userlist));
					  }
					else{
						echo $encode = json_encode ( array (
											"Response" => "Login failed" ));
					} 
				}elseif($type=="Job seeker"){
					$this->register->_type  = $type;
					$this->register->_email  = $email;
					$mobjdetail1 = $this->register->getlogin();
					
					$output = false;
					$encrypt_method = "AES-256-CBC";
					$secret_key = 'This is my secret key';
					$secret_iv = 'This is my secret iv';
					
					$key = hash('sha256', $secret_key);
					$iv = substr(hash('sha256', $secret_iv), 0, 16);
					$output = openssl_decrypt(base64_decode($mobjdetail1['0']['Password']), $encrypt_method, $key, 0, $iv);
				
					if($output == $pass){
						foreach($mobjdetail1 as $useriddata){
							$userlist = $useriddata['User_Id'];
						}
						echo $encode = json_encode ( array (
											"Response" => "success",
											"User_Id" => $userlist));
					  }
					else{
						echo $encode = json_encode ( array (
											"Response" => "Login failed" ));
					} 
				}
					
			} 
			else{
				$encode = json_encode("Please enter email");			
				echo $encode; 	
				}	
		}
		
			
		
		public function forgotPasswordAction(){
			if (!$this->getRequest()->isPost())
			{
				$encode = json_encode(array('Error'=>"This function accepts only POST."));
				$this->header->setHttpResponseCode ( 405 );
				$respcode = $this->header->getHttpResponseCode ();
				$this->header->setHeader ( "Status", $respcode );
				echo $this->header->setHeader ( "Content-Length", strlen($encode));			
				echo $encode;
				exit;
			}
			
			$forgetemail = trim ( $this->getRequest ()->getParam ( 'forgetemail' ) );
			//$forgetemail="thowfeeqmohamed3@gmail.com";
			if(!filter_var($forgetemail, FILTER_VALIDATE_EMAIL) === false){
			
			$this->register->_email=$forgetemail;
			$mobjdetail1=$this->register->checkemail();
			
			if($mobjdetail1!=""){
			
				$output = false;
				$encrypt_method = "AES-256-CBC";
				$secret_key = 'This is my secret key';
				$secret_iv = 'This is my secret iv';
				$key = hash('sha256', $secret_key);
				$iv = substr(hash('sha256', $secret_iv), 0, 16);
				$output = openssl_decrypt(base64_decode($mobjdetail1['0']['Password']), $encrypt_method, $key, 0, $iv);
				    
					$to = $forgetemail;
					$subject = 'Forget Password';
					$message = 'hi you password is '.$output; 
					$headers = 'From:benchmarkiphone@gmail.com';
				
			$retval = mail ($to,$subject,$message,$headers);
						 
						if( $retval == true ) {
							$result= "Check your email account & get updated password link...";
							$encode = json_encode($result);
							echo $encode;
						}else {
							$result= "Email not sent";
							$encode = json_encode($result);
							echo $encode;
						}	  
			}else{
				$data=json_encode("email not reisgter");
				echo $data;	
				} 	
			}
			else{ 
				$data=json_encode("wrong email");
				echo $data;	
			}			
		}

		public function secondLevelEmployeeSignupAction(){
			if (!$this->getRequest()->isPost())
			{
				$encode = json_encode(array('Error'=>"This function accepts only POST."));
				$this->header->setHttpResponseCode ( 405 );
				$respcode = $this->header->getHttpResponseCode ();
				$this->header->setHeader ( "Status", $respcode );
				echo $this->header->setHeader ( "Content-Length", strlen($encode));			
				echo $encode;
				exit;
			}
			
				$userid = trim ( $this->getRequest ()->getParam ( 'userid' ) );
				$firstname = trim ( $this->getRequest ()->getParam ( 'firstname' ) );
				$lastname = trim ( $this->getRequest ()->getParam ( 'lastname' ) );
				$dateofbirth = trim ( $this->getRequest ()->getParam ( 'dateofbirth' ) );
				$phone = trim ( $this->getRequest ()->getParam ( 'phone' ) );
				
				$companyname = trim ( $this->getRequest ()->getParam ( 'companyname' ) );
				$jobrole = trim ( $this->getRequest ()->getParam ( 'jobrole' ) );
				$startdate = trim ( $this->getRequest ()->getParam ( 'startdate' ) );
				$enddate = trim ( $this->getRequest ()->getParam ( 'enddate' ) );
				$description = trim ( $this->getRequest ()->getParam ( 'description' ) );
				$rate = trim ( $this->getRequest ()->getParam ( 'rate' ) );
				
				/*$firstname = "Mohamed";
				$lastname = "Thowfeeq";
				$dateofbirth = "22/10/1994"; 
				$phone = "7418686277";
				
				$companyname = "Benchmark business software";
				$jobrole = "Developer";
				$startdate = "1/1/2010";
				$enddate = "10/10/2018"; 
				$description = "I am a developer";
				$rate = "$50.00";
				$userid = "xyz12345";*/
				
				
				
				
			//if (preg_match('/^[0-9]{10}+$/', $phone)){
			
				if($userid!=""){ 
					$this->employee->_firstname=$firstname;
					$this->employee->_lastname=$lastname;
					$this->employee->_dateofbirth=$dateofbirth;
					$this->employee->_phone=$phone;
					$this->employee->_companyname=$companyname;
						
					$this->employee->_jobrole=$jobrole;
					$this->employee->_startdate=$startdate;
					$this->employee->_enddate=$enddate;
					$this->employee->_description=$description;
					$this->employee->_rate=$rate;
					$this->employee->_userid=$userid;
			
			 
					$details = $this->employee->useridcount();
					if($details[0]['count(*)']>0){
						$encode = json_encode("Already register");
						echo $encode; 			
					}else{	
						$detailslist = $this->employee->secondlevel();
						foreach($detailslist as $userkeylist){
							$mainkeylist = $userkeylist['User_id'];
						}
						echo $encode = json_encode ( array (
							"Response" => "success",
							"User_id" => $mainkeylist));
					} 
				}else{
					$encode = json_encode("Please correct fields");
					echo $encode;	
					}
			//}else{
			//	$encode = json_encode("Check your phone");
			//	echo $encode;	
			//	}	
			
		}
		
		public function secondLevelJobseekerSignupAction(){
			if (!$this->getRequest()->isPost())
			{
				$encode = json_encode(array('Error'=>"This function accepts only POST."));
				$this->header->setHttpResponseCode ( 405 );
				$respcode = $this->header->getHttpResponseCode ();
				$this->header->setHeader ( "Status", $respcode );
				echo $this->header->setHeader ( "Content-Length", strlen($encode));			
				echo $encode;
				exit;
			}
			
				$Brand_name = trim ( $this->getRequest ()->getParam ( 'Brand_name' ) );
				$Company_number = trim ( $this->getRequest ()->getParam ( 'Company_number' ) );
				$VAT_number = trim ( $this->getRequest ()->getParam ( 'VAT_number' ) );
				$Contact_name = trim ( $this->getRequest ()->getParam ( 'Contact_name' ) );
				$Phone_number = trim ( $this->getRequest ()->getParam ( 'Phone_number' ) );
				
				$Address_line_1 = trim ( $this->getRequest ()->getParam ( 'Address_line_1' ) );
				$Address_line_2 = trim ( $this->getRequest ()->getParam ( 'Address_line_2' ) );
				$Start_date = trim ( $this->getRequest ()->getParam ( 'Start_date' ) );
				$End_date = trim ( $this->getRequest ()->getParam ( 'End_date' ) );
				$Company_description = trim ( $this->getRequest ()->getParam ( 'Company_description' ) );
				$Rate = trim ( $this->getRequest ()->getParam ( 'Rate' ) );
				$User_id = trim ( $this->getRequest ()->getParam ( 'User_id' ) );
				
				
				/*$Brand_name = "Developer";
				$Company_number = "Benchmark business software";
				$VAT_number = "VAT123456"; 
				$Contact_name = "Mohamed Thowfeeq";
				
				$Phone_number = "7418686277";
				$Address_line_1 = "17,katchery street";
				$Address_line_2 = "Mylapore,Chennai-600004";
				$Start_date = "10/10/2010"; 
				$End_date = "10/10/2018";
				$Company_description = "Software developer";
				$Rate = "$80.50";
				$User_id = "xyz123456";*/
				
				//if (preg_match('/^[0-9]{10}+$/', $Phone_number)){
			
					if($User_id!=""){ 
						$this->jobseeker->_brandname=$Brand_name;
						$this->jobseeker->_companynumber=$Company_number;
						$this->jobseeker->_vat_number=$VAT_number;
						$this->jobseeker->_contactname=$Contact_name;
						$this->jobseeker->_phone=$Phone_number;
						
						$this->jobseeker->_address_line_1=$Address_line_1;
						$this->jobseeker->_address_line_2=$Address_line_2;
						$this->jobseeker->_startdate=$Start_date;
						$this->jobseeker->_enddate=$End_date;
						$this->jobseeker->_company_description=$Company_description;
						$this->jobseeker->_rate=$Rate;
						$this->jobseeker->_userid=$User_id;
				
				 
						$details = $this->jobseeker->useridcountjobseeker();
						if($details[0]['count(*)']>0){
							$encode = json_encode("Already register");
							echo $encode; 			
						}else{	
							$detailslist = $this->jobseeker->secondleveljobseeker();
							foreach($detailslist as $userkeylist){
								$mainkeylist = $userkeylist['User_id'];
							}
							echo $encode = json_encode ( array (
									"Response" => "success",
									"User_id" => $mainkeylist));
								} 
					}else{
						$encode = json_encode("Please correct fields");
						echo $encode;	
					}
				//}
				//else{
				//	$encode = json_encode("Check your phone");
				//	echo $encode;	
				//}	
				
		}
		
		public function profileInformationAction(){
			if (!$this->getRequest()->isPost())
			{
				$encode = json_encode(array('Error'=>"This function accepts only POST."));
				$this->header->setHttpResponseCode ( 405 );
				$respcode = $this->header->getHttpResponseCode ();
				$this->header->setHeader ( "Status", $respcode );
				echo $this->header->setHeader ( "Content-Length", strlen($encode));			
				echo $encode;
				exit;
			}
			$User_id = trim ( $this->getRequest ()->getParam ( 'User_id' ) );
			$Type = trim ( $this->getRequest ()->getParam ( 'Type' ) );
			
			//$User_id = "abcd123456789";
			//$Type = "Job seeker";
			
			if($Type=="Job seeker"){
				$dataview = $this->employee->employeeprofile($User_id);
					if($dataview){
						echo $encode = json_encode ( array (
												"Response" => "success",
												"Employee_profile" => $dataview ));
					}else{
							echo $encode = json_encode ( array (
											"Response" =>"No data found"));
					}
			}elseif($Type=="Employee"){
				$dataview = $this->jobseeker->jobseekerprofile($User_id);
					if($dataview){
						echo $encode = json_encode ( array (
												"Response" => "success",
												"Jobseeker_profile" => $dataview ));
					}else{
							echo $encode = json_encode ( array (
											"Response" =>"No data found"));
					}
			}else{
					echo $encode = json_encode ( array (
							"Response" => "Wrong userid or type" ));
			}
			
		}


		
	
}
?>