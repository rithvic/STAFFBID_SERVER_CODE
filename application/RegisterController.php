<?php
class Api_RegisterController extends Zend_Controller_Action
{
	
	public function init()
    {
		
		$this->header = Zend_Controller_Front::getInstance ()->getResponse ();
		$this->header->setHeader ( "Content-Type", "application/json" );
		$this->header->setHeader ( "Method", $_SERVER ['REQUEST_METHOD'] );
		$this->header->setHeader ( "HOST", $_SERVER ['SERVER_NAME'] );
		$this->_filedate = date("Ymd", time());
		
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
	
		$this->Auth = new  ;
		
		$this->mobj = new Application_Model_FinalModel;
		
		
		
		
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

		public function indexAction()
		{
			// action body
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
	    public function signupAction(){
		
		 if (!$this->getRequest()->isPost())
    	{
    		$encode = json_encode(array('Error'=>"only Post Method allow ."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
    	}  
		
//name,mobile,email,address,gps,password,socialtype,socialid,gender,status,familyIncome,background,reservation
		
		
		$fname = trim ( $this->getRequest ()->getParam ( 'firstname' ) );
		$lname = trim ( $this->getRequest ()->getParam ( 'lastname' ) );
		$email = trim ( $this->getRequest ()->getParam ( 'email' ) );
		$pass = trim ( $this->getRequest ()->getParam ( 'password' ) );
		$token= trim($this->getRequest()->getParam('token'));
		$phone = trim ( $this->getRequest ()->getParam ( 'phoneno' ) );
		$phoneno = str_replace("-","",$phone);
		$randomkey = trim ( $this->getRequest ()->getParam ( 'randomkey' ) );
		
	   //&&preg_match('/^[0-9]{10}+$/', $phoneno)  valid phone to 10 
		 
		if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false){
				
			if($pass!=""){
			$realpass = $this->Auth->encrypt($pass, SHA_ENCRYPTION_KEY);
				
				
			$this->mobj->_fname  = $fname;
			$this->mobj->_lname  = $lname;
			$this->mobj->_email  = $email;
			$this->mobj->_phoneno= $phoneno;
			$this->mobj->_pass   = $realpass;
			$this->mobj->_token =$token;
			$this->mobj->_randomkey  = $randomkey;
			
			/* $profilepicturelink="";
			
			if($profilepicture!=""){
				$profilepictureexp = explode(".",$profilepicture);
				$profilepicturecount=count($profilepictureexp)-1;
				$profilepicturelink= $profilename.'.'.$profilepictureexp[$profilepicturecount];
			}
			$this->mobj->_profilename=$profilename;
			$this->mobj->_picture=SERVER_URL.'images/Profile/'.$profilepicturelink;
		 */
		
			$details = $this->mobj->email();
			
			
			if($details[0]['count(*)']>0){
				$encode = json_encode("Emailerror");
				echo $encode; 
				
			}else{
				
			//move_uploaded_file($profilepicturetmp, PROFILE_PATH.'/'.$profilepicturelink);
			
			$details = $this->mobj->signup();

			$encode = json_encode("success");
		    echo $encode;
			
				} 	
			}
		}
		else {
			$encode = json_encode("incorrect");
		    echo $encode;
        }	

	}
               // img upload
       public function setImageUserAction(){
			
			
			if (!$this->getRequest()->isPost())
			{
    		$encode = json_encode(array('error'=>" Only Post method allow ."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
			}
			
		/* 	$profilename = trim ( $this->getRequest ()->getParam ( 'username' ) );
				$profilepicture= $_FILES["profilepic"]["name"];
			$profilepicturetmp= $_FILES['profilepic']['tmp_name'];
		
		
			$profilepicturelink="";
			if($profilename!=""){
			 if($profilepicture!=""){
				$profilepictureexp = explode(".",$profilepicture);
				$profilepicturecount=count($profilepictureexp)-1;
				$profilepicturelink= $profilename.'.'.$profilepictureexp[$profilepicturecount];
			}
			$this->mobj->_profilename=$profilename;
			$this->mobj->_picture=SERVER_URL.'images/Profile/'.$profilepicturelink; 
		
		
				move_uploaded_file($profilepicturetmp, PROFILE_PATH.'/'.$profilepicturelink);
				
				$detail = $this->mobj->insertpic(); 
				$encode = json_encode("your account activated");
		        echo $encode;
		}
			 */
		
			$profilename = trim ( $this->getRequest ()->getParam ( 'username' ) );
			
			$key=trim($this->getRequest()->getParam('randomkey'));
			$profilepicture= $_FILES["profilepic"]["name"];
			$profilepicturetmp= $_FILES['profilepic']['tmp_name'];
			
			
			$this->mobj->_randomkey=$key;
			
			$datakey=$this->mobj->selectkey();
	
	foreach($datakey as $data){
			$data1=$data['Randomkey'];		
		}
		if($data1!=$key){
			$data=json_encode("wrongkey");
			echo $data;
		}
		else{
		
		
			$profilepicturelink="";
			if($profilename!=""){
			 if($profilepicture!=""){
				$profilepictureexp = explode(".",$profilepicture);
				$profilepicturecount=count($profilepictureexp)-1;
				$profilepicturelink= $profilename.'.'.$profilepictureexp[$profilepicturecount];
			}
			$this->mobj->_randomkey=$key;
			$this->mobj->_profilename=$profilename;
			$this->mobj->_picture=SERVER_URL.'images/Profile/'.$profilepicturelink; 
		
		
				move_uploaded_file($profilepicturetmp, PROFILE_PATH.'/'.$profilepicturelink);
				
				$detail = $this->mobj->insertpic(); 
				$encode = json_encode("image uploading success");
		        echo $encode;
		}
		
	
  } 
}


                            // login  action  
         public function loginAction(){
		
		if (!$this->getRequest()->isPost())
    	{
    		$encode = json_encode(array('Error'=>"only Post method  allowed."));
			$this->header->setHttpResponseCode ( 405 );
			$respcode = $this->header->getHttpResponseCode ();
			$this->header->setHeader ( "Status", $respcode );
			echo $this->header->setHeader ( "Content-Length", strlen($encode));			
			echo $encode;
    		exit;
    	}
		//$phoneno = trim ( $this->getRequest ()->getParam ( 'phoneno' ) );
		$email = trim ( $this->getRequest ()->getParam ( 'email' ) );
		$pass = trim ( $this->getRequest ()->getParam ( 'password' ) );
		

	if($email!=""){
		
		$this->mobj->_email  = $email;
		$mobjdetail1 = $this->mobj->getlogin();
		$plainpassword = $this->Auth->decrypt($mobjdetail1['0']['Password'], SHA_ENCRYPTION_KEY);
	
	if($plainpassword == $pass){
		 $encode = json_encode("login");		
		echo $encode; 
	      }
	else{
		 $encode = json_encode("wrong pass or email");			
		echo $encode; 	
	    }
		
	}
	else{
		 $encode = json_encode("please enter email");			
		echo $encode; 	
	    }
	
	
	/* else{
			$this->mobj->_phoneno  = $phoneno;
		 $mobjdetail1 = $this->mobj->loginphone();
		$plainpassword = $this->Auth->decrypt($mobjdetail1['0']['Password'], SHA_ENCRYPTION_KEY);
	
	if($plainpassword == $pass){
		 $encode = json_encode("login from phone");		
		echo $encode; 
	      }
	else{
		 $encode = json_encode(" wrong phone no or pass");			
		echo $encode; 	
	    }
		 
	} */		
	}

}


?>