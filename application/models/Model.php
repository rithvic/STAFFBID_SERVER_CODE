<?php
class Application_Model_Model extends Zend_Db_Table_Abstract {
	
	protected $_name = ‘Apply_jobseekers_jobs’;
	
	protected $_FromDate;
	protected $_ToDate;
	protected $_Job;

	
		
	public function __set($name, $value){
		$this->$name = $value; 
	}
	
	public function task(){
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
	

	
	public function employeeprofile($User_id){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$result = $db->query($final);
		$finalresult =  $result->fetchAll();
		return $finalresult;
	}
}
?>