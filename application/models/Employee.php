<?php
class Application_Model_Employee extends Zend_Db_Table_Abstract {
	
	protected $_name = 'Employee_informations';
	protected $_id;
	
	protected $_firstname;
	protected $_lastname;
	protected $_dateofbirth;
	protected $_phone;
	
	protected $_companyname;
	protected $_jobrole;
	protected $_startdate;
	protected $_enddate;
	protected $_description;
	protected $_rate;
	protected $_userid;
	
	public function __set($name, $value){
		$this->$name = $value; 
	}
	
	public function useridcount(){
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
	
	public function secondlevel(){
			$insert=array('Firstname'=>$this->_firstname,'Lastname'=>$this->_lastname,'Dateofbirth'=>$this->_dateofbirth,'Mobile_number'=>$this->_phone,'Company_name'=>$this->_companyname,'Job_role'=>$this->_jobrole,'Start_date'=>$this->_startdate,'End_date'=>$this->_enddate,'Description'=>$this->_description,'Rate'=>$this->_rate,'User_id'=>$this->_userid);
		
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
	
	public function employeeprofile($User_id){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$final = "select Employee_informations.Firstname,Employee_informations.Lastname,Employee_informations.Dateofbirth,Employee_informations.Mobile_number,Employee_informations.Company_name,Employee_informations.Job_role,Employee_informations.Start_date,Employee_informations.End_date,Employee_informations.Description,Employee_informations.Rate,User_Information.Name,User_Information.Email,User_Information.User_Id,User_Information.Type from Employee_informations INNER JOIN User_Information ON User_Information.User_Id = Employee_informations.User_id WHERE Employee_informations.User_id='$User_id'";
		$result = $db->query($final);
		$finalresult =  $result->fetchAll();
		return $finalresult;
	}
}
?>