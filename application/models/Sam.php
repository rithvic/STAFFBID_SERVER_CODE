<?php	
class Application_Model_Sam extends Zend_Db_Table_Abstract {
	
	protected $_name = 'Apply_jobseekers_jobs';
	protected $_startdate;
	protected $_enddate;
	protected $_title;
	
	
	
	public function __set($name, $value){
		$this->$name = $value; 
	}
	
	public function flow($Title,$Start_date,$End_date){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();	
		$Query = "Select * from Apply_jobseekers_jobs where";
		
		if($Title!='All' && $Title!=null){
			$Query =$Query." Apply_jobseekers_jobs.Title";
		}
		else if($Start_date!='All' && $Start_date!=null || $End_date!='All' && $End_date!=null) {
			$Query =$Query."Apply_jobseekers_jobs.Start_date <= '$Start_date' AND Apply_jobseekers_jobs.End_date >= '$End_date'";
		}
		
		$result = $db->query($Title);
		$finalresult =  $result->fetchAll();
		//return $finalresult;
		echo json_encode($finalresult);
				
 /*  $dataa = $this->select()
              ->from(array('a' => $this->_name))
			//->where("a.Start_date>='$this->_startdate' AND a.End_date<='$this->_enddate'")
			->setIntegrityCheck(false);
			$data=$this->fetchAll($dataa);
		$data1=$data->toArray();
        if ($data1) {
            return true;
        } else {
            return false;
        } */
			
		
}

		public function search($Title,$Start_date,$End_date){
		$db =Zend_Db_Table_Abstract::getDefaultAdapter();
		$query = "SELECT * FROM Apply_jobseekers_jobs WHERE";
		
		if($Title!='All' && $Title!=null){
			$query=$query." Apply_jobseekers_jobs.Title='$Title'";
		}
		
		else if($Start_date!='All' && $Start_date!=null && $End_date!='All' && $End_date!=null){
			$query=$query." Apply_jobseekers_jobs.Start_date >= '$Start_date' AND Apply_jobseekers_jobs.End_date <= '$End_date'";
		}
		$result = $db->query($query);
		$finalresult =  $result->fetchAll();
		return $finalresult; 
		//echo json_encode($finalresult); 
		
		/* $dataa = $this->select()
              ->from(array('a' => $this->_name))
			->where("a.Start_date>='$this->_startdate' AND a.End_date<='$this->_enddate' OR a.Title=")
			->setIntegrityCheck(false);
			$data=$this->fetchAll($dataa);
		$data1=$data->toArray();
        if ($data1) {
            return $data1;
        } else {
            return false;
        } */
		}
	
}
?>