<?php
class Application_Model_Jobseeker extends Zend_Db_Table_Abstract {
	
	protected $_name = 'Jobseeker_informations';
	protected $_id;
	
	protected $_brandname;
	protected $_companynumber;
	protected $_vat_number;
	protected $_contactname;
	
	protected $_phone;
	protected $_address_line_1;
	protected $_address_line_2;
	protected $_startdate;
	protected $_enddate;
	protected $_company_description;
	protected $_rate;
	protected $_userid;
	
	public function __set($name, $value){
		$this->$name = $value; 
	}
	
	public function useridcountjobseeker(){
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
	
	public function secondleveljobseeker(){
			$insert=array('Brand_name'=>$this->_brandname,'Company_number'=>$this->_companynumber,'VAT_number'=>$this->_vat_number,'Contact_name'=>$this->_contactname,'Phone_number'=>$this->_phone,'Address_line_1'=>$this->_address_line_1,'Address_line_2'=>$this->_address_line_2,'Start_date'=>$this->_startdate,'End_date'=>$this->_enddate,'Company_description'=>$this->_company_description,'Rate'=>$this->_rate,'User_id'=>$this->_userid);
		
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
	
	public function jobseekerprofile($User_id){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$final = "select Jobseeker_informations.Brand_name,Jobseeker_informations.Company_number,Jobseeker_informations.VAT_number,Jobseeker_informations.Contact_name,Jobseeker_informations.Phone_number,Jobseeker_informations.Address_line_1,Jobseeker_informations.Address_line_2,Jobseeker_informations.Start_date,Jobseeker_informations.End_date,Jobseeker_informations.Company_description,Jobseeker_informations.Rate,User_Information.Name,User_Information.Email,User_Information.User_Id,User_Information.Type from Jobseeker_informations INNER JOIN User_Information ON User_Information.User_Id = Jobseeker_informations.User_id WHERE Jobseeker_informations.User_id='$User_id'";
		$result = $db->query($final);
		$finalresult =  $result->fetchAll();
		return $finalresult;
	}
}
?>