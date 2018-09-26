<?php	
class Application_Model_Samp extends Zend_Db_Table_Abstract {
	
	protected $_name = 'Employee_informations';
	protected $_sid;
	protected $_firstname;
	protected $_lastname;
	protected $_dateofbirth;
	protected $_mobilenumber;
	protected $_companyname;
	protected $_jobrole;
	protected $_enddate;
	protected $_description;
	protected $_rate;
	protected $_userid;
	
	
	
	
	
	public function __set($name, $value){
		$this->$name = $value; 
	}
	
	
		public function updat(){
		
		  $user = $this->select()
                ->from(array('a' => $this->_name),array('count(*)'))
				->where("a.User_id = '$this->_userid'")
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
		
		 public function updatee(){
			
		$data=array(
              'Firstname' => $this->_firstname,
              'Lastname' => $this->_lastname,
			  'Dateofbirth' => $this->_dateofbirth,
			  'Mobile_number' => $this->_mobilenumber,
			  'Company_name' => $this->_companyname,
			  'Job_role' => $this->_jobrole,
			  'Start_date' => $this->_startdate,
			  'End_date' => $this->_enddate,
			  'Description' => $this->_description,
			  'Rate' => $this->_rate,
			  'User_id' => $this->_userid);
			  
			  
			$where = array('User_id = ?'=>$this->_userid );
		    $variable=$this->update($data, $where);
			return $variable;
			
}
}
?>