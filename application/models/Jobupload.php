<?php
class Application_Model_Jobupload extends Zend_Db_Table_Abstract {
	
	protected $_name = 'Job_details';
	
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
	
	public function jobupload(){
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
	
	public function getuploadedjobs(){
		$data = $this->select()
                ->from(array('a' => $this->_name))
                ->setIntegrityCheck(false);
				
			$data = $this->fetchAll($data);
			if ($data) {
				return $data->toArray();
			} else {
				return false;
			}
	}
	
	public function userjoblist(){
		$data = $this->select()
                ->from(array('a' => $this->_name))
				->where("a.User_id = '$this->_userid'")
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