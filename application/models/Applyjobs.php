<?php
class Application_Model_Applyjobs extends Zend_Db_Table_Abstract {
	
	protected $_name = 'Apply_jobs_Seekers';
	
	protected $_title;
	protected $_location;
	protected $_eoc;
	protected $_contact;
	protected $_description;
	protected $_userid;
	protected $_jobid;
	
	public function __set($name, $value){
		$this->$name = $value; 
	}
	
	public function applytimelimit(){
		  $user = $this->select()
                ->from(array('a' => $this->_name),array('count(*)'))
				->where("a.User_id = '$this->_userid' AND a.Job_id = '$this->_jobid'")
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
	
	
	public function jobapply(){
		$insert=array('Title'=>$this->_title,'Location'=>$this->_location,'EOC'=>$this->_eoc,'Contact'=>$this->_contact,'Description'=>$this->_description,'User_id'=>$this->_userid,'Job_id'=>$this->_jobid);
		
			$insertdata = $this->insert($insert); 
			$data = $this->select()
                ->from(array('a' => $this->_name))
				->where("a.S_id = $insertdata")
                ->setIntegrityCheck(false);
				
			$data = $this->fetchAll($data);
			if ($data) {
				return $data->toArray();
			} else {
				return false;
			}
	}
	
	
}
?>