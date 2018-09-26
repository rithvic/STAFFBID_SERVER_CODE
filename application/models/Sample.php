<?php	
class Application_Model_Sample extends Zend_Db_Table_Abstract {
	
	protected $_name = 'Jobseeker_informations';
	protected $_brandname;
	protected $_companynumber;
	protected $_vatnumber;
	protected $_contactname;
	protected $_phonenumber;
	protected $_addressline1;
	protected $_addressline2;
	protected $_startdate;
	protected $_enddate;
	protected $_companydescription;
	protected $_rate;
	protected $_userid;
	
	
	
	
	
	public function __set($name, $value){
		$this->$name = $value; 
	}
	
	
		public function up(){
		
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
		
		 public function up1(){
			
		$data=array(
              'Brand_name' => $this->_brandname,
              'Company_number' => $this->_companynumber,
			  'VAT_number' => $this->_vatnumber,
			  'Contact_name' => $this->_contactname,
			  'Phone_number' => $this->_phonenumber,
			  'Address_line_1' => $this->_addressline1,
			  'Address_line_2' => $this->_addressline2,
			  'Start_date' => $this->_startdate,
			  'End_date' => $this->_enddate,
			  'Company_description' => $this->_companydescription,
			  'Rate' => $this->_rate,
			  'User_id' => $this->_userid
			  );
			  
			  
			$where = array('User_id = ?'=>$this->_userid );
		    $variable=$this->update($data, $where);
			return $variable;
			
}
}
?>