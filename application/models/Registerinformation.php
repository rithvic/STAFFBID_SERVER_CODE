<?php
class Application_Model_Registerinformation extends Zend_Db_Table_Abstract {
	
	protected $_name = 'User_Information';
	protected $_id;
	protected $_fullname;
	protected $_email;
	protected $_password;
	protected $_userid;
	protected $_type;
	protected $_firstname;
	protected $_lastname;
	protected $_dateofbirth;
	protected $_phone;
	
	public function __set($name, $value){
		$this->$name = $value; 
	}
	
	
	public function email(){
		  $user = $this->select()
                ->from(array('a' => $this->_name),array('count(*)'))
				->where("a.Email = '$this->_email'")
				->setIntegrityCheck(false);

		  $userdata = $this->fetchAll($user);
		
		  $result = $userdata->toArray();
		    if ($result) {
			return $result;
        }   
			else {
            return false;
        } 
	}
	 
	public function signup(){
			$insert=array('Name'=>$this->_fullname,'Email'=>$this->_email,'Password'=>$this->_password,'User_Id'=>$this->_userid,'Type'=>$this->_type);
		
			$insertdata = $this->insert($insert); 
			$data = $this->select()
                ->from(array('a' => $this->_name))
				->where("a.S_Id = $insertdata")
                ->setIntegrityCheck(false);
				
			$data = $this->fetchAll($data);
			if ($data) {
				return $data->toArray();
			} else {
				return false;
			}	 
	}
	
	/*public function secondlevel(){
			$insert=array('Firstname'=>$this->_firstname,'Lastname'=>$this->_lastname,'Dateofbirth'=>$this->_dateofbirth,'Phone'=>$this->_phone);
		
			$insertdata = $this->insert($insert); 
			$data = $this->select()
                ->from(array('a' => $this->_name))
				->where("a.S_Id = $insertdata")
                ->setIntegrityCheck(false);
				
			$data = $this->fetchAll($data);
			if ($data) {
				return $data->toArray();
			} else {
				return false;
			}
			
	}*/
	
	
	
	public function getlogin(){
          $user = $this->select()
                ->from(array('a' => $this->_name))
				->where("a.Email = '$this->_email' AND a.Type = '$this->_type'") 
				->setIntegrityCheck(false);

		  $userdata = $this->fetchAll($user);	
		  $result = $userdata->toArray();
			if ($result) {
			return $result;
        }	
			else {
            return false;
        } 	
	}
	
	public function checkemail(){
          $user = $this->select()
                ->from(array('a' => $this->_name))
				->where("a.Email = '$this->_email'") 
				->setIntegrityCheck(false);

		  $userdata = $this->fetchAll($user);	
		  $result = $userdata->toArray();
			if ($result) {
			return $result;
        }	
			else {
            return false;
        } 	
	}
		
	
}
?>