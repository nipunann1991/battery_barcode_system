<?php

include 'CommonController.php';

defined('BASEPATH') OR exit('No direct script access allowed');

class CategoryController extends CommonController {

	function __construct() {
		parent::__construct(); 
		$this->load->model('commonQueryModel'); 
	}


	public function getCategories(){  
       return $this->getAllData__('categories');    
    }


    public function getLastIndex(){ 
		
		$search_index = array(
			'table' => 'categories' ,   
			'search_index' => 'id',
		);

		return $this->selectLastIndex__($search_index);
       
    }


    public function getSingleCategory(){

    	$search_index = array(
			'columns' => '*' ,   
			'table' => 'categories',
			'data' => 'id= "'.$this->input->post('id').'"',
		);

		return $this->selectCustomData__($search_index);
 
    }


    public function addCategories(){

		$dataset = $this->input->post();
		return $this->insertData__('categories', $dataset); 
	}
 	

 	public function deleteCategories(){

		$dataset = $this->input->post(); 
		return $this->deleteData__('categories', " id =".$dataset['id']);
 
	}


	public function updateCategories(){ 

		$dataset = $this->input->post(); 
		return $this->updateData__('categories', $dataset, " id =".$dataset['id']);
 
	}




	

	 

}

