<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class commoncontroller extends CI_Controller { 

	function __construct() {
		parent::__construct(); 
		$this->load->model('commonQueryModel'); 
	}


	public function getAllData__($table_name){

        $data["results"] = $this->commonQueryModel->selectAllData($table_name); 
        return $this->output->set_output(json_encode($data["results"], JSON_PRETTY_PRINT));

    }


    public function getAllDataDT__($table_name){

        $data["results"] = $this->commonQueryModel->selectAllDataDT($table_name); 
        return $data["results"];

    }

    public function selectCustomData__($search_index){

        $data["results"] = $this->commonQueryModel->selectCustomData($search_index); 
        return $this->output->set_output(json_encode($data["results"], JSON_PRETTY_PRINT));

        
    }


    public function getLoginData__($search_index){

       	return $this->commonQueryModel->selectCustomData($search_index); 
        
    }


    public function getAutoIncrementID__($table){

        $data["results"] = $this->commonQueryModel->getAutoIncrementID($table); 
        return $this->output->set_output(json_encode($data["results"], JSON_PRETTY_PRINT));

        
    }


    

    public function selectLastIndex__($search_index){

        $data["results"] = $this->commonQueryModel->selectLastIndex($search_index); 
        return $this->output->set_output(json_encode($data["results"], JSON_PRETTY_PRINT));
        
    }


    public function insertData__($table, $dataset){

    	$insert_vals = $this->getFilterdData($table, $dataset); 

		$data["results"] = $this->commonQueryModel->insertData($insert_vals);
		return $this->output->set_output(json_encode($data["results"], JSON_PRETTY_PRINT));
    }


    
    public function getTotalRows__($table){

    	$search_count = array(
			'table' => $table,
		);
 
		$data["results"] = $this->commonQueryModel->getTotalRows($search_count);
		return $this->output->set_output(json_encode($data["results"], JSON_PRETTY_PRINT));
    }

   	
   	public function updateData__($table, $dataset, $where){

    	$update_val = array(
			'table' => $table,  
			'values' => $this->setDataUpdateQuery($dataset),
			'data' => $where,
		);
 
		$data["results"] = $this->commonQueryModel->updateData($update_val);
		return $this->output->set_output(json_encode($data["results"], JSON_PRETTY_PRINT));
    }


   

    public function deleteData__($table, $where){

    	$delete_val = array(
			'table' => $table ,  
			'data' => $where,
		);

		$data["results"] = $this->commonQueryModel->deleteData($delete_val);
		return $this->output->set_output(json_encode($data["results"], JSON_PRETTY_PRINT));
    }

    


	private function getFilterdData($table, $dataset){

		$columns = array(); $values = array();
 

		$get_columns = array_keys($dataset);
		$get_values = array_values($dataset);
		

		foreach ($get_columns as $value) { 
			array_push($columns, "`".$value."`");
		}

		foreach ($get_values as $value) { 
			array_push($values, "'".$value."'");
		}
 

		$insert_vals = array(
			'table' => $table, 
			'columns' => implode(", ",$columns),
			'values' => implode(", ",$values) ,
		);  

		return $insert_vals;
	}


	private function setDataUpdateQuery($dataset){
		$values = '';
		$insert_vals =  array();

		$get_columns = array_keys($dataset);
		$get_values = array_values($dataset);

		for ($i=0; $i <  sizeof($get_columns) ; $i++) { 
			 
			if ($i == 0) {
				$values = "`".$get_columns[$i]."`='".$get_values[$i]."'";
			}else{
				$values = $values.",`".$get_columns[$i]."`='".$get_values[$i]."'";
			}
		}


		return $values;

	}


}

