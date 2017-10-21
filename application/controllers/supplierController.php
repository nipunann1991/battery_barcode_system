<?php

include 'commonController.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class SupplierController extends CommonController {

	function __construct() {
		parent::__construct(); 
		$this->load->model('commonQueryModel'); 
	}

	public function getLoginCredentials(){   

        $search_index = array(
			'columns' => 'l.*, r.role_name' ,   
			'table' => 'login l, roles r',
			'data' => 'username= "'.$this->input->post('username').'" AND password= "'.md5($this->input->post('password')).'" AND l.role_id = r.role_id',
		);

		return $this->selectCustomData__($search_index);   
    }

    public function getSuppliers(){  
       return $this->getAllData__('supplier');    
    }

     
    public function getSingleSupplier(){

    	$search_index = array(
			'columns' => '*' ,   
			'table' => 'supplier',
			'data' => 'sup_id= "'.$this->input->post('sup_id').'"',
		); 
		
       return $this->selectCustomData__($search_index);
    } 


    public function getSupplierList(){

    	$search_index = array(
			'columns' => '`sup_id`, `sup_name`' ,   
			'table' => 'supplier',
			'data' => '1',
		);

       return $this->selectCustomData__($search_index);
    } 


    public function getLastIndex(){
 
		$search_index = array(
			'table' => 'supplier' ,   
			'search_index' => 'sup_id',
		);

      	return $this->selectLastIndex__($search_index);
    }


    public function addSupplier(){

		$dataset = $this->input->post(); 
		return $this->insertData__('supplier', $dataset); 
		
	}
 
	   

	public function updateSupplier(){ 

		$dataset = $this->input->post();  
		return $this->updateData__('supplier', $dataset, " sup_id =".$dataset['sup_id']); 

	}


	public function deleteSupplier(){

		$dataset = $this->input->post();  
		return $this->deleteData__('supplier', " sup_id =".$dataset['sup_id']);

	}
	

 

}